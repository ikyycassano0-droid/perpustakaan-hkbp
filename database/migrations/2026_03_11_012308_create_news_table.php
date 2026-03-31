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
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            // Data utama berita
            $table->string('title');               
            $table->text('content');               
            $table->string('image')->nullable();   

            // Status publikasi
            $table->enum('status', ['draft', 'publish'])->default('draft');

            // Status aktif (optional tambahan)
            $table->boolean('active')->default(true);

            // Tracking user
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamp otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};