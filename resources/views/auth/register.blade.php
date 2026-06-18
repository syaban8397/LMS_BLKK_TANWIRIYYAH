<x-guest-layout>
    <div class="lms-guest-page">
        @if(session('success'))
            <x-lms-flash type="success" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 shadow-md">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 shadow-md">{{ session('error') }}</x-lms-flash>
        @endif

        <div class="lms-auth-card lms-auth-card--register p-6 md:p-8 relative">
            <div class="text-center mb-5">
                <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-16 w-auto mx-auto drop-shadow-md mb-2">
                <h2 class="text-2xl font-bold text-slate-800">{{ __('lms.auth.create_account') }}</h2>
                <p class="text-slate-500 text-sm">{{ __('lms.auth.register_subtitle') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label>{{ __('lms.auth.full_name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="input-luxury" placeholder="{{ __('lms.auth.placeholder_name') }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.email') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-luxury" placeholder="{{ __('lms.auth.placeholder_email') }}">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.nik') }}</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" class="input-luxury" placeholder="{{ __('lms.auth.placeholder_nik') }}">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="input-luxury" placeholder="{{ __('lms.auth.placeholder_phone') }}">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.gender') }}</label>
                        <select name="gender" class="input-luxury">
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>{{ __('lms.auth.select') }}</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>{{ __('lms.auth.male') }}</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>{{ __('lms.auth.female') }}</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.birth_place') }}</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="input-luxury" placeholder="{{ __('lms.auth.placeholder_city') }}">
                        @error('birth_place') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.birth_date') }}</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="input-luxury">
                        @error('birth_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.address') }}</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="input-luxury" placeholder="{{ __('lms.auth.placeholder_address') }}">
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.password') }}</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required class="input-luxury pr-12" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-sm">👁️</button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label>{{ __('lms.auth.confirm_password') }}</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="input-luxury pr-12" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-sm">👁️</button>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" name="terms_accepted" value="1" required
                               class="mt-1 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                               {{ old('terms_accepted') ? 'checked' : '' }}>
                        <span class="text-sm text-slate-600">
                            {!! __('lms.auth.terms_accept', [
                                'terms' => '<a href="' . route('legal.terms') . '" target="_blank" class="lms-auth-link font-semibold">' . __('lms.welcome.terms') . '</a>',
                                'privacy' => '<a href="' . route('legal.privacy') . '" target="_blank" class="lms-auth-link font-semibold">' . __('lms.welcome.privacy') . '</a>',
                            ]) !!}
                        </span>
                    </label>
                    @error('terms_accepted') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-auth-primary mt-6">
                    {{ __('lms.auth.register_btn') }}
                </button>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="lms-auth-link text-sm">
                        {{ __('lms.auth.has_account') }} <span class="font-bold">{{ __('lms.auth.login') }}</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const field = document.getElementById(id);
            const btn = field.parentElement.querySelector('button');
            if (field.type === 'password') {
                field.type = 'text';
                btn.textContent = '🙈';
            } else {
                field.type = 'password';
                btn.textContent = '👁️';
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
