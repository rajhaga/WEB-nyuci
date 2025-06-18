<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
USE App\Models\Pesanan;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Log;

class CheckPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-pending-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    // app/Console/Commands/CheckPendingPayments.php
    public function handle()
    {
        $pendingOrders = Pesanan::where('status_pembayaran', 'pending')
            ->where('created_at', '>', now()->subDays(1))
            ->get();

        foreach ($pendingOrders as $order) {
            try {
                $status = Transaction::status($order->midtrans_order_id);
                
                if ($status->transaction_status === 'settlement') {
                    $order->update([
                        'status_pembayaran' => 'paid',
                        'status' => 'Diproses',
                        'tanggal_pembayaran' => now()
                    ]);
                    Log::info('Manual check: Payment settled', ['order_id' => $order->id]);
                }
            } catch (\Exception $e) {
                Log::error('Manual check failed:', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
