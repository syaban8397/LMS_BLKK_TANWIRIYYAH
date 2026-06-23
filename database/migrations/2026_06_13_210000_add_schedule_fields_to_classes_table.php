<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->time('start_time')->default('08:00:00')->after('end_date');
            $table->unsignedSmallInteger('duration_minutes')->default(60)->after('start_time');
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'duration_minutes']);
        });
    }
};
