<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id(); // Auto-incremented ID field
            $table->string('nama'); // Name of the user
            $table->string('email')->unique(); // Email field, unique
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->string('password'); // Password field
            $table->enum('role', ['pembeli', 'mitra', 'admin'])->default('pembeli'); // Role field with default 'pembeli'
            $table->string('phone')->unique(); // Phone number, unique
            $table->rememberToken(); // Used for "remember me" functionality
            $table->enum('status', ['pending', 'verified', 'ditolak'])->default('pending'); // Status field
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
};
