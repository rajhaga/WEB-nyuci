<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\{Auth, Storage, Log, DB};
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Notifications\NewOrderNotification;
use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\CoreApi;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $pesanan = Pesanan::with(['mitra', 'pesananItems.jenisPakaian'])
                         ->where('pembeli_id', Auth::id())
                         ->when($request->status, fn($q, $status) => $q->where('status', $status))
                         ->latest()
                         ->get();

        return view('pesanan.index', compact('pesanan'));
    }

    public function showQRIS(Pesanan $pesanan)
    {
        $this->authorize('view', $pesanan);

        if (!$pesanan->midtrans_transaction_id) {
            $this->generateQRIS($pesanan);
            $pesanan->refresh();
        }

        return view('pesanan.qris', compact('pesanan'));
    }


    protected function generateQRIS(Pesanan $pesanan)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        $totalPembayaran = $pesanan->total_harga + 8000;

        $params = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => 'LAUNDRY-' . $pesanan->id . '-' . time(),
                'gross_amount' => $totalPembayaran// Konversi ke float
                // 'gross_amount' => '10.000' // Konversi ke float
            ],
            'customer_details' => [
                'first_name' => $pesanan->pembeli->name,
                'email' => $pesanan->pembeli->email,
                'phone' => $pesanan->pembeli->phone,
            ],
            'qris' => [
                'acquirer' => 'gopay' // bisa diganti linkaja/shopeepay
            ]
        ];

        try {
            $response = CoreApi::charge($params);
            
            $qrPath = 'qris/' . $pesanan->id . '.png';
            Storage::put('public/' . $qrPath, QrCode::format('png')
                ->size(300)
                ->generate($response->actions[0]->url));

            $pesanan->update([
                'total_harga' => $totalPembayaran,
                'midtrans_order_id' => $response->order_id,
                'midtrans_transaction_id' => $response->transaction_id,
                'qris_image' => $qrPath,
                'status' => 'Diproses'
            ]);

        } catch (\Exception $e) {
            Log::error('QRIS Generation Error: ' . $e->getMessage());
            abort(500, 'Gagal generate QRIS');
        }
    }
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'];

        $pesanan = Pesanan::where('midtrans_order_id', $orderId)->firstOrFail();

        switch ($payload['transaction_status']) {
            case 'settlement':
                $pesanan->update(['status' => 'paid', 'paid_at' => now()]);
                break;
            case 'expire':
                $pesanan->update(['status' => 'expired']);
                break;
        }

        return response()->json(['status' => 'success']);
    }
    protected function checkPaymentStatus(Pesanan $pesanan)
{
    if (!$pesanan->midtrans_transaction_id) {
        return;
    }

    try {
        // Configure Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        
        // PERBAIKAN: Gunakan Transaction::status() bukan CoreApi::status()
        $status = \Midtrans\Transaction::status($pesanan->midtrans_transaction_id);
        
        // Handle various status cases
        switch ($status->transaction_status) {
            case 'settlement':
            case 'capture':
                $pesanan->update([
                    'status' => 'paid',
                    'paid_at' => now()
                ]);
                
                if (!$pesanan->payment_notified) {
                    $pesanan->mitra->user->notify(new NewOrderNotification($pesanan));
                    $pesanan->update(['payment_notified' => true]);
                }
                break;
                
            case 'pending':
                // No action needed for pending status
                break;
                
            case 'deny':
            case 'cancel':
            case 'expire':
                $pesanan->update(['status' => 'failed']);
                break;

            // Tambahkan case untuk status lainnya jika diperlukan
            case 'refund':
            case 'partial_refund':
                $pesanan->update(['status' => 'refunded']);
                break;
        }
        
    } catch (\Exception $e) {
        Log::error("Payment status check failed for transaction {$pesanan->midtrans_transaction_id}: ".$e->getMessage());
        // Notifikasi admin atau sistem monitoring
    }
}

public function konfirmasiPembayaran(Pesanan $pesanan)
{
    $this->authorize('update', $pesanan);

    try {
        // Check if the payment is done via QRIS or COD
        if ($pesanan->metode_pembayaran === 'qris') {
            // Verifying the payment via Midtrans for QRIS
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            
            $status = Transaction::status($pesanan->midtrans_transaction_id);

            if ($status->transaction_status === 'settlement') {
                $pesanan->update([
                    'status' => 'paid',
                    'paid_at' => now()
                ]);
                
                // Redirect to admin dashboard after payment confirmation
                return redirect()->route('mitra.dashboard')->with('success', 'Pembayaran berhasil dikonfirmasi');
            }
        } else if ($pesanan->metode_pembayaran === 'cash' || $pesanan->metode_pembayaran === 'cod') {
            // If COD, directly update the status to "Diproses"
            $pesanan->update([
                'status' => 'Diproses'
            ]);

            // Redirect to admin dashboard after payment confirmation
            return redirect()->route('mitra.dashboard')->with('success', 'Pembayaran telah dikonfirmasi dan pesanan sedang diproses');
        }
        
        // Default case if not QRIS or COD
        $pesanan->update(['status' => 'Diproses']);
        
        // Redirect to admin dashboard after payment confirmation
        return redirect()->route('mitra.dashboard')->with('success', 'Pesanan sedang diproses');
        
    } catch (\Exception $e) {
        // Handle exception if any error occurs
        $pesanan->update(['status' => 'Diproses']);
        Log::error('Konfirmasi Error: ' . $e->getMessage());
        
        // Redirect to admin dashboard with error message
        return redirect()->route('mitra.dashboard')->with('error', 'Pesanan sedang diproses, tetapi terjadi kesalahan verifikasi pembayaran');
    }
}

public function showCOD(Pesanan $pesanan)
{
    $this->authorize('view', $pesanan);
    
    // Jika COD, pastikan status masih pending
    if ($pesanan->status === 'pending') {
        $pesanan->update(['status' => 'waiting_payment']);
    }

    return view('pesanan.cod', compact('pesanan'));
}
}