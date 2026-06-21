<x-guest-layout>
    <x-lms-auth-shell
        :title="__('lms.auth.confirm_password')"
        :subtitle="__('lms.auth.confirm_password_message')"
    >
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-5">
                <label for="password" class="block text-slate-700 text-sm font-semibold mb-2">{{ __('lms.auth.password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="input-luxury">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-auth-primary">
                {{ __('lms.auth.confirm') }}
            </button>
        </form>
    </x-lms-auth-shell>
</x-guest-layout>
