<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the pluralized model name
    protected $table = 'ulasan';

    // Fillable attributes to allow mass assignment
    protected $fillable = [
        'pesanan_id',
        'user_id',
        'mitra_id',
        'rating',
        'komentar',
    ];

    // Relationship with Pesanan (Order)
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    // Relationship with User (Customer)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Mitra (Service Provider)
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}
