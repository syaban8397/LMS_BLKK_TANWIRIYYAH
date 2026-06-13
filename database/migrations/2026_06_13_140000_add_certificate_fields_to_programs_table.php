<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('certificate_degree')->nullable()->after('description');
            $table->unsignedTinyInteger('validity_years')->default(3)->after('certificate_degree');
        });

        Schema::table('final_grades', function (Blueprint $table) {
            $table->unique(['class_id', 'participant_id']);
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['certificate_degree', 'validity_years']);
        });

        Schema::table('final_grades', function (Blueprint $table) {
            $table->dropUnique(['class_id', 'participant_id']);
        });
    }
};
