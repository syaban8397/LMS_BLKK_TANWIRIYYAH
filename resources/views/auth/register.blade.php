<x-guest-layout>

<div class="min-h-screen flex bg-slate-100">


<!-- LEFT SIDE -->
<div class="hidden lg:flex w-1/2 relative overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-indigo-800 to-sky-900"></div>

    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

    <div class="relative z-10 flex flex-col justify-center px-16 text-white">

        <div class="mb-10">

            <h1 class="text-5xl font-extrabold leading-tight">
                LMS BLKK
                <br>
                Tanwiriyyah
            </h1>

            <p class="mt-6 text-lg text-blue-100 leading-relaxed">
                Modern Learning Management System designed to support
                training, certification, and competency development.
            </p>

        </div>

        <div class="grid grid-cols-2 gap-6">

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">
                <div class="text-3xl mb-3">📚</div>
                <h3 class="font-semibold text-lg">Learning Materials</h3>
                <p class="text-sm text-blue-100 mt-2">
                    Structured modules that are easy to understand.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">
                <div class="text-3xl mb-3">🎓</div>
                <h3 class="font-semibold text-lg">Certification</h3>
                <p class="text-sm text-blue-100 mt-2">
                    Earn certificates after completing courses.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">
                <div class="text-3xl mb-3">📈</div>
                <h3 class="font-semibold text-lg">Progress Tracking</h3>
                <p class="text-sm text-blue-100 mt-2">
                    Monitor your learning progress in real-time.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">
                <div class="text-3xl mb-3">💻</div>
                <h3 class="font-semibold text-lg">Online Learning</h3>
                <p class="text-sm text-blue-100 mt-2">
                    Learn anytime and anywhere.
                </p>
            </div>

        </div>

    </div>

</div>

<!-- RIGHT SIDE -->
<div class="w-full lg:w-1/2 flex items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl p-8">

        <div class="text-center mb-8">

            <div
                class="w-20 h-20 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 mx-auto flex items-center justify-center text-white text-3xl shadow-lg">

                🎓

            </div>

            <h2 class="mt-5 text-3xl font-bold text-slate-800">
                Create Account
            </h2>

            <p class="text-slate-500 mt-2">
                Register to access LMS BLKK Tanwiriyyah
            </p>

        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- FULL NAME -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Full Name
                    </label>

                    <x-text-input
                        id="name"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address
                    </label>

                    <x-text-input
                        id="email"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        National ID Number (NIK)
                    </label>

                    <x-text-input
                        id="nik"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        type="text"
                        name="nik"
                        :value="old('nik')" />

                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                </div>

                <!-- PHONE -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Phone Number
                    </label>

                    <x-text-input
                        id="phone"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        type="text"
                        name="phone"
                        :value="old('phone')" />

                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- GENDER -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Gender
                    </label>

                    <select
                        id="gender"
                        name="gender"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

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

                <!-- BIRTH PLACE -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Birth Place
                    </label>

                    <x-text-input
                        id="birth_place"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        type="text"
                        name="birth_place"
                        :value="old('birth_place')" />

                    <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                </div>

                <!-- BIRTH DATE -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Birth Date
                    </label>

                    <x-text-input
                        id="birth_date"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        type="date"
                        name="birth_date"
                        :value="old('birth_date')" />

                    <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                </div>

                <!-- ADDRESS -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Address
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="1"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('address') }}</textarea>

                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>

                    <div class="relative">

                        <x-text-input
                            id="password"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-12"
                            type="password"
                            name="password"
                            required />

                        <button
                            type="button"
                            onclick="togglePassword('password')"
                            class="absolute right-4 top-3">
                            👁️
                        </button>

                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- CONFIRM PASSWORD -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirm Password
                    </label>

                    <div class="relative">

                        <x-text-input
                            id="password_confirmation"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-12"
                            type="password"
                            name="password_confirmation"
                            required />

                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation')"
                            class="absolute right-4 top-3">
                            👁️
                        </button>

                    </div>

                    <x-input-error
                        :messages="$errors->get('password_confirmation')"
                        class="mt-2" />

                </div>

            </div>

            <button
                type="submit"
                class="w-full mt-8 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-3 rounded-xl font-semibold shadow-lg transition duration-300">

                Create Account

            </button>

            <div class="text-center mt-5">

                <a
                    href="{{ route('login') }}"
                    class="text-sm text-gray-600 hover:text-blue-600">

                    Already have an account?
                    <span class="font-semibold">
                        Sign In
                    </span>

                </a>

            </div>

        </form>

    </div>

</div>


</div>

<script>
function togglePassword(id) {
    const field = document.getElementById(id);

    if (field.type === 'password') {
        field.type = 'text';
    } else {
        field.type = 'password';
    }
}
</script>

</x-guest-layout>
