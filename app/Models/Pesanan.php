<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';  // Nama tabel eksplisit
    protected $casts = [
        'payment_expiry' => 'datetime',
        'total_harga' => 'decimal:2'
    ];
    protected $fillable = [
        'pembeli_id',
        'mitra_id',
        'total_harga',
        'metode_pembayaran',
        'status',
        'status_pembayaran',
        'kode_referral',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'qris_url',
        'qris_string',
        'qris_image',
        'payment_expiry'
    ];

    // ====================
    // Relasi
    // ====================
    

    public function items()
    {
        return $this->hasMany(PesananItem::class, 'pesanan_id');
    }

    public function pesananItems()
    {
        return $this->hasMany(PesananItem::class)->with('jenisPakaian', 'paketPakaian');
    }

    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id')->with('paketPakaian');
    }
    // ====================
    // Cek Status Pembayaran
    // ====================
    // Scope untuk pesanan pending
    public function scopePendingPayment($query)
    {
        return $query->where('status_pembayaran', 'pending');
    }
   // Cek status pembayaran
    public function isPaid()
    {
        return $this->status_pembayaran === 'paid';
    }

    // Cek apakah QRIS sudah expired
    public function isExpired()
    {
        return $this->payment_expiry && now()->gt($this->payment_expiry);
    }

    // Generate QR Code dari string (fallback)
    public function getQrCodeImageAttribute()
    {
        if ($this->qris_url) {
            return $this->qris_url;
        }

        if ($this->qris_string) {
            return 'data:image/png;base64,' . base64_encode(
                \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                    ->size(200)
                    ->generate($this->qris_string)
            );
        }

        return null;
    }

    // Update status pembayaran berdasarkan notifikasi Midtrans
    public function updatePaymentStatus($transactionStatus, $fraudStatus = null)
    {
        if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
            $this->update([
                'status_pembayaran' => 'paid',
                'status' => 'Diproses'
            ]);
        } elseif ($transactionStatus === 'settlement') {
            $this->update([
                'status_pembayaran' => 'paid',
                'status' => 'Diproses'
            ]);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $this->update([
                'status_pembayaran' => 'failed',
                'status' => 'Dibatalkan'
            ]);
        }
    }
}