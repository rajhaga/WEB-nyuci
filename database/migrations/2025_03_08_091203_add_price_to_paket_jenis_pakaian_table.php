<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // In the migration file
public function up()
{
    Schema::table('paket_jenis_pakaian', function (Blueprint $table) {
        $table->decimal('price', 10, 2)->default(0);  // Add price column for each clothing item in each mitra
    });
}

public function down()
{
    Schema::table('paket_jenis_pakaian', function (Blueprint $table) {
        $table->dropColumn('price');  // Drop the price column if rolling back
    });
}

};
