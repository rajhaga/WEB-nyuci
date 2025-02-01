<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_laundry',
        'alamat',
        'jam_operasional',
        'layanan',
        'harga',
        'metode_pembayaran',
        'deskripsi',
        'foto_tempat',
        'foto_bukti',
        'lokasi',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
