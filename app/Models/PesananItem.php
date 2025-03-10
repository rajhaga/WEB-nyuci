<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    use HasFactory;

    // Define the table name if different from default (pluralized model name)
    protected $table = 'pesanan_item';
    public $timestamps = false; // Disable timestamps

    // Fillable attributes
    protected $fillable = [
        'pesanan_id',  // Foreign key to the 'pesanan' table
        'item_id',     // Foreign key to the 'jenis_pakaian' table
        'jumlah',      // Quantity of the item
    ];

    // Relationship with Pesanan (Order)
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    // Relationship with JenisPakaian (Clothing Item)
    public function jenisPakaian()
    {
        return $this->belongsTo(JenisPakaian::class, 'item_id');
    }

    // Optionally, calculate the cost for this item based on its quantity and price
    public function getTotalCostAttribute()
    {
        return $this->jumlah * $this->jenisPakaian->pivot->price;  // Assuming price is in the pivot table
    }
}
