<?php

namespace Tests\Feature;

use App\Models\SystemSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class SystemSettingsDefaultsTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_admin_default_locale_applies_to_participant_pages(): void
    {
        $context = $this->createTrainingContext();
        SystemSetting::current()->update(['default_locale' => 'en']);

        $response = $this->actingAs($context['participant'])->get(route('peserta.dashboard'));

        $response->assertOk();
        $this->assertSame('en', app()->getLocale());
    }

    public function test_admin_default_theme_is_shared_to_views(): void
    {
        $context = $this->createTrainingContext();
        SystemSetting::current()->update(['default_theme' => 'dark']);
        SystemSetting::clearCache();

        $response = $this->actingAs($context['instructor'])->get(route('instruktur.dashboard'));

        $response->assertOk();
        $response->assertSee('data-default-theme="dark"', false);
    }
}
