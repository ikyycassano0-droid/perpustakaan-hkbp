<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();

            // 🔗 Relasi
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('collection_id');

            // 🔢 Jumlah
            $table->unsignedInteger('qty')->default(1);

            $table->timestamps();

            // 🔐 Foreign Key
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete();

            $table->foreign('collection_id')
                ->references('id')
                ->on('collections')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};