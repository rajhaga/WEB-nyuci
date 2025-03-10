<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketJenisPakaian extends Migration
{
    public function up()
    {
        Schema::create('paket_jenis_pakaian', function (Blueprint $table) {
            $table->id(); // Auto-incremented ID
            $table->foreignId('paket_pakaian_id')->constrained('paket_pakaians')->onDelete('cascade'); // Foreign key from 'paket_pakaian'
            $table->foreignId('jenis_pakaian_id')->constrained('jenis_pakaian')->onDelete('cascade'); // Foreign key from 'jenis_pakaian'
        });
    }

    public function down()
    {
        Schema::dropIfExists('paket_jenis_pakaian');
    }
}
