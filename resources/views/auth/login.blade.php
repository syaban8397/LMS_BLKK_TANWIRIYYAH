<x-guest-layout>

@if(session('success'))

<script>
    alert("{{ session('success') }}");
</script>

@endif

@if(session('error'))

<script>
    alert("{{ session('error') }}");
</script>

@endif

<div class="min-h-screen flex bg-slate-100">


<!-- LEFT SIDE -->
<div class="hidden lg:flex w-1/2 relative overflow-hidden">

    <div
        class="absolute inset-0 bg-gradient-to-br from-blue-900 via-indigo-800 to-sky-900">
    </div>

    <div
        class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
    </div>

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

            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                <div class="text-3xl mb-3">📚</div>

                <h3 class="font-semibold text-lg">
                    Learning Materials
                </h3>

                <p class="text-sm text-blue-100 mt-2">
                    Structured modules that are easy to understand.
                </p>

            </div>

            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                <div class="text-3xl mb-3">🎓</div>

                <h3 class="font-semibold text-lg">
                    Certification
                </h3>

                <p class="text-sm text-blue-100 mt-2">
                    Earn certificates after completing courses.
                </p>

            </div>

            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                <div class="text-3xl mb-3">📈</div>

                <h3 class="font-semibold text-lg">
                    Progress Tracking
                </h3>

                <p class="text-sm text-blue-100 mt-2">
                    Monitor your learning progress in real-time.
                </p>

            </div>

            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                <div class="text-3xl mb-3">💻</div>

                <h3 class="font-semibold text-lg">
                    Online Learning
                </h3>

                <p class="text-sm text-blue-100 mt-2">
                    Learn anytime and anywhere.
                </p>

            </div>

        </div>

    </div>

</div>

<!-- RIGHT SIDE -->
<div
    class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">

    <div
        class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-10">

        <div class="text-center mb-8">

            <div
                class="w-20 h-20 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 mx-auto flex items-center justify-center text-white text-3xl shadow-lg">

                🎓

            </div>

            <h2 class="mt-5 text-3xl font-bold text-slate-800">
                LMS BLKK Tanwiriyyah
            </h2>

            <p class="text-slate-500 mt-2">
                Sign in to continue your learning journey
            </p>

        </div>

        <x-auth-session-status
            class="mb-4"
            :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- EMAIL -->
            <div>

                <label
                    class="block text-sm font-semibold text-gray-700 mb-2">
                    Email Address
                </label>

                <x-text-input
                    id="email"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus />

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-2" />

            </div>

            <!-- PASSWORD -->
            <div class="mt-5">

                <label
                    class="block text-sm font-semibold text-gray-700 mb-2">
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
                        onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-blue-600">

                        👁️

                    </button>

                </div>

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2" />

            </div>

            <!-- REMEMBER -->
            <div
                class="flex items-center justify-between mt-5">

                <label
                    class="inline-flex items-center">

                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">

                    <span
                        class="ml-2 text-sm text-gray-600">
                        Remember Me
                    </span>

                </label>

                <a
                    href="{{ route('password.request') }}"
                    class="text-sm text-blue-600 hover:text-blue-700">

                    Forgot Password?

                </a>

            </div>

            <!-- LOGIN BUTTON -->
            <button
                type="submit"
                class="w-full mt-8 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-3 rounded-xl font-semibold shadow-lg transition duration-300">

                Sign In

            </button>

            <!-- REGISTER -->
            <div class="text-center mt-6">

                <a
                    href="{{ route('register') }}"
                    class="text-sm text-gray-600 hover:text-blue-600">

                    Don't have an account?
                    <span class="font-semibold">
                        Register Now
                    </span>

                </a>

            </div>

        </form>

    </div>

</div>


</div>

<script>
function togglePassword() {

    const password = document.getElementById('password');

    if (password.type === 'password') {
        password.type = 'text';
    } else {
        password.type = 'password';
    }

}
</script>

</x-guest-layout>
