<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';  // Explicitly set the table name



    protected $fillable = ['pembeli_id', 'mitra_id', 'total_harga', 'status'];

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
