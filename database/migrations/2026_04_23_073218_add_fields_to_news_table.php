<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {

            // Tambahan field sesuai kebutuhan UI kamu
            $table->text('excerpt')->nullable()->after('title');
            $table->string('category')->nullable()->after('image');

            $table->boolean('is_featured')->default(false)->after('category');
            $table->string('button_text')->nullable()->after('is_featured');
            $table->string('button_action')->nullable()->after('button_text');

            $table->integer('order')->default(1)->after('button_action');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn([
                'excerpt',
                'category',
                'is_featured',
                'button_text',
                'button_action',
                'order'
            ]);
        });
    }
};