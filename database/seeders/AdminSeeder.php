<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // Tambahkan Carbon untuk mengelola timestamp

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengguna')->insert([
            'nama' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin', // Role sebagai admin
            'phone' => '08123456789',
            'created_at' => Carbon::now(), // Timestamp saat ini
            'updated_at' => Carbon::now(), // Timestamp saat ini
        ]);
    }
}
