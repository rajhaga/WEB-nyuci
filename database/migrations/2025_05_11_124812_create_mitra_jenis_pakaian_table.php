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
            $table->foreignId('mitra_id')->constrained()->onDelete('cascade');
            $table->foreignId('jenis_pakaian_id')->constrained('jenis_pakaian')->onDelete('cascade');
            $table->foreignId('paket_pakaian_id')->constrained('paket_pakaians')->onDelete('cascade');
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
            
            // Tambahkan composite unique key
            $table->unique(['mitra_id', 'jenis_pakaian_id', 'paket_pakaian_id'], 'mitra_jenis_paket_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mitra_jenis_pakaian');
    }
}
