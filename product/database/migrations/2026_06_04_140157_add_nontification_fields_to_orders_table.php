<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('due_warning_sent')->default(false)->after('status');
            $table->timestamp('fine_notification_sent_at')->nullable()->after('due_warning_sent');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'due_warning_sent',
                'fine_notification_sent_at'
            ]);
        });
    }
};
