<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Support\UploadRules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $settings = SystemSetting::current();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = SystemSetting::current();

        $validated = $request->validate([
            'app_display_name' => ['nullable', 'string', 'max:255'],
            'default_theme' => ['required', 'in:light,dark'],
            'default_locale' => ['required', 'in:id,en'],
            'mail_mailer' => ['nullable', 'string', 'max:50'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'string', 'max:20'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
            'mail_from_name' => ['nullable', 'string', 'max:255'],
            'logo' => UploadRules::profilePhoto(5120),
        ]);

        $data = collect($validated)->except(['logo', 'mail_password'])->toArray();

        if ($request->filled('mail_password')) {
            $data['mail_password'] = $request->mail_password;
        }

        $settings->update($data);

        if ($request->hasFile('logo')) {
            $path = 'images/Logo.png';
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $request->file('logo')->storeAs('images', 'Logo.png', 'public');
        }

        SystemSetting::applyMailConfig();

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', __('lms.flash.settings_updated'));
    }
}
