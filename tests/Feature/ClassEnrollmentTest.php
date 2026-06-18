<?php

namespace Tests\Feature;

use App\Models\ClassParticipant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class ClassEnrollmentTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_instructor_can_add_approved_participant(): void
    {
        $context = $this->createTrainingContext();
        $newStudent = \App\Models\User::factory()->create([
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        $response = $this->actingAs($context['instructor'])->post(
            route('instruktur.classes.add-student.store', $context['class']),
            ['participant_ids' => [$newStudent->id]]
        );

        $response->assertRedirect(route('instruktur.classes.add-student', $context['class']));
        $this->assertDatabaseHas('class_participants', [
            'class_id' => $context['class']->id,
            'participant_id' => $newStudent->id,
            'status' => 'active',
        ]);
    }

    public function test_instructor_cannot_add_pending_participant(): void
    {
        $context = $this->createTrainingContext();
        $pendingStudent = \App\Models\User::factory()->create([
            'is_active' => false,
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($context['instructor'])->post(
            route('instruktur.classes.add-student.store', $context['class']),
            ['participant_ids' => [$pendingStudent->id]]
        );

        $response->assertSessionHasErrors('participant_ids.0');
        $this->assertDatabaseMissing('class_participants', [
            'class_id' => $context['class']->id,
            'participant_id' => $pendingStudent->id,
        ]);
    }

    public function test_instructor_cannot_add_admin_user_to_class(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['instructor'])->post(
            route('instruktur.classes.add-student.store', $context['class']),
            ['participant_ids' => [$context['admin']->id]]
        );

        $response->assertSessionHasErrors('participant_ids.0');
    }

    public function test_dropped_participant_cannot_access_class_show_or_stream(): void
    {
        $context = $this->createTrainingContext();

        ClassParticipant::where('class_id', $context['class']->id)
            ->where('participant_id', $context['participant']->id)
            ->update(['status' => 'dropped']);

        $this->actingAs($context['participant'])
            ->get(route('peserta.classes.show', $context['class']))
            ->assertForbidden();

        $this->actingAs($context['participant'])
            ->get(route('peserta.classes.stream', $context['class']))
            ->assertForbidden();
    }
}
