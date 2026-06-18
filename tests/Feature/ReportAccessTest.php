<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class ReportAccessTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_admin_can_access_report_pages(): void
    {
        $context = $this->createTrainingContext();

        $routes = [
            'admin.reports.index',
            'admin.reports.participants',
            'admin.reports.grades',
            'admin.reports.attendance',
            'admin.reports.certificates',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($context['admin'])->get(route($route));
            $response->assertOk();
        }
    }

    public function test_admin_can_export_participants_report(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['admin'])->get(route('admin.reports.participants.export'));

        $response->assertOk();
        $this->assertStringContainsString(
            'spreadsheet',
            (string) $response->headers->get('content-type')
        );
    }

    public function test_instructor_cannot_export_admin_reports(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['instructor'])->get(
            route('admin.reports.participants.export')
        );

        $response->assertForbidden();
    }
}
