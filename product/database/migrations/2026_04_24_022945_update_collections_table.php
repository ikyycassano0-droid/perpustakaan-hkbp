<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 🔥 bersihkan ISBN duplicate dulu
        DB::statement("
            DELETE t1 FROM collections t1
            JOIN collections t2 
            ON t1.isbn = t2.isbn 
            AND t1.id > t2.id
            WHERE t1.isbn IS NOT NULL
        ");

        Schema::table('collections', function (Blueprint $table) {
            $table->index('menu_type');
            $table->index('keywords');
            $table->unique('isbn');
        });
    }

    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropIndex(['menu_type']);
            $table->dropIndex(['keywords']);
            $table->dropUnique(['isbn']);
        });
    }
};