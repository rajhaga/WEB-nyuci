<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id(); // Auto-incremented ID
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade'); // Foreign key referencing 'pesanan' table
            $table->enum('metode', ['cash', 'qris']); // Payment method (Cash or QRIS)
            $table->enum('status', ['Belum Dibayar', 'Dibayar'])->default('Belum Dibayar'); // Payment status
            $table->timestamp('paid_at')->nullable(); // Timestamp for when the payment was made
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
