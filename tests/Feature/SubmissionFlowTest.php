<?php

namespace Tests\Feature;

use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class SubmissionFlowTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_participant_can_submit_assignment_via_url(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['participant'])->post(
            route('peserta.submissions.store', [$context['class'], $context['assignment']]),
            [
                'url' => 'https://example.com/my-work',
                'notes' => 'Tugas saya',
            ]
        );

        $response->assertRedirect(route('peserta.assignments.show', [$context['class'], $context['assignment']]));
        $this->assertDatabaseHas('submissions', [
            'assignment_id' => $context['assignment']->id,
            'participant_id' => $context['participant']->id,
            'url' => 'https://example.com/my-work',
            'status' => 'submitted',
        ]);
    }

    public function test_submission_requires_url_or_file(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['participant'])->post(
            route('peserta.submissions.store', [$context['class'], $context['assignment']]),
            ['notes' => 'Tanpa lampiran']
        );

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('submissions', 0);
    }

    public function test_participant_cannot_edit_graded_submission(): void
    {
        $context = $this->createTrainingContext();

        $submission = Submission::create([
            'assignment_id' => $context['assignment']->id,
            'participant_id' => $context['participant']->id,
            'url' => 'https://example.com/work',
            'submitted_at' => now(),
            'status' => 'graded',
            'score' => 90,
        ]);

        $response = $this->actingAs($context['participant'])->put(
            route('peserta.submissions.update', [$context['class'], $context['assignment'], $submission]),
            ['url' => 'https://example.com/changed']
        );

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
