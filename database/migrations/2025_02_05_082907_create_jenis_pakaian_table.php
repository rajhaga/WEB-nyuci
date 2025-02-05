<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('jenis_pakaian', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Contoh: baju, celana, jaket, dll.
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_pakaian');
    }
};
