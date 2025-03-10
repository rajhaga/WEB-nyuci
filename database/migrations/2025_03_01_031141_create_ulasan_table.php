<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlasanTable extends Migration
{
    public function up()
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id(); // Auto-incremented ID
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade'); // Foreign key from 'pesanan'
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade'); // Foreign key from 'pengguna'
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade'); // Foreign key from 'mitra'
            $table->integer('rating')->check('rating >= 1 and rating <= 5'); // Rating between 1 and 5
            $table->text('komentar')->nullable(); // Optional comment
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('ulasan');
    }
}
