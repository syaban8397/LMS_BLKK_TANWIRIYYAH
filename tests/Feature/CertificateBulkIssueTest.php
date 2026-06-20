<?php

namespace Tests\Feature;

use App\Models\FinalGrade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class CertificateBulkIssueTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_instructor_can_bulk_issue_certificate(): void
    {
        $context = $this->createTrainingContext();

        FinalGrade::create([
            'class_id' => $context['class']->id,
            'participant_id' => $context['participant']->id,
            'attendance_score' => 90,
            'assignment_score' => 90,
            'final_score' => 90,
            'status' => 'pass',
        ]);

        $response = $this->actingAs($context['instructor'])->post(
            route('instruktur.certificates.bulk-issue', $context['class']),
            ['selected' => [$context['participant']->id]]
        );

        $response->assertRedirect(route('instruktur.certificates.show', $context['class']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('certificates', [
            'class_id' => $context['class']->id,
            'participant_id' => $context['participant']->id,
        ]);
    }

    public function test_instructor_can_download_issued_certificate(): void
    {
        $context = $this->createTrainingContext();

        FinalGrade::create([
            'class_id' => $context['class']->id,
            'participant_id' => $context['participant']->id,
            'attendance_score' => 90,
            'assignment_score' => 90,
            'final_score' => 90,
            'status' => 'pass',
        ]);

        $this->actingAs($context['instructor'])->post(
            route('instruktur.certificates.bulk-issue', $context['class']),
            ['selected' => [$context['participant']->id]]
        );

        $certificate = \App\Models\Certificate::where('class_id', $context['class']->id)
            ->where('participant_id', $context['participant']->id)
            ->first();

        $this->assertNotNull($certificate);

        $download = $this->actingAs($context['instructor'])->get(
            route('instruktur.certificates.download', $certificate)
        );

        $download->assertOk();
    }
}
