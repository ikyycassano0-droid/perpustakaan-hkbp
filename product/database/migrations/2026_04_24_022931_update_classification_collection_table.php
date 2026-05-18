<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 🔥 hapus duplicate dulu
        DB::statement("
            DELETE t1 FROM classification_collection t1
            JOIN classification_collection t2 
            ON t1.collection_id = t2.collection_id 
            AND t1.classification_id = t2.classification_id
            AND t1.id > t2.id
        ");

        Schema::table('classification_collection', function (Blueprint $table) {
            $table->unique(['collection_id', 'classification_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('classification_collection', function (Blueprint $table) {
            $table->dropUnique(['collection_id', 'classification_id']);
            $table->dropTimestamps();
        });
    }
};