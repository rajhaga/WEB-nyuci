<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Paketresource extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paket_jenis_pakaian')->insert([
            ['jenis_pakaian_id' => 1, 'paket_pakaian_id' => 1],
            ['jenis_pakaian_id' => 2, 'paket_pakaian_id' => 1],
            ['jenis_pakaian_id' => 3, 'paket_pakaian_id' => 1],
            ['jenis_pakaian_id' => 4, 'paket_pakaian_id' => 1],
            ['jenis_pakaian_id' => 5, 'paket_pakaian_id' => 1],
            ['jenis_pakaian_id' => 6, 'paket_pakaian_id' => 1],
            ['jenis_pakaian_id' => 7, 'paket_pakaian_id' => 2],
            ['jenis_pakaian_id' => 8, 'paket_pakaian_id' => 2],
            ['jenis_pakaian_id' => 9, 'paket_pakaian_id' => 2],
            ['jenis_pakaian_id' => 10, 'paket_pakaian_id' => 2],
            ['jenis_pakaian_id' => 11, 'paket_pakaian_id' => 1],
            ['jenis_pakaian_id' => 12, 'paket_pakaian_id' => 1],
            ['jenis_pakaian_id' => 13, 'paket_pakaian_id' => 3],
            ['jenis_pakaian_id' => 14, 'paket_pakaian_id' => 3],
            ['jenis_pakaian_id' => 15, 'paket_pakaian_id' => 3],
        ]);
    }
}
