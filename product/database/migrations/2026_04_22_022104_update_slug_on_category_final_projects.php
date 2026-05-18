<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $data = [
            'E-Book' => 'ebook',
            'E-Article' => 'e-article',
            'CD' => 'cd',
            'Video' => 'video',
        ];

        foreach ($data as $name => $slug) {
            DB::table('category_final_projects')
                ->where('name', $name)
                ->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        // optional rollback
    }
};