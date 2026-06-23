<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class ClassAccessControlTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_instructor_cannot_access_unassigned_class_stream(): void
    {
        $context = $this->createTrainingContext();
        $otherInstructor = User::factory()->instruktur()->create();

        $this->actingAs($otherInstructor)
            ->get(route('instruktur.classes.stream', $context['class']))
            ->assertForbidden();
    }

    public function test_participant_cannot_access_unenrolled_class_materials(): void
    {
        $context = $this->createTrainingContext();
        $outsider = User::factory()->create();

        $this->actingAs($outsider)
            ->get(route('peserta.materials.index', $context['class']))
            ->assertForbidden();
    }

    public function test_instructor_can_update_assignment_deadline(): void
    {
        $context = $this->createTrainingContext();
        $newDeadline = now()->addWeek()->format('Y-m-d\TH:i');

        $response = $this->actingAs($context['instructor'])->put(
            route('instruktur.assignments.update', [$context['class'], $context['assignment']]),
            [
                'title' => $context['assignment']->title,
                'description' => $context['assignment']->description,
                'deadline' => $newDeadline,
                'late_submission_allowed' => '1',
                'submission_type' => 'file_and_link',
            ]
        );

        $response->assertRedirect(route('instruktur.classes.stream', $context['class']));
        $context['assignment']->refresh();
        $this->assertTrue($context['assignment']->deadline->greaterThan(now()->addDays(6)));
    }

    public function test_participant_cannot_submit_attendance_before_window(): void
    {
        $context = $this->createTrainingContext();

        $this->actingAs($context['instructor'])->post(
            route('instruktur.attendances.store', $context['class']),
            [
                'meeting_number' => 3,
                'session_date' => now()->addDay()->toDateString(),
            ]
        );

        $response = $this->actingAs($context['participant'])->post(
            route('peserta.attendances.submit', [$context['class'], 3]),
            ['status' => 'present']
        );

        $response->assertRedirect();
        $response->assertSessionHas('error', __('lms.flash.attendance_window_not_open'));
    }
}
