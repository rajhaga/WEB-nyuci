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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_pemilik');
            $table->string('nomor_hp');
            $table->string('nama_laundry');
            $table->text('alamat');
            $table->string('jam_operasional');
            $table->text('layanan');
            $table->string('harga');
            $table->string('metode_pembayaran');
            $table->text('deskripsi');
            $table->string('foto_tempat')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
