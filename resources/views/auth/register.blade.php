<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <div>
            <x-input-label for="name" value="Full Name" />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name" />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="Email Address" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- National ID Number -->
        <div class="mt-4">
            <x-input-label for="nik" value="National ID Number (NIK)" />

            <x-text-input
                id="nik"
                class="block mt-1 w-full"
                type="text"
                name="nik"
                :value="old('nik')" />

            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" value="Phone Number" />

            <x-text-input
                id="phone"
                class="block mt-1 w-full"
                type="text"
                name="phone"
                :value="old('phone')" />

            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" value="Gender" />

            <select
                name="gender"
                id="gender"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                <option value="">Select Gender</option>

                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>
                    Male
                </option>

                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>
                    Female
                </option>

            </select>

            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Birth Place -->
        <div class="mt-4">
            <x-input-label for="birth_place" value="Birth Place" />

            <x-text-input
                id="birth_place"
                class="block mt-1 w-full"
                type="text"
                name="birth_place"
                :value="old('birth_place')" />

            <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
        </div>

        <!-- Birth Date -->
        <div class="mt-4">
            <x-input-label for="birth_date" value="Birth Date" />

            <x-text-input
                id="birth_date"
                class="block mt-1 w-full"
                type="date"
                name="birth_date"
                :value="old('birth_date')" />

            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" value="Address" />

            <textarea
                id="address"
                name="address"
                rows="3"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea>

            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                value="Confirm Password" />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password" />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">

            <a
                href="{{ route('login') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

                Already registered?
            </a>

            <x-primary-button class="ms-4">
                Register
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>