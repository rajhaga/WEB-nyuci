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
use App\Models\Admin;


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
        // konfigurasi Midtrans
        Config::$serverKey     = config('services.midtrans.server_key');
        Config::$isProduction  = config('services.midtrans.is_production');
        Config::$isSanitized   = true;

        // fee admin per order
        $adminFeePerOrder = 8000;
        $totalPembayaran  = $pesanan->total_harga + $adminFeePerOrder;

        $params = [
            'payment_type'        => 'qris',
            'transaction_details' => [
                'order_id'     => 'LAUNDRY-' . $pesanan->id . '-' . time(),
                'gross_amount' => $totalPembayaran,
            ],
            'customer_details'    => [
                'first_name' => $pesanan->pembeli->nama,
                'email'      => $pesanan->pembeli->email,
                'phone'      => $pesanan->pembeli->phone,
            ],
            'qris' => [
                'acquirer' => 'gopay',
            ],
        ];

        try {
            DB::transaction(function() use ($pesanan, $params, $totalPembayaran, $adminFeePerOrder) {
                // charge via Midtrans
                $response = CoreApi::charge($params);
                Log::info('Midtrans QRIS Response: ', ['response' => $response]);  // Debugging the response

                // generate & simpan QR code
                $qrPath = 'qris/' . $pesanan->id . '.png';
                Storage::put(
                    'public/' . $qrPath,
                    QrCode::format('png')
                        ->size(300)
                        ->generate($response->actions[0]->url)
                );

                // update pesanan
                $pesanan->update([
                    'total_harga'            => $totalPembayaran,
                    'midtrans_order_id'      => $response->order_id,
                    'midtrans_transaction_id'=> $response->transaction_id,
                    'qris_image'             => $qrPath,
                    'status'                 => 'Diproses',
                ]);

                // catat fee ke tabel admins
                $adminUserId = 1;  // replace with actual user ID
                Admin::firstOrCreate(
                    ['user_id' => $adminUserId],
                    ['pendapatan' => 0]
                )->increment('pendapatan', $adminFeePerOrder);
            });

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

                // Add success message to session
                session()->flash('success', 'Pembayaran berhasil dikonfirmasi');

                // Redirect to admin dashboard after payment confirmation
                return redirect()->route('mitra.dashboard');
            }
        } else if ($pesanan->metode_pembayaran === 'cash' || $pesanan->metode_pembayaran === 'cod') {
            // Update the status to "Diproses"
            $pesanan->update(['status' => 'Diproses']);

            // Add success message to session
            session()->flash('success', 'Pembayaran telah dikonfirmasi dan pesanan sedang diproses (tab kelola pesanan)');

            // Redirect to admin dashboard after payment confirmation
            return redirect()->route('mitra.dashboard');
        }
        
        // Default case for other payment methods
        $pesanan->update(['status' => 'Diproses']);
        
        // Add success message to session
        session()->flash('success', 'Pesanan sedang diproses (tab kelola pesanan)');

        return redirect()->route('mitra.dashboard');
        
    } catch (\Exception $e) {
        // Handle exception if any error occurs
        Log::error('Konfirmasi Error: ' . $e->getMessage());

        // Add error message to session
        session()->flash('error', 'Pesanan sedang diproses, tetapi terjadi kesalahan verifikasi pembayaran');
        
        return redirect()->route('mitra.dashboard');
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