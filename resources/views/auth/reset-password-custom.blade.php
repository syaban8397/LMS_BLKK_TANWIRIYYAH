<x-guest-layout>
    <div class="lms-guest-page">
        <div class="lms-auth-card lms-auth-card--reset p-8 md:p-10 relative">
            <div class="absolute top-4 right-4 z-10">
                <x-locale-switcher />
            </div>

            <div class="text-center mb-8">
                <div class="lms-brand-logo-pad mx-auto mb-4">
                    <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-16 w-auto">
                </div>
                <h2 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ __('lms.auth.reset_title') }}</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-2 leading-relaxed">{{ __('lms.auth.reset_subtitle_custom') }}</p>
            </div>

            @if ($errors->any())
                <x-lms-flash type="error" class="mb-5">{{ $errors->first() }}</x-lms-flash>
            @endif

            <form method="POST" action="{{ route('password.reset.custom') }}" id="resetForm">
                @csrf
                <input type="hidden" name="reset_token" value="{{ $resetToken }}">

                <div class="mb-5">
                    <label for="password" class="block text-slate-700 dark:text-slate-200 text-sm font-semibold mb-2">{{ __('lms.auth.new_password') }}</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required minlength="8"
                               class="input-luxury pr-12" placeholder="••••••••">
                        <button type="button" onclick="toggleField('password', 'togglePasswordIcon')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-sm">
                            <span id="togglePasswordIcon">👁️</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-slate-700 dark:text-slate-200 text-sm font-semibold mb-2">{{ __('lms.auth.confirm_password') }}</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                               class="input-luxury pr-12" placeholder="••••••••">
                        <button type="button" onclick="toggleField('password_confirmation', 'toggleConfirmIcon')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-sm">
                            <span id="toggleConfirmIcon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="auth-alert auth-alert--success mb-5">
                    <p class="text-sm">{{ __('lms.auth.password_hint') }}</p>
                </div>

                <button type="submit" class="btn-auth-primary">{{ __('lms.auth.reset_submit_btn') }}</button>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="lms-auth-link text-sm inline-flex items-center gap-1">
                        <span aria-hidden="true">←</span> {{ __('lms.auth.back_to_login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleField(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (field.type === 'password') {
                field.type = 'text';
                icon.textContent = '🙈';
            } else {
                field.type = 'password';
                icon.textContent = '👁️';
            }
        }
    </script>
</x-guest-layout>
