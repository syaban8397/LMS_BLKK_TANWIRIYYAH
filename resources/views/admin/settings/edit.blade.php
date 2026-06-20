<x-app-layout>
    <div class="lms-page-shell max-w-5xl mx-auto space-y-6">
        <x-lms-page-header :title="__('lms.settings.title')" :subtitle="__('lms.settings.subtitle')" />

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <x-lms-form-card :title="__('lms.settings.branding')" icon="tag">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="app_display_name" :value="__('lms.settings.app_name')" />
                        <x-text-input id="app_display_name" name="app_display_name" type="text" class="mt-1 block w-full"
                                      :value="old('app_display_name', $settings->app_display_name)" />
                    </div>
                    <div>
                        <x-input-label for="logo" :value="__('lms.settings.logo')" />
                        <div class="mt-2 flex items-center gap-4">
                            <img src="{{ asset('storage/images/Logo.png') }}" alt="Logo" class="h-16 w-auto rounded-lg border border-slate-200 bg-white p-1"
                                 onerror="this.style.display='none'">
                            <input id="logo" name="logo" type="file" accept="image/*" class="block w-full text-sm" />
                        </div>
                    </div>
                </div>
            </x-lms-form-card>

            <x-lms-form-card :title="__('lms.settings.appearance')" icon="palette">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="default_theme" :value="__('lms.settings.default_theme')" />
                        <select id="default_theme" name="default_theme" class="mt-1 block w-full border-slate-300 rounded-lg">
                            <option value="light" {{ old('default_theme', $settings->default_theme) === 'light' ? 'selected' : '' }}>{{ __('lms.theme.light') }}</option>
                            <option value="dark" {{ old('default_theme', $settings->default_theme) === 'dark' ? 'selected' : '' }}>{{ __('lms.theme.dark') }}</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="default_locale" :value="__('lms.settings.default_locale')" />
                        <select id="default_locale" name="default_locale" class="mt-1 block w-full border-slate-300 rounded-lg">
                            <option value="id" {{ old('default_locale', $settings->default_locale) === 'id' ? 'selected' : '' }}>{{ __('lms.lang_id') }}</option>
                            <option value="en" {{ old('default_locale', $settings->default_locale) === 'en' ? 'selected' : '' }}>{{ __('lms.lang_en') }}</option>
                        </select>
                    </div>
                </div>
            </x-lms-form-card>

            <x-lms-form-card :title="__('lms.settings.smtp')" icon="mail">
                <p class="text-xs text-slate-500 mb-4">{{ __('lms.settings.smtp_hint') }}</p>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="mail_mailer" value="Mailer" />
                        <x-text-input id="mail_mailer" name="mail_mailer" type="text" class="mt-1 block w-full" :value="old('mail_mailer', $settings->mail_mailer)" placeholder="smtp" />
                    </div>
                    <div>
                        <x-input-label for="mail_host" value="Host" />
                        <x-text-input id="mail_host" name="mail_host" type="text" class="mt-1 block w-full" :value="old('mail_host', $settings->mail_host)" />
                    </div>
                    <div>
                        <x-input-label for="mail_port" value="Port" />
                        <x-text-input id="mail_port" name="mail_port" type="number" class="mt-1 block w-full" :value="old('mail_port', $settings->mail_port)" />
                    </div>
                    <div>
                        <x-input-label for="mail_encryption" value="Encryption" />
                        <x-text-input id="mail_encryption" name="mail_encryption" type="text" class="mt-1 block w-full" :value="old('mail_encryption', $settings->mail_encryption)" placeholder="tls" />
                    </div>
                    <div>
                        <x-input-label for="mail_username" value="Username" />
                        <x-text-input id="mail_username" name="mail_username" type="text" class="mt-1 block w-full" :value="old('mail_username', $settings->mail_username)" />
                    </div>
                    <div>
                        <x-input-label for="mail_password" value="Password" />
                        <x-text-input id="mail_password" name="mail_password" type="password" class="mt-1 block w-full" placeholder="{{ __('lms.common.leave_blank') }}" />
                    </div>
                    <div>
                        <x-input-label for="mail_from_address" value="From Address" />
                        <x-text-input id="mail_from_address" name="mail_from_address" type="email" class="mt-1 block w-full" :value="old('mail_from_address', $settings->mail_from_address)" />
                    </div>
                    <div>
                        <x-input-label for="mail_from_name" value="From Name" />
                        <x-text-input id="mail_from_name" name="mail_from_name" type="text" class="mt-1 block w-full" :value="old('mail_from_name', $settings->mail_from_name)" />
                    </div>
                </div>
            </x-lms-form-card>

            <x-lms-form-actions>
                <x-ds.button type="submit" variant="primary">{{ __('lms.save') }}</x-ds.button>
            </x-lms-form-actions>
        </form>
    </div>
</x-app-layout>
