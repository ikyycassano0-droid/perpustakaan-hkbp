<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Update kolom image untuk tipe struktur yang belum diawali 'profiles/'
        DB::table('profiles')
            ->where('type', 'struktur')
            ->whereNotNull('image')
            ->where('image', 'not like', 'profiles/%')
            ->update([
                'image' => DB::raw("CONCAT('profiles/', image)")
            ]);
    }

    public function down()
    {
        // Rollback: hapus awalan 'profiles/' untuk data struktur
        DB::table('profiles')
            ->where('type', 'struktur')
            ->whereNotNull('image')
            ->where('image', 'like', 'profiles/%')
            ->update([
                'image' => DB::raw("SUBSTRING(image, 9)") // menghilangkan 'profiles/'
            ]);
    }
};
