<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MitraPaketPakaian extends Pivot
{
    protected $table = 'mitra_paket_pakaian';
    
    protected $fillable = [
        'mitra_id',
        'paket_pakaian_id',
    ];
    
    // Jika tidak butuh timestamps
    public $timestamps = false;
}