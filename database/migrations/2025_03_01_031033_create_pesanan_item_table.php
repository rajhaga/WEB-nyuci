<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananItemTable extends Migration
{
    public function up()
    {
        Schema::create('pesanan_item', function (Blueprint $table) {
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade'); // Foreign key from 'pesanan'
            $table->foreignId('item_id')->constrained('jenis_pakaian')->onDelete('cascade'); // Foreign key from 'item_pakaian'
            $table->integer('jumlah'); // Quantity of the item ordered
            $table->primary(['pesanan_id', 'item_id']); // Primary key composite
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan_item');
    }
}
