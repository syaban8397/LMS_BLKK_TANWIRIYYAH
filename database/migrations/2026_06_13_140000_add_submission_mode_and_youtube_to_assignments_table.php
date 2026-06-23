<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->string('youtube_url')->nullable()->after('attachment');
            $table->string('submission_mode', 10)->default('both')->after('late_submission_allowed');
        });
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn(['youtube_url', 'submission_mode']);
        });
    }
};
