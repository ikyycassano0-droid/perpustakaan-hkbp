<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('series_title')->nullable();

            $table->json('author')->nullable();
            $table->json('responsibility_statement')->nullable();
            $table->json('content_type')->nullable();
            $table->json('media_type')->nullable();

            $table->string('publisher')->nullable();
            $table->year('publication_year')->nullable();
            $table->string('language')->nullable();
            $table->string('isbn')->nullable();
            $table->string('edition')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();

            $table->string('carrier_type')->nullable();
            $table->text('specific_detail_info')->nullable();

            // ❌ HAPUS INI
            // classification_id
            // category_collection_id

            $table->unsignedBigInteger('location_id')->nullable();

            $table->string('file_url')->nullable();
            $table->string('format')->nullable();
            $table->string('cover_image')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('location_id')
                ->references('id')->on('locations')
                ->nullOnDelete();

            $table->index('title');
            $table->index('isbn');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};