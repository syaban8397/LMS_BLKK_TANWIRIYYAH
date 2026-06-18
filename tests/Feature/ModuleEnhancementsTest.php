<?php

namespace Tests\Feature;

use App\Models\SystemSetting;
use App\Models\MaterialProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class ModuleEnhancementsTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_peserta_can_mark_material_completed(): void
    {
        $context = $this->createTrainingContext();
        $material = $this->createMaterial($context);

        $response = $this->actingAs($context['participant'])->post(
            route('peserta.materials.complete', [$context['class'], $material])
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('material_progress', [
            'material_id' => $material->id,
            'participant_id' => $context['participant']->id,
            'status' => 'completed',
        ]);
    }

    public function test_admin_can_update_system_settings(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['admin'])->put(route('admin.settings.update'), [
            'app_display_name' => 'LMS BLKK Pro',
            'default_theme' => 'dark',
            'default_locale' => 'id',
        ]);

        $response->assertRedirect(route('admin.settings.edit'));
        $this->assertDatabaseHas('system_settings', [
            'app_display_name' => 'LMS BLKK Pro',
            'default_theme' => 'dark',
        ]);
    }

    public function test_admin_can_export_participants_pdf(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['admin'])->get(route('admin.reports.participants.export-pdf'));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_material_progress_defaults_to_not_started(): void
    {
        $context = $this->createTrainingContext();
        $material = $this->createMaterial($context);

        $response = $this->actingAs($context['participant'])->get(
            route('peserta.materials.show', [$context['class'], $material])
        );

        $response->assertOk();
        $this->assertDatabaseHas('material_progress', [
            'material_id' => $material->id,
            'participant_id' => $context['participant']->id,
            'status' => 'not_started',
        ]);
    }
}
