<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // 🔗 Relasi ke user
            $table->unsignedBigInteger('user_id');

            // 📅 Tanggal peminjaman
            $table->date('order_date'); // tanggal pinjam
            $table->date('return_date'); // tanggal harus kembali
            $table->date('actual_return_date')->nullable(); // tanggal real kembali

            // 💸 Denda
            $table->unsignedInteger('fine')->default(0);

            // 🔁 Perpanjangan
            $table->unsignedInteger('extension_count')->default(0);

            // 🔥 Status
            $table->enum('status', [
                'PENDING',
                'APPROVED',
                'REJECTED',
                'RETURNED'
            ])->default('PENDING');

            $table->timestamps();

            // 🔐 Foreign Key
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // ⚡ Index (biar cepat)
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};