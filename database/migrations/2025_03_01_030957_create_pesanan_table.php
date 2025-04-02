<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop the pesanan table
        Schema::dropIfExists('pesanan');

        // Recreate the pesanan table
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id(); // Auto-incremented ID
            $table->foreignId('pembeli_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
            $table->decimal('total_harga', 10, 2);
            // $table->enum('status', ['Pending', 'Dibayar', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Pending');
            $table->enum('status', ['Menunggu', 'Diterima', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            $table->string('kode_referral')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop the pesanan table if needed
        Schema::dropIfExists('pesanan');
    }
};
