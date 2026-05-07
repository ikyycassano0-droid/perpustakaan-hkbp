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
        Schema::create('final_project_category_collection', function (Blueprint $table) {

            $table->id();

            $table->foreignId('final_project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_collection_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_project_category_collection');
    }
};