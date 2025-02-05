<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;
    protected $table = 'mitra'; // Pastikan ini ada

    protected $fillable = [
        'user_id', 'nama_pemilik', 'nomor_hp','nama_laundry', 'alamat', 'jam_operasional', 
        'layanan', 'harga', 'metode_pembayaran', 'deskripsi', 
        'foto_tempat', 'foto_bukti', 'lokasi', 'kategori_layanan',
        'rating', 'jumlah_ulasan', 'latitude', 'longitude'
    ];

    // app/Models/Mitra.php

public function jenisPakaian()
{
    return $this->belongsToMany(JenisPakaian::class, 'mitra_jenis_pakaian', 'mitra_id', 'jenis_pakaian_id');
}


}
