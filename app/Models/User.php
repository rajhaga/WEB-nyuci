<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna'; // Nama tabel pengguna

    protected $fillable = [
        'nama', 'email', 'password', 'role', 'phone', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke tabel mitras (1:1)
    public function mitra()
    {
        return $this->hasOne(Mitra::class); // Pastikan Mitra sudah didefinisikan dengan benar
    }
}
