<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';  // Explicitly set the table name

    protected $fillable = [
        'pembeli_id',
        'mitra_id',
        'total_harga',
        'status',
        'kode_referral',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'qris_image',
        'payment_notified',
        'paid_at'
    ];
    
    // Tambahkan relasi ke PesananItem
    public function items()
    {
        return $this->hasMany(PesananItem::class, 'pesanan_id');
    }

    // Define the relationship with Pembeli (User) and Mitra (Laundry)
    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
    
    public function pesananItems()
    {
        return $this->hasMany(PesananItem::class);
    }
    
}
