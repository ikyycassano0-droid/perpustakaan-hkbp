<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // =========================
            // INDEX (PERFORMANCE)
            // =========================
            $table->index('role_id');
            $table->index('active');
            $table->index('name');

            // =========================
            // SAFETY IMPROVEMENT
            // =========================
            $table->string('phone', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // =========================
            // DROP INDEX (AMAN)
            // =========================

            $table->dropIndex(['role_id']);
            $table->dropIndex(['active']);
            $table->dropIndex(['name']);

            // =========================
            // REVERT PHONE CHANGE
            // =========================
            $table->string('phone')->nullable()->change();
        });
    }
};