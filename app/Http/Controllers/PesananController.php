<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Midtrans\Config;
use Midtrans\CoreApi;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Midtrans\Transaction;

class PesananController extends Controller
{
    // Tampilkan QRIS
    public function showQRIS(Pesanan $pesanan)
    {
        $this->authorize('view', $pesanan);

        // Jika belum ada transaksi atau sudah expired, generate baru
        if (!$pesanan->midtrans_transaction_id || $pesanan->isExpired()) {
            try {
                $this->generateQRIS($pesanan);
                $pesanan->refresh();
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        }
        // // Generate unique order ID
        // $orderId = 'LAUNDRY-' . $pesanan->id . '-' . now()->format('YmdHis');
        
        // // Pastikan minimal amount Rp10.000 (syarat QRIS)
        // $totalPembayaran = max($pesanan->total_harga , 10000);
        // $params = [
        //     'payment_type' => 'qris',
        //     'transaction_details' => [
        //         'order_id' => $orderId,
        //         'gross_amount' => $totalPembayaran,
        //     ],
        //     'customer_details' => [
        //         'first_name' => substr($pesanan->pembeli->nama, 0, 50),
        //         'email' => $pesanan->pembeli->email,
        //         'phone' => $pesanan->pembeli->phone,
        //     ],
        //     'qris' => [
        //         'acquirer' => 'gopay' // bisa diganti dengan bank tertentu
        //     ],
        //     'custom_expiry' => [
        //         'expiry_duration' => 24,
        //         'unit' => 'hour'
        //     ]
        // ];
        // dd($params);

        return view('pesanan.qris', [
            'pesanan' => $pesanan,
            'qr_code' => $pesanan->getQrCodeImageAttribute()
        ]);
    }

    protected function generateQRIS(Pesanan $pesanan)
    {
        if ($pesanan->isPaid()) {
            throw new \Exception('Pesanan sudah dibayar');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-Oy75m-HUjXpVMmgaDMQ_uJ_3');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = false;

        // Generate unique order ID
        $orderId = 'LAUNDRY-' . $pesanan->id . '-' . now()->format('YmdHis');
        
        // Pastikan minimal amount Rp10.000 (syarat QRIS)
        $totalPembayaran = max($pesanan->total_harga , 10000);

        $params = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPembayaran,
            ],
            'customer_details' => [
                'first_name' => substr($pesanan->pembeli->nama, 0, 50),
                'email' => $pesanan->pembeli->email,
                'phone' => $pesanan->pembeli->phone,
            ],
            'qris' => [
                'acquirer' => 'gopay' // bisa diganti dengan bank tertentu
            ],
            'custom_expiry' => [
                'expiry_duration' => 24,
                'unit' => 'hour'
            ]
        ];

        try {
            $response = CoreApi::charge($params);

            Log::info('Midtrans QRIS Response:', (array)$response);

            if ($response->status_code !== '201') {
                throw new \Exception($response->status_message ?? 'Transaksi gagal dibuat');
            }

            // Pastikan response mengandung data QRIS
            if (empty($response->qr_string)) {
                throw new \Exception('Response QRIS tidak valid');
            }
            $qrisUrl = is_object($response->actions[0]) 
                        ? $response->actions[0]->url 
                        : $response->actions[0]['url'];
            $pesanan->update([
                'midtrans_order_id' => $orderId,
                'midtrans_transaction_id' => $response->transaction_id,
                'qris_url' => $qrisUrl,
                'qris_string' => $response->qr_string,
                'payment_expiry' => $response->expiry_time ?? now()->addHours(24),
                'status_pembayaran' => 'pending',
                'status' => 'Diterima'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal generate QRIS: ' . $e->getMessage(), [
                'pesanan_id' => $pesanan->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Pembayaran gagal diproses: ' . $e->getMessage());
        }
    }

    // Endpoint untuk menerima notifikasi dari Midtrans
    // app/Http/Controllers/PembayaranController.php
public function handleNotification(Request $request)
{
    // Ambil payload sebagai array
    $payload = $request->all();
    
    // Debug log
    Log::info('Midtrans Notification Received:', $payload);

    // Verifikasi signature key
    $serverKey = config('services.midtrans.server_key');
    $hashed = hash('sha512', 
        $payload['order_id'] . 
        $payload['status_code'] . 
        $payload['gross_amount'] . 
        $serverKey);

    if ($hashed !== $payload['signature_key']) {
        Log::error('Invalid signature', [
            'received' => $payload['signature_key'],
            'calculated' => $hashed
        ]);
        return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
    }

    $orderId = $payload['order_id'];
    $transactionStatus = strtolower($payload['transaction_status']);
    $fraudStatus = isset($payload['fraud_status']) ? strtolower($payload['fraud_status']) : null;

    // Cari pesanan dengan logging
    $pesanan = Pesanan::where('midtrans_order_id', $orderId)->first();
    
    if (!$pesanan) {
        Log::error('Order not found', ['order_id' => $orderId]);
        return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
    }

    Log::info('Current Order Status:', [
        'before' => [
            'status_pembayaran' => $pesanan->status_pembayaran,
            'status' => $pesanan->status
        ]
    ]);

    // Update status
    switch ($transactionStatus) {
        case 'capture':
            if ($fraudStatus === 'accept') {
                $this->markAsPaid($pesanan);
            }
            break;
            
        case 'settlement':
            $this->markAsPaid($pesanan);
            break;
            
        case 'pending':
            $pesanan->update([
                'status_pembayaran' => 'pending',
                'status' => 'Diterima' // Ubah ke 'Diterima' jika pending
            ]);
            break;
            
        case 'expire':
            $pesanan->update([
                'status_pembayaran' => 'expired',
                'status' => 'Dibatalkan'
            ]);
            break;
            
        case 'cancel':
        case 'deny':
            $pesanan->update([
                'status_pembayaran' => $transactionStatus,
                'status' => 'Dibatalkan'
            ]);
            break;
    }

    // Log setelah update
    Log::info('Order Status Updated:', [
        'after' => [
            'status_pembayaran' => $pesanan->fresh()->status_pembayaran,
            'status' => $pesanan->fresh()->status
        ]
    ]);

    return response()->json(['status' => 'success']);
}

protected function markAsPaid($pesanan)
{
    $pesanan->update([
        'status_pembayaran' => 'paid',
        'status' => 'Diproses',
        'tanggal_pembayaran' => now()
    ]);
    
    // // Dispatch event jika diperlukan
    // event(new PesananPaid($pesanan));
    
    Log::info('Pesanan marked as paid:', ['pesanan_id' => $pesanan->id]);
}

public function checkPayment(Pesanan $pesanan)
{
    $this->authorize('view', $pesanan);

    try {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        
        $status = \Midtrans\Transaction::status($pesanan->midtrans_transaction_id);
        
        return response()->json([
            'status' => 'success',
            'data' => $status,
            'order_status' => $pesanan->status,
            'payment_status' => $pesanan->status_pembayaran
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
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