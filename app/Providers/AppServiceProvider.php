<?php

namespace App\Providers;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        if (Schema::hasTable('system_settings')) {
            $settings = SystemSetting::current();
            SystemSetting::applyMailConfig();

            view()->share('lmsDefaultTheme', $settings->default_theme ?: 'light');
            view()->share('lmsAppDisplayName', $settings->appName());
        } else {
            view()->share('lmsDefaultTheme', 'light');
            view()->share('lmsAppDisplayName', __('lms.app_name'));
        }
    }
}
