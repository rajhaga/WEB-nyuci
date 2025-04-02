<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['qris', 'cod'])->default('cod')->after('total_harga');
        });
    }

    public function down()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
        });
    }
};
