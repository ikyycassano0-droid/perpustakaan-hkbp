<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {

            // excerpt
            if (!Schema::hasColumn('news', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('title');
            }

            // category
            if (!Schema::hasColumn('news', 'category')) {
                $table->string('category')->nullable()->after('image');
            }

            // is_featured
            if (!Schema::hasColumn('news', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('category');
            }

            // button_text
            if (!Schema::hasColumn('news', 'button_text')) {
                $table->string('button_text')->nullable()->after('is_featured');
            }

            // button_action
            if (!Schema::hasColumn('news', 'button_action')) {
                $table->string('button_action')->nullable()->after('button_text');
            }

            // order
            if (!Schema::hasColumn('news', 'order')) {
                $table->integer('order')->default(1)->after('button_action');
            }

        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {

            $columns = [
                'excerpt',
                'category',
                'is_featured',
                'button_text',
                'button_action',
                'order'
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('news', $col)) {
                    $table->dropColumn($col);
                }
            }

        });
    }
};