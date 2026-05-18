<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('category_collections', function (Blueprint $table) {
            if (!Schema::hasColumn('category_collections', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('name');
            }

            if (!Schema::hasColumn('category_collections', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }

            if (!Schema::hasColumn('category_collections', 'active')) {
                $table->boolean('active')->default(true)->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('category_collections', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description', 'active']);
        });
    }
};