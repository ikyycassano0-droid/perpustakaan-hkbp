<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // =========================
            // AUTH & IDENTITY
            // =========================
            $table->unsignedBigInteger('role_id');

            $table->string('name', 150);
            $table->string('email')->unique(); // ✅ WAJIB & UNIQUE
            $table->timestamp('email_verified_at')->nullable();

            $table->string('npm', 30)->nullable()->unique();
            $table->string('nidn', 30)->nullable();

            // =========================
            // PROFILE
            // =========================
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE'])->nullable();
            $table->string('membership_type', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('photo', 255)->nullable();

            // =========================
            // SECURITY
            // =========================
            $table->string('password', 255);
            $table->boolean('active')->default(true);

            // =========================
            // AUDIT
            // =========================
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // =========================
            // FOREIGN KEYS
            // =========================
            $table->foreign('role_id')->references('id')->on('roles');

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        // =========================
        // ADMIN DEFAULT
        // =========================
        DB::table('users')->insert([
            'id' => 1,
            'role_id' => 1,
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com', 
            'email_verified_at' => now(), 
            'npm' => '000000',
            'password' => bcrypt('admin123'),
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}