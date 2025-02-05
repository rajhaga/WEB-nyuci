<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPakaian extends Model
{
    use HasFactory;

    protected $table = 'jenis_pakaian'; // Pastikan ini ada

    protected $fillable = ['nama'];


public function mitras()
{
    return $this->belongsToMany(Mitra::class, 'mitra_jenis_pakaian', 'jenis_pakaian_id', 'mitra_id');
}


}
