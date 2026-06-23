<?php

namespace Tests\Support;

use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Models\Material;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;

trait CreatesTrainingContext
{
    protected function createTrainingContext(): array
    {
        $admin = User::factory()->admin()->create();
        $instructor = User::factory()->instruktur()->create();
        $participant = User::factory()->create();

        $program = Program::create([
            'name' => 'Digital Marketing',
            'description' => 'Program pelatihan digital marketing',
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonths(2),
            'status' => 'active',
            'capacity' => 10,
        ]);

        $class = ClassModel::create([
            'program_id' => $program->id,
            'instructor_id' => $instructor->id,
            'code' => 'DM-0001',
            'title' => 'Kelas Digital Marketing A',
            'description' => 'Kelas uji',
            'start_date' => now()->subWeek(),
            'end_date' => now()->addMonth(),
            'start_time' => '08:00:00',
            'duration_minutes' => 120,
            'quota' => 30,
            'status' => 'active',
        ]);

        ClassParticipant::create([
            'class_id' => $class->id,
            'participant_id' => $participant->id,
            'enrolled_at' => now(),
            'status' => 'active',
        ]);

        $assignment = Assignment::create([
            'class_id' => $class->id,
            'created_by' => $instructor->id,
            'title' => 'Tugas Essay',
            'description' => 'Kerjakan essay digital marketing',
            'deadline' => now()->addDays(3),
            'late_submission_allowed' => true,
            'submission_type' => 'file_and_link',
            'is_active' => true,
        ]);

        return compact('admin', 'instructor', 'participant', 'program', 'class', 'assignment');
    }

    protected function createMaterial(array $context): Material
    {
        return Material::create([
            'class_id' => $context['class']->id,
            'title' => 'Materi Pertemuan 1',
            'description' => 'Pengenalan',
            'meeting_number' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'created_by' => $context['instructor']->id,
        ]);
    }

    protected function createAttendanceSession(
        array $context,
        int $meetingNumber = 1,
        ?Carbon $attendanceDate = null
    ): Attendance {
        $attendanceDate = ($attendanceDate ?? now())->copy()->subMinutes(30);

        return Attendance::create([
            'class_id' => $context['class']->id,
            'participant_id' => $context['participant']->id,
            'meeting_number' => $meetingNumber,
            'attendance_date' => $attendanceDate,
            'attendance_deadline' => now()->addHours(2),
            'status' => 'absent',
            'submission_type' => 'self',
            'created_by' => $context['instructor']->id,
        ]);
    }

    protected function createCertificate(array $context, string $number = 'DM-TEST-0001'): Certificate
    {
        return Certificate::create([
            'participant_id' => $context['participant']->id,
            'class_id' => $context['class']->id,
            'certificate_number' => $number,
            'final_score' => 85,
            'attendance_percentage' => 90,
            'qr_code' => 'certificates/qr/' . $number . '.svg',
            'pdf_file' => 'certificates/pdf/' . $number . '.pdf',
            'issued_at' => now(),
        ]);
    }
}
