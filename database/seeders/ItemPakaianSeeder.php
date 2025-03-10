<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemPakaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert into item_pakaian table
        DB::table('jenis_pakaian')->insert([
            ['nama' => 'Baju'],
            ['nama' => 'Celana'],
            ['nama' => 'Jaket'],
            ['nama' => 'Kaos'],
            ['nama' => 'Kemeja'],
            ['nama' => 'Blus'],
            ['nama' => 'Sepatu'],
            ['nama' => 'Tas'],
            ['nama' => 'Topi'],
            ['nama' => 'Handuk'],
            ['nama' => 'Sprei'],
            ['nama' => 'Selimut'],
            ['nama' => 'Gorden'],
            ['nama' => 'Baju Tidur'],
            ['nama' => 'Sweater'],
        ]);
    }
}
