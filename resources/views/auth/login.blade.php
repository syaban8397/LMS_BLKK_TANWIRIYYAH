<x-guest-layout>
    <div class="lms-guest-page">

        @if(session('success'))
            <x-lms-flash type="success" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 shadow-md">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 shadow-md">{{ session('error') }}</x-lms-flash>
        @endif

        <div class="lms-auth-card lms-auth-card--login p-8 md:p-10 relative">
            <div class="absolute top-4 right-4 z-10">
                <x-locale-switcher />
            </div>
            <div class="text-center mb-8">
                <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-20 w-auto mx-auto drop-shadow-md mb-4">
                <h2 class="text-3xl font-bold text-slate-800">{{ __('lms.auth.welcome_back') }}</h2>
                <p class="text-slate-500 text-sm mt-1">{{ __('lms.auth.login_subtitle') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="mb-5">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">{{ __('lms.auth.email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input-luxury" placeholder="email@contoh.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-2">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">{{ __('lms.auth.password') }}</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="input-luxury pr-12" placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition text-sm">
                            <span id="toggleIcon">👁️</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-right mb-6">
                    <a href="{{ route('password.request.custom') }}" class="lms-auth-link text-xs">
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
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.textContent = '🙈';
            } else {
                pwd.type = 'password';
                icon.textContent = '👁️';
            }
        }

        setTimeout(() => {
            document.querySelectorAll('.lms-flash').forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 3000);
    </script>
</x-guest-layout>
