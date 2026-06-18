<?php

namespace Tests\Feature;

use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class GradeFlowTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_instructor_can_save_grade(): void
    {
        $context = $this->createTrainingContext();

        $submission = Submission::create([
            'assignment_id' => $context['assignment']->id,
            'participant_id' => $context['participant']->id,
            'url' => 'https://example.com/work',
            'submitted_at' => now(),
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($context['instructor'])->post(
            route('instruktur.grades.store', [$context['class'], $context['assignment'], $submission]),
            [
                'score' => 85,
                'feedback' => 'Bagus',
            ]
        );

        $response->assertRedirect(route('instruktur.grades.index', [$context['class'], $context['assignment']]));
        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'score' => 85,
            'status' => 'graded',
        ]);
    }
}
