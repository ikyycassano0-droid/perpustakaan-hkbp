<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ======================
        // TABLE: archives
        // ======================
        Schema::table('archives', function (Blueprint $table) {

            // UI tambahan
            if (!Schema::hasColumn('archives', 'icon')) {
                $table->string('icon')->nullable()->after('category');
            }

            // Audit
            if (!Schema::hasColumn('archives', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('active');
            }

            if (!Schema::hasColumn('archives', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }

            // Sequence (kalau belum ada)
            if (!Schema::hasColumn('archives', 'sequence')) {
                $table->integer('sequence')->nullable()->after('category');
            }
        });


        // ======================
        // TABLE: archive_files
        // ======================
        Schema::table('archive_files', function (Blueprint $table) {

            // Nama file
            if (!Schema::hasColumn('archive_files', 'file_name')) {
                $table->string('file_name')->nullable()->after('file_url');
            }

            // Tipe file
            if (!Schema::hasColumn('archive_files', 'file_type')) {
                $table->string('file_type')->nullable()->after('file_name');
            }

            // Ukuran file
            if (!Schema::hasColumn('archive_files', 'file_size')) {
                $table->integer('file_size')->nullable()->after('file_type');
            }

            // Tanggal publish
            if (!Schema::hasColumn('archive_files', 'published_at')) {
                $table->date('published_at')->nullable()->after('file_size');
            }

            // Audit
            if (!Schema::hasColumn('archive_files', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('active');
            }

            if (!Schema::hasColumn('archive_files', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });
    }

    public function down(): void
    {
        // archives
        Schema::table('archives', function (Blueprint $table) {
            $table->dropColumn([
                'icon',
                'created_by',
                'updated_by',
                'sequence'
            ]);
        });

        // archive_files
        Schema::table('archive_files', function (Blueprint $table) {
            $table->dropColumn([
                'file_name',
                'file_type',
                'file_size',
                'published_at',
                'created_by',
                'updated_by'
            ]);
        });
    }
};