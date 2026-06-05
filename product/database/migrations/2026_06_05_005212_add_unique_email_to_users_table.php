<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Hapus unique constraint pada kolom npm (karena di product tidak perlu unik,
     * cukup email yang menjadi pengenal unik untuk sinkronisasi).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus index unique pada kolom npm
            $table->dropUnique(['npm']);
        });
    }

    /**
     * Reverse the migrations.
     * Kembalikan unique constraint jika rollback.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique('npm');
        });
    }
};
