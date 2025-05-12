<?php
// app/Models/MitraJenisPakaian.php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MitraJenisPakaian extends Pivot
{
    protected $table = 'mitra_jenis_pakaian';
    
    protected $fillable = [
        'mitra_id',
        'jenis_pakaian_id',
        'paket_pakaian_id',
        'price'
    ];
}
