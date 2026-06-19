<x-guest-layout>
    <div class="lms-guest-page">
        <div class="lms-auth-card lms-auth-card--forgot p-8 md:p-10 relative">
            <div class="absolute top-4 right-4 z-10">
                <x-locale-switcher />
            </div>

            <div class="text-center mb-8">
                <div class="lms-brand-logo-pad mx-auto mb-4">
                    <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-16 w-auto">
                </div>
                <h2 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ __('lms.auth.forgot_page_title') }}</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-2 leading-relaxed max-w-md mx-auto">{{ __('lms.auth.forgot_page_desc') }}</p>
            </div>

            @if(session('error'))
                <x-lms-flash type="error" class="mb-5">{{ session('error') }}</x-lms-flash>
            @endif

            <form method="POST" action="{{ route('password.verify') }}" id="forgotForm" novalidate>
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-slate-700 dark:text-slate-200 text-sm font-semibold mb-2">{{ __('lms.auth.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="input-luxury @error('email') border-red-400 @enderror"
                           placeholder="{{ __('lms.auth.placeholder_email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="nik" class="block text-slate-700 dark:text-slate-200 text-sm font-semibold mb-2">{{ __('lms.auth.nik') }}</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required
                           class="input-luxury @error('nik') border-red-400 @enderror"
                           placeholder="{{ __('lms.auth.placeholder_nik') }}">
                    @error('nik')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-auth-primary" id="forgotSubmit">
                    {{ __('lms.auth.forgot_verify_btn') }}
                </button>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="lms-auth-link text-sm inline-flex items-center gap-1">
                        <span aria-hidden="true">←</span> {{ __('lms.auth.back_to_login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('popup_error'))
        <div id="authPopup" class="lms-auth-modal" role="dialog" aria-modal="true">
            <div class="lms-auth-modal__panel">
                <div class="lms-auth-modal__header lms-auth-modal__header--error">
                    <h3>{{ __('lms.auth.popup_verify_failed') }}</h3>
                </div>
                <div class="lms-auth-modal__body">
                    <p>{{ session('popup_error') }}</p>
                    <button type="button" class="lms-btn-primary w-full mt-6" onclick="closeAuthPopup()">{{ __('lms.common.close') }}</button>
                </div>
            </div>
        </div>
    @endif

    @if(session('popup_success'))
        <div id="authPopup" class="lms-auth-modal" role="dialog" aria-modal="true">
            <div class="lms-auth-modal__panel">
                <div class="lms-auth-modal__header lms-auth-modal__header--success">
                    <h3>{{ __('lms.auth.popup_verify_success') }}</h3>
                </div>
                <div class="lms-auth-modal__body">
                    <p>{{ session('popup_success') }}</p>
                    <div class="mt-6 space-y-2">
                        <a href="{{ route('password.form') }}" class="lms-btn-primary w-full inline-flex justify-center">{{ __('lms.auth.continue_reset') }}</a>
                        <button type="button" class="lms-btn-secondary w-full" onclick="closeAuthPopup()">{{ __('lms.common.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function closeAuthPopup() {
            document.getElementById('authPopup')?.remove();
        }

        document.getElementById('forgotForm')?.addEventListener('submit', function () {
            const btn = document.getElementById('forgotSubmit');
            btn.disabled = true;
            btn.classList.add('is-loading');
        });
    </script>
</x-guest-layout>
