<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Tambah kolom baru
        Schema::table('orders', function (Blueprint $table) {

            // 📅 tanggal penting
            $table->date('borrow_date')->nullable()->after('order_date');
            $table->date('due_date')->nullable()->after('borrow_date');

            // 🔁 perpanjangan
            $table->boolean('is_extended')->default(false)->after('extension_count');
            $table->date('extended_until')->nullable()->after('is_extended');

        });

        // ✅ Tambah enum LATE
        DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM('PENDING','APPROVED','REJECTED','RETURNED','LATE') 
            DEFAULT 'PENDING'
        ");
    }

    public function down(): void
    {
        // ❌ hapus kolom
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'borrow_date',
                'due_date',
                'is_extended',
                'extended_until'
            ]);

        });

        // ❌ kembalikan enum
        DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM('PENDING','APPROVED','REJECTED','RETURNED') 
            DEFAULT 'PENDING'
        ");
    }
};