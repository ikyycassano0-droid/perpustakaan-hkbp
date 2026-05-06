<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cek apakah kolom borrow_date sudah ada
            if (!Schema::hasColumn('orders', 'borrow_date')) {
                $table->date('borrow_date')->after('order_date');
            }
            
            // Cek apakah kolom extension_count sudah ada, jika ada hapus dulu
            if (Schema::hasColumn('orders', 'extension_count')) {
                $table->dropColumn('extension_count');
            }
            
            // Tambah kolom baru (jika belum ada)
            if (!Schema::hasColumn('orders', 'extension_count')) {
                $table->integer('extension_count')->default(0);
            }
            
            if (!Schema::hasColumn('orders', 'extend_days')) {
                $table->integer('extend_days')->default(0);
            }
            
            if (!Schema::hasColumn('orders', 'original_due_date')) {
                $table->date('original_due_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom jika ada
            if (Schema::hasColumn('orders', 'borrow_date')) {
                $table->dropColumn('borrow_date');
            }
            
            if (Schema::hasColumn('orders', 'extend_days')) {
                $table->dropColumn('extend_days');
            }
            
            if (Schema::hasColumn('orders', 'original_due_date')) {
                $table->dropColumn('original_due_date');
            }
            
            // Kembalikan extension_count seperti semula
            if (!Schema::hasColumn('orders', 'extension_count')) {
                $table->integer('extension_count')->default(0);
            }
        });
    }
};