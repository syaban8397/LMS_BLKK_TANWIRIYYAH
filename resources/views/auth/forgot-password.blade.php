<x-guest-layout>

    <form method="POST"
          action="{{ route('password.update.custom') }}">

        @csrf

        <h2 class="text-2xl font-bold mb-6">
            Reset Password
        </h2>

        <!-- Email -->
        <div>
            <x-input-label
                for="email"
                value="Email" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                required />
        </div>

        <!-- NIK -->
        <div class="mt-4">
            <x-input-label
                for="nik"
                value="NIK" />

            <x-text-input
                id="nik"
                class="block mt-1 w-full"
                type="text"
                name="nik"
                required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label
                for="password"
                value="New Password" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required />
        </div>

        <!-- Confirm -->
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                value="Confirm Password" />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required />
        </div>

        <div class="mt-6">
            <x-primary-button>
                Reset Password
            </x-primary-button>
        </div>

    </form>

</x-guest-layout>