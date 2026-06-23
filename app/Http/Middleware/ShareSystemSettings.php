<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class ShareSystemSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Schema::hasTable('system_settings')) {
            $settings = SystemSetting::current();

            SystemSetting::applyMailConfig();

            $theme = $settings->default_theme ?: 'light';
            $locale = $settings->default_locale ?: 'id';

            view()->share('lmsDefaultTheme', $theme);
            view()->share('lmsDefaultLocale', $locale);
            view()->share('lmsAppDisplayName', $settings->appName());

            config(['app.locale' => $locale]);
            app()->setLocale($locale);
        } else {
            view()->share('lmsDefaultTheme', 'light');
            view()->share('lmsDefaultLocale', 'id');
            view()->share('lmsAppDisplayName', __('lms.app_name'));
        }

        return $next($request);
    }
}
