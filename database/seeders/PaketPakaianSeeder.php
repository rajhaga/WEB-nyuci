<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketPakaianSeeder extends Seeder
{
    public function run()
    {
        DB::table('paket_pakaians')->insert([
            ['nama' => 'Paket Pakaian'],
            ['nama' => 'Paket Rumah Tangga & Hotel'],
            ['nama' => 'Paket Sepatu & Aksesoris'],
        ]);
    }
}
