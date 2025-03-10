<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('mitra_paket_pakaian', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade'); // Relasi ke Mitra
        $table->foreignId('paket_pakaian_id')->constrained('paket_pakaians')->onDelete('cascade'); // Relasi ke Jenis Pakaian
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('mitra_paket_pakaian');
}


};
