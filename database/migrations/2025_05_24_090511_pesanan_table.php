<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus tabel pesanan jika sudah ada
        Schema::dropIfExists('pesanan');

        // Buat ulang tabel pesanan
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembeli_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran', ['qris', 'cod']);
            $table->enum('status', ['Menunggu', 'Diterima', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->string('kode_referral')->nullable();

            // Tambahan untuk QRIS
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->text('qris_url')->nullable();
            $table->text('qris_string')->nullable(); // Untuk menyimpan raw QRIS data
            $table->timestamp('qris_expired_at')->nullable();
            $table->timestamp('payment_expiry')->nullable(); // Waktu kedaluwarsa

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel pesanan jika rollback
        Schema::dropIfExists('pesanan');
    }
};
