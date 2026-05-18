<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('final_projects', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('final_projects', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['user_id']);

            // Baru hapus kolom
            $table->dropColumn('user_id');
        });
    }
};
