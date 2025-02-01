<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitrasTable extends Migration
{
    public function up()
    {
        Schema::create('mitras', function (Blueprint $table) {
            $table->id(); // Kolom ID (primary key)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->string('nama_laundry'); // Nama usaha laundry
            $table->text('alamat'); // Alamat lengkap
            $table->string('jam_operasional'); // Jam operasional
            $table->text('layanan'); // Layanan yang disediakan
            $table->string('harga'); // Harga per kg atau per item
            $table->string('metode_pembayaran'); // Metode pembayaran
            $table->text('deskripsi'); // Deskripsi singkat
            $table->string('foto_tempat')->nullable(); // Foto tempat usaha (opsional)
            $table->string('foto_bukti')->nullable(); // Foto bukti kepemilikan (opsional)
            $table->string('lokasi')->nullable(); // Lokasi usaha (opsional)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('mitras'); // Hapus tabel jika migration di-rollback
    }
}