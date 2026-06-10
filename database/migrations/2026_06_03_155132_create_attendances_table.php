<?php
// database/migrations/2026_06_03_155132_create_attendances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->constrained('users')->cascadeOnDelete();
            $table->integer('meeting_number');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'permission', 'sick', 'absent'])->default('absent');
            $table->enum('submission_type', ['self', 'instructor'])->default('self'); // self = peserta isi sendiri, instructor = diubah instruktur
            $table->text('notes')->nullable();
            $table->time('check_in_time')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->unique(['class_id', 'participant_id', 'meeting_number'], 'unique_attendance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};