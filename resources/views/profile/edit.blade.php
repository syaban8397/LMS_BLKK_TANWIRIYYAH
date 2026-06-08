<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl">
            Profile Management
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-5xl mx-auto px-4 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- PROFILE INFORMATION -->

            <div class="bg-white rounded-xl shadow p-6">

                <h3 class="text-xl font-bold mb-6">
                    Personal Information
                </h3>

                <form
                    method="POST"
                    action="{{ route('profile.update') }}"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block mb-1 font-medium">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                NIK
                            </label>

                            <input
                                type="text"
                                name="nik"
                                value="{{ old('nik', $user->nik) }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Gender
                            </label>

                            <select
                                name="gender"
                                class="w-full rounded-lg border-gray-300">

                                <option value="">
                                    Select Gender
                                </option>

                                <option
                                    value="L"
                                    {{ $user->gender == 'L' ? 'selected' : '' }}>
                                    Male
                                </option>

                                <option
                                    value="P"
                                    {{ $user->gender == 'P' ? 'selected' : '' }}>
                                    Female
                                </option>

                            </select>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Birth Place
                            </label>

                            <input
                                type="text"
                                name="birth_place"
                                value="{{ old('birth_place', $user->birth_place) }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Birth Date
                            </label>

                            <input
                                type="date"
                                name="birth_date"
                                value="{{ old('birth_date', $user->birth_date) }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Profile Photo
                            </label>

                            <input
                                type="file"
                                name="photo"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                    </div>

                    <div class="mt-5">

                        <label class="block mb-1 font-medium">
                            Address
                        </label>

                        <textarea
                            name="address"
                            rows="3"
                            class="w-full rounded-lg border-gray-300">{{ old('address', $user->address) }}</textarea>

                    </div>

                    <div class="mt-5">

                        <label class="block mb-1 font-medium">
                            Biography
                        </label>

                        <textarea
                            name="bio"
                            rows="4"
                            class="w-full rounded-lg border-gray-300">{{ old('bio', $user->bio) }}</textarea>

                    </div>

                    <button
                        type="submit"
                        class="mt-6 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">

                        Save Profile

                    </button>

                </form>

            </div>

            <!-- CHANGE PASSWORD -->

            <div class="bg-white rounded-xl shadow p-6">

                <h3 class="text-xl font-bold mb-6">
                    Change Password
                </h3>

                <form
                    method="POST"
                    action="{{ route('profile.password') }}">

                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">

                        <input
                            type="password"
                            name="current_password"
                            placeholder="Current Password"
                            class="w-full rounded-lg border-gray-300">

                        <input
                            type="password"
                            name="password"
                            placeholder="New Password"
                            class="w-full rounded-lg border-gray-300">

                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm New Password"
                            class="w-full rounded-lg border-gray-300">

                    </div>

                    <button
                        type="submit"
                        class="mt-5 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">

                        Update Password

                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>