<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade'); // Foreign key linking to 'pengguna' table
            $table->string('nama_pemilik');
            $table->string('nomor_hp');
            $table->string('nama_laundry');
            $table->text('alamat');
            $table->string('jam_operasional');
            $table->decimal('harga', 10, 2);
            // $table->string('metode_pembayaran'); 
            $table->string('id_pembayaran')->nullable(); // ID pembayaran tambahan
            $table->string('nomor_rekening')->nullable(); // Nomor rekening tambahan
            $table->text('deskripsi');
            $table->string('foto_tempat')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->enum('kategori_layanan', ['cuci', 'setrika', 'cuci dan setrika']);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('jumlah_ulasan')->default(0);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mitras');
    }
};
