<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class AssignmentAccessTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_participant_cannot_view_inactive_assignment(): void
    {
        $context = $this->createTrainingContext();
        $context['assignment']->update(['is_active' => false]);

        $response = $this->actingAs($context['participant'])->get(
            route('peserta.assignments.show', [$context['class'], $context['assignment']])
        );

        $response->assertNotFound();
    }

    public function test_non_enrolled_participant_cannot_view_assignment(): void
    {
        $context = $this->createTrainingContext();
        $outsider = User::factory()->create();

        $response = $this->actingAs($outsider)->get(
            route('peserta.assignments.show', [$context['class'], $context['assignment']])
        );

        $response->assertForbidden();
    }

    public function test_submission_blocked_after_deadline_when_late_not_allowed(): void
    {
        $context = $this->createTrainingContext();
        $context['assignment']->update([
            'deadline' => now()->subDay(),
            'late_submission_allowed' => false,
        ]);

        $response = $this->actingAs($context['participant'])->post(
            route('peserta.submissions.store', [$context['class'], $context['assignment']]),
            ['url' => 'https://example.com/late-work']
        );

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('submissions', [
            'assignment_id' => $context['assignment']->id,
            'participant_id' => $context['participant']->id,
        ]);
    }

    public function test_enrolled_participant_can_view_active_assignment(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['participant'])->get(
            route('peserta.assignments.show', [$context['class'], $context['assignment']])
        );

        $response->assertOk();
        $response->assertSee($context['assignment']->title);
    }
}
