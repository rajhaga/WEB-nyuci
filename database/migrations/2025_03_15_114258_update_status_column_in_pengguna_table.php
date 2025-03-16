<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class UpdateStatusColumnInPenggunaTable extends Migration
// {
//     public function up()
//     {
//         Schema::table('pengguna', function (Blueprint $table) {
//             $table->enum('status', ['pending', 'verified', 'ditolak'])->nullable()->default(null)->change();
//         });
//     }

//     public function down()
//     {
//         Schema::table('pengguna', function (Blueprint $table) {
//             $table->enum('status', ['pending', 'verified', 'ditolak'])->default('pending')->change();
//         });
//     }
// }
