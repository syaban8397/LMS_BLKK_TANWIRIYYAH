<x-guest-layout>
    @if(session('success'))
        <x-lms-flash type="success" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 shadow-md">{{ session('success') }}</x-lms-flash>
    @endif
    @if(session('status'))
        <x-lms-flash type="success" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 shadow-md">{{ session('status') }}</x-lms-flash>
    @endif
    @if(session('error'))
        <x-lms-flash type="error" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 shadow-md">{{ session('error') }}</x-lms-flash>
    @endif

    <x-lms-auth-shell
        :title="__('lms.auth.welcome_back')"
        :subtitle="__('lms.auth.login_subtitle')"
    >
        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-1">
            @csrf

            <div class="mb-5">
                <label class="block text-slate-700 text-sm font-semibold mb-2">{{ __('lms.auth.email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="input-luxury" placeholder="{{ __('lms.auth.placeholder_email') }}">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-2">
                <label class="block text-slate-700 text-sm font-semibold mb-2">{{ __('lms.auth.password') }}</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                           class="input-luxury pr-12" placeholder="••••••••">
                    <x-lms-password-toggle target="password" />
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="inline-flex items-center gap-2 text-sm text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                           class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>{{ __('lms.auth.remember_me') }}</span>
                </label>
                <a href="{{ route('password.request') }}" class="lms-auth-link text-xs">
                    {{ __('lms.auth.forgot_password') }}
                </a>
            </div>

            <button type="submit" class="btn-auth-primary">
                {{ __('lms.auth.login') }}
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('register') }}" class="lms-auth-link text-sm">
                    {{ __('lms.auth.no_account') }} <span class="font-bold">{{ __('lms.auth.register_now') }}</span>
                </a>
            </div>
        </form>
    </x-lms-auth-shell>
</x-guest-layout>
