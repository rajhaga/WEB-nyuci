<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisPakaian;

class JenisPakaianSeeder extends Seeder
{
    public function run()
    {
        $jenisPakaian = ['Baju', 'Celana', 'Jaket', 'Sprei', 'Selimut'];

        foreach ($jenisPakaian as $nama) {
            JenisPakaian::create(['nama' => $nama]);
        }
    }
}
