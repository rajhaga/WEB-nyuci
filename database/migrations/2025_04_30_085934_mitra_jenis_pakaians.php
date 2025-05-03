<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitraJenisPakaianTable extends Migration
{
    public function up()
    {
        Schema::create('mitra_jenis_pakaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade'); // Relasi ke mitra
            $table->foreignId('jenis_pakaian_id')->constrained('jenis_pakaian')->onDelete('cascade'); // Relasi ke jenis pakaian
            $table->decimal('harga', 10, 2); // Harga untuk mitra tertentu
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mitra_jenis_pakaian');
    }
}
