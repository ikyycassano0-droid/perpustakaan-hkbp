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
        Schema::create('final_projects', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('npm');
            $table->string('study_program');
            $table->string('title');
            $table->year('year')->nullable();
            $table->text('abstract')->nullable();
            $table->string('file_url')->nullable();

            // 🔥 relasi ke category
            $table->foreignId('category_final_project_id')
                ->constrained('category_final_projects')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_projects');
    }
};
