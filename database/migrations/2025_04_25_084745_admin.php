<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            // FK ke pengguna.id
            $table->foreignId('user_id')
                  ->constrained('pengguna')
                  ->onDelete('cascade');
            // total pendapatan admin dari fee
            $table->decimal('pendapatan', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
