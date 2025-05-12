<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitras'; // Pastikan nama tabel sesuai dengan database Anda

    // Daftar field yang dapat diisi
    protected $fillable = [
        'user_id', 'nama_pemilik', 'nomor_hp', 'nama_laundry', 'alamat', 
        'jam_operasional', 'layanan', 'harga', 'metode_pembayaran', 'deskripsi',
        'foto_tempat', 'foto_bukti', 'kategori_layanan', 'status_registration_mitra',
        'latitude', 'longitude', 'rating', 'jumlah_ulasan'
    ];

    // Relasi One-to-Many dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }
    // Relasi Many-to-Many dengan PaketPakaian
    public function paketPakaian()
    {
        return $this->belongsToMany(PaketPakaian::class, 'mitra_paket_pakaian', 'mitra_id', 'paket_pakaian_id');
    }

    // Relasi Many-to-Many dengan JenisPakaian
    public function jenisPakaian()
    {
        return $this->belongsToMany(JenisPakaian::class, 'mitra_jenis_pakaian','mitra_id', 'jenis_pakaian_id')
                    ->withPivot('price', 'paket_pakaian_id')
                    ->using(MitraJenisPakaian::class); // Buat model pivot jika perlu
; // Include price in the pivot table
    }
}
