<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPakaian extends Model
{
    use HasFactory;

    protected $table = 'jenis_pakaian'; // Pastikan ini ada

    protected $fillable = ['nama'];

    // Relasi Many-to-Many dengan Mitra
    public function mitra()
    {
        return $this->belongsToMany(Mitra::class, 'mitra_jenis_pakaian', 'jenis_pakaian_id', 'mitra_id')
                    ->withPivot('price', 'paket_pakaian_id'); // Include price in the pivot table
    }

    // Relasi dengan PesananItem
    public function pesananItems()
    {
        return $this->hasMany(PesananItem::class, 'item_id');
    }

    // Relasi dengan PaketPakaian
    public function paketPakaian()
    {
        return $this->belongsTo(PaketPakaian::class);
    }
}
