<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // =========================
            // INDEX (PERFORMANCE)
            // =========================
            $table->index('role_id');
            $table->index('active');
            $table->index('name');

            // =========================
            // OPTIONAL SAFETY IMPROVEMENT
            // =========================

            // memastikan phone lebih fleksibel untuk angka panjang
            $table->string('phone', 20)->nullable()->change();

            // pastikan gender konsisten (tetap sama logic MALE/FEMALE)
            // tidak diubah karena sudah enum di migration lama

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // drop index
            $table->dropIndex(['role_id']);
            $table->dropIndex(['active']);
            $table->dropIndex(['name']);

            // rollback change phone (balik ke default lama jika perlu)
            $table->string('phone', 20)->nullable()->change();
        });
    }
};