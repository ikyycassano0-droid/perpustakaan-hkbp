<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('category_collection_collection', function (Blueprint $table) {
            $table->unique(
                ['collection_id', 'category_collection_id'],
                'cat_col_unique' // ✅ nama pendek
            );
        });
    }

    public function down(): void
    {
        Schema::table('category_collection_collection', function (Blueprint $table) {
            $table->dropUnique('cat_col_unique');
        });
    }
};