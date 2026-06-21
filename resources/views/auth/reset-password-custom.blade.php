<x-guest-layout>
    <x-lms-auth-shell
        :title="__('lms.auth.reset_title')"
        :subtitle="__('lms.auth.reset_subtitle_custom')"
    >
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
                    <x-lms-password-toggle target="password" />
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
                    <x-lms-password-toggle target="password_confirmation" />
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
    </x-lms-auth-shell>
</x-guest-layout>
