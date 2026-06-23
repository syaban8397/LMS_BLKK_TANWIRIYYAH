<?php

namespace Tests\Feature;

use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class AttendanceFlowTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_instructor_can_create_attendance_session(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['instructor'])->post(
            route('instruktur.attendances.store', $context['class']),
            [
                'meeting_number' => 1,
                'session_date' => now()->toDateString(),
            ]
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'class_id' => $context['class']->id,
            'participant_id' => $context['participant']->id,
            'meeting_number' => 1,
        ]);
    }

    public function test_participant_can_submit_attendance_while_open(): void
    {
        $context = $this->createTrainingContext();
        $this->createAttendanceSession($context);

        $response = $this->actingAs($context['participant'])->post(
            route('peserta.attendances.submit', [$context['class'], 1]),
            [
                'status' => 'present',
                'notes' => 'Hadir tepat waktu',
            ]
        );

        $response->assertRedirect(route('peserta.attendances.index', $context['class']));
        $this->assertDatabaseHas('attendances', [
            'class_id' => $context['class']->id,
            'participant_id' => $context['participant']->id,
            'meeting_number' => 1,
            'status' => 'present',
        ]);
    }

    public function test_participant_cannot_submit_attendance_after_deadline(): void
    {
        $context = $this->createTrainingContext();

        Attendance::create([
            'class_id' => $context['class']->id,
            'participant_id' => $context['participant']->id,
            'meeting_number' => 2,
            'attendance_date' => now()->subDay(),
            'attendance_deadline' => now()->subHour(),
            'status' => 'absent',
            'submission_type' => 'self',
            'created_by' => $context['instructor']->id,
        ]);

        $response = $this->actingAs($context['participant'])->post(
            route('peserta.attendances.submit', [$context['class'], 2]),
            ['status' => 'present']
        );

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('attendances', [
            'meeting_number' => 2,
            'status' => 'absent',
        ]);
    }
}
