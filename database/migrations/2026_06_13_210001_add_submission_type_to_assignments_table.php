<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('assignments', 'submission_type')) {
            Schema::table('assignments', function (Blueprint $table) {
                $table->string('submission_type', 20)->default('file_and_link')->after('late_submission_allowed');
            });
        }

        if (Schema::hasColumn('assignments', 'submission_mode')) {
            DB::table('assignments')->where('submission_mode', 'both')->update(['submission_type' => 'file_and_link']);
            DB::table('assignments')->where('submission_mode', 'file')->update(['submission_type' => 'file']);
            DB::table('assignments')->where('submission_mode', 'link')->update(['submission_type' => 'link']);

            Schema::table('assignments', function (Blueprint $table) {
                $table->dropColumn('submission_mode');
            });
        }

        if (Schema::hasColumn('assignments', 'youtube_url')) {
            Schema::table('assignments', function (Blueprint $table) {
                $table->dropColumn('youtube_url');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('assignments', 'submission_mode')) {
            Schema::table('assignments', function (Blueprint $table) {
                $table->string('submission_mode', 10)->default('both')->after('late_submission_allowed');
            });
        }

        if (Schema::hasColumn('assignments', 'submission_type')) {
            Schema::table('assignments', function (Blueprint $table) {
                $table->dropColumn('submission_type');
            });
        }
    }
};
