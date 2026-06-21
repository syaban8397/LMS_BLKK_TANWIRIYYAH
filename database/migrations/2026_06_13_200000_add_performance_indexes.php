<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('approval_status');
            $table->index(['role', 'approval_status', 'is_active'], 'users_role_approval_active_index');
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->index('status');
            $table->index(['instructor_id', 'status'], 'classes_instructor_status_index');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index('status');
            $table->index(['class_id', 'meeting_number'], 'attendances_class_meeting_index');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->index(['assignment_id', 'status'], 'submissions_assignment_status_index');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->index(['class_id', 'is_active'], 'assignments_class_active_index');
        });

        Schema::table('class_participants', function (Blueprint $table) {
            $table->index(['participant_id', 'status'], 'class_participants_participant_status_index');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->index(['class_id', 'created_at'], 'announcements_class_created_index');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['approval_status']);
            $table->dropIndex('users_role_approval_active_index');
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex('classes_instructor_status_index');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex('attendances_class_meeting_index');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropIndex('submissions_assignment_status_index');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex('assignments_class_active_index');
        });

        Schema::table('class_participants', function (Blueprint $table) {
            $table->dropIndex('class_participants_participant_status_index');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex('announcements_class_created_index');
        });
    }
};
