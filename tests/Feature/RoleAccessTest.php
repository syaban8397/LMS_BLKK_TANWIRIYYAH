<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_participant_cannot_access_admin_routes(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['participant'])->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_instructor_cannot_access_admin_reports(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['instructor'])->get(route('admin.reports.index'));

        $response->assertForbidden();
    }

    public function test_admin_cannot_access_instructor_class_routes(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['admin'])->get(route('instruktur.classes.index'));

        $response->assertForbidden();
    }

    public function test_participant_cannot_access_instructor_routes(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['participant'])->get(
            route('instruktur.grades.index', [$context['class'], $context['assignment']])
        );

        $response->assertForbidden();
    }
}
