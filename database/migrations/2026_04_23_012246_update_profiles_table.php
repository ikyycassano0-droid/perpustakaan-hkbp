<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('type')->after('id'); // menu utama
            $table->string('sub_type')->nullable()->after('type'); // misalnya: visi / misi

            $table->string('jabatan')->nullable()->after('title'); // khusus struktur
            $table->string('icon')->nullable()->after('description'); // tugas fungsi / dll

            $table->renameColumn('sequence', 'order');

            $table->dropColumn('key');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {

            $table->string('key');
            $table->renameColumn('order', 'sequence');

            $table->dropColumn([
                'type',
                'sub_type',
                'jabatan',
                'icon'
            ]);
        });
    }
};