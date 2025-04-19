<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPakaian extends Model
{
    use HasFactory;

    protected $table = 'jenis_pakaian'; // Pastikan ini ada

    protected $fillable = ['nama'];

    public function jenisPakaian()
    {
        return $this->belongsToMany(JenisPakaian::class, 'paket_jenis_pakaian', 'paket_pakaian_id', 'jenis_pakaian_id')
                    ->withPivot('price');
    }

    
    public function mitra()
{
    return $this->belongsToMany(Mitra::class, 'paket_jenis_pakaian', 'jenis_pakaian_id', 'paket_pakaian_id')
                ->withPivot('price'); // Include price in the pivot table
}

public function pesananItems()
    {
        return $this->hasMany(PesananItem::class, 'item_id');
    }

    

}
