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
        // Tabel Users Utama
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id'); // 1: Admin, 2: Dosen, 3: Mahasiswa
            $table->string('name', 150);
            $table->string('npm', 30)->nullable(); // Khusus Mahasiswa
            $table->string('nidn', 30)->nullable(); // Khusus Dosen
            $table->date('birth_date');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('phone', 20);
            $table->string('photo', 255)->nullable();
            $table->string('password');
            
            // Kolom Audit & Status
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            // Kolom pendukung Laravel Auth
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel bawaan Laravel untuk Reset Password
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabel bawaan Laravel untuk Manajemen Session
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};