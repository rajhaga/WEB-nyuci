<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handleNotification(Request $request)
    {
        $payload = $request->all();
        
        // Verifikasi signature (penting untuk keamanan)
        $validSignature = $this->verifySignature($payload);
        if (!$validSignature) {
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        // Cari pesanan berdasarkan order_id
        $pesanan = Pesanan::where('midtrans_order_id', $payload['order_id'])->first();
        
        if (!$pesanan) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        // Update status berdasarkan notifikasi Midtrans
        switch ($payload['transaction_status']) {
            case 'settlement':
                $pesanan->update(['status' => 'paid', 'paid_at' => now()]);
                break;
            case 'expire':
                $pesanan->update(['status' => 'expired']);
                break;
            case 'cancel':
                $pesanan->update(['status' => 'canceled']);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    protected function verifySignature($payload)
    {
        $serverKey = config('services.midtrans.server_key');
        $signatureKey = $payload['signature_key'];
        
        unset($payload['signature_key']);
        
        $expectedSignature = hash('sha512', 
            $payload['order_id'].
            $payload['status_code'].
            $payload['gross_amount'].
            $serverKey
        );

        return hash_equals($expectedSignature, $signatureKey);
    }
}