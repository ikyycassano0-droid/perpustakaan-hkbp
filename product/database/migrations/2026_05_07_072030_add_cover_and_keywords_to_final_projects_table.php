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
        Schema::table('final_projects', function (Blueprint $table) {

            // ================= COVER =================
            if (!Schema::hasColumn('final_projects', 'cover_image')) {
                $table->string('cover_image')->nullable();
            }

            // ================= KEYWORDS =================
            if (!Schema::hasColumn('final_projects', 'keywords')) {
                $table->json('keywords')->nullable();
            }

            // ================= ISBN =================
            if (!Schema::hasColumn('final_projects', 'isbn')) {
                $table->string('isbn')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_projects', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('final_projects', 'cover_image')) {
                $columns[] = 'cover_image';
            }

            if (Schema::hasColumn('final_projects', 'keywords')) {
                $columns[] = 'keywords';
            }

            if (Schema::hasColumn('final_projects', 'isbn')) {
                $columns[] = 'isbn';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }

        });
    }
};