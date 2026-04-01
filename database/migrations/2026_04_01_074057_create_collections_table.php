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
            $table->string('author');
            $table->string('call_number')->nullable();
            $table->string('publisher')->nullable();
            $table->year('publication_year')->nullable();
            $table->string('language')->nullable();
            $table->string('isbn')->nullable();
            $table->string('edition')->nullable();
            $table->string('subject')->nullable();
            $table->text('description');
            $table->unsignedBigInteger('classification_id')->nullable();
            $table->unsignedBigInteger('category_collection_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('file_url')->nullable();
            $table->string('format')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('responsibility_statement')->nullable();
            $table->string('content_type')->nullable();
            $table->string('media_type')->nullable();
            $table->string('carrier_type')->nullable();
            $table->text('specific_detail_info')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('classification_id')
                ->references('id')->on('classifications')
                ->nullOnDelete();

            $table->foreign('category_collection_id')
                ->references('id')->on('category_collections')
                ->nullOnDelete();

            $table->foreign('location_id')
                ->references('id')->on('locations')
                ->nullOnDelete();

            $table->index('title');
            $table->index('author');
            $table->index('isbn');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};