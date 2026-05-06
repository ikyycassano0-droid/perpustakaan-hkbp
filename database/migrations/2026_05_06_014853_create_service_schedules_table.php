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
        Schema::create('service_schedules', function (Blueprint $table) {
            $table->id();

            // ===== IDENTITAS HARI =====
            $table->string('day_short', 5);   // Sn, Sl, Rb, dst
            $table->string('day_name', 20);   // Senin, Selasa, dst

            // ===== JAM LAYANAN =====
            $table->string('service_hours');  // "08:00 — 16:30"

            // ===== STATUS =====
            $table->string('status');         // "Layanan Penuh"
            $table->string('status_color', 20)->default('emerald'); 
            // emerald | amber | orange | rose

            // ===== CATATAN TAMBAHAN =====
            $table->string('note')->nullable(); // "Sirkulasi Aktif"

            // ===== URUTAN (PENTING!) =====
            $table->integer('order')->default(0);

            // ===== OPTIONAL (FUTURE PROOF) =====
            $table->boolean('is_active')->default(true); 
            // kalau mau disable tanpa delete

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_schedules');
    }
};