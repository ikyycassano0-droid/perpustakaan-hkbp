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
            $table->unsignedBigInteger('role_id');
            $table->string('name', 150);
            $table->string('npm', 30)->unique();
            $table->string('nidn', 30)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE'])->nullable();
            $table->string('membership_type', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('password', 255);
            $table->boolean('active')->default(true);

            // Audit columns
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // FK role
             $table->foreign('role_id')->references('id')->on('roles');

            // FK audit
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        // Insert admin default
        DB::table('users')->insert([
            'id' => 1,
            'role_id' => 1,
            'name' => 'Admin Utama',
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