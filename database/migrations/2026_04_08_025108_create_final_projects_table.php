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

            // 🔹 kolom user (nullable, validasi di Laravel)
            $table->string('student_name')->nullable();
            $table->string('npm')->nullable();
            $table->string('study_program')->nullable();
            $table->string('title')->nullable();

            $table->year('year')->nullable();
            $table->text('abstract')->nullable();
            $table->string('file_url')->nullable();

            // 🔥 relasi ke category (boleh null jika admin tidak mengisi)
            $table->foreignId('category_final_project_id')
                ->nullable()
                ->constrained('category_final_projects')
                ->onDelete('cascade');

            // 🔹 relasi supervisor
            $table->foreignId('first_supervisor_id')
                ->nullable() // wajib di user -> di-handle Laravel validation
                ->constrained('users')
                ->onDelete('set null');

            $table->foreignId('second_supervisor_id')
                ->nullable() // opsional
                ->constrained('users')
                ->onDelete('set null');

            // 🔹 kolom tambahan admin
            $table->integer('final_project_status_id')->nullable();
            $table->integer('approve_by')->nullable();
            $table->string('keywords')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('active')->default(true);

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