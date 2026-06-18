<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class MaterialAccessTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_participant_can_view_class_material(): void
    {
        $context = $this->createTrainingContext();
        $material = $this->createMaterial($context);

        $response = $this->actingAs($context['participant'])->get(
            route('peserta.materials.show', [$context['class'], $material])
        );

        $response->assertOk();
        $response->assertSee($material->title);
    }

    public function test_instructor_can_create_material_with_youtube_url(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['instructor'])->post(
            route('instruktur.materials.store', $context['class']),
            [
                'title' => 'Materi Baru',
                'meeting_number' => 2,
                'description' => 'Deskripsi materi',
                'youtube_url' => 'https://www.youtube.com/watch?v=test1234567',
            ]
        );

        $response->assertRedirect(route('instruktur.materials.index', $context['class']));
        $this->assertDatabaseHas('materials', [
            'class_id' => $context['class']->id,
            'title' => 'Materi Baru',
            'meeting_number' => 2,
        ]);
    }
}
