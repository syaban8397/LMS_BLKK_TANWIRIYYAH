<x-guest-layout>

<div class="min-h-screen flex bg-slate-100">

    <!-- LEFT SIDE -->
    <div class="hidden lg:flex w-1/2 relative overflow-hidden">

        <div
            class="absolute inset-0 bg-gradient-to-br from-blue-900 via-indigo-800 to-sky-900">
        </div>

        <div
            class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
        </div>

        <div
            class="relative z-10 flex flex-col justify-center px-16 text-white">

            <div class="mb-10">

                <h1 class="text-5xl font-extrabold leading-tight">
                    Create New
                    <br>
                    Password
                </h1>

                <p class="mt-6 text-lg text-blue-100 leading-relaxed">
                    Your identity has been successfully verified.
                    Create a strong password to secure your LMS account.
                </p>

            </div>

            <div class="grid grid-cols-2 gap-6">

                <div
                    class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                    <div class="text-3xl mb-3">🔐</div>

                    <h3 class="font-semibold text-lg">
                        Secure Account
                    </h3>

                    <p class="text-sm text-blue-100 mt-2">
                        Protect your learning data with a strong password.
                    </p>

                </div>

                <div
                    class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                    <div class="text-3xl mb-3">🛡️</div>

                    <h3 class="font-semibold text-lg">
                        Password Security
                    </h3>

                    <p class="text-sm text-blue-100 mt-2">
                        Use a unique password that only you know.
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

                    🔑

                </div>

                <h2 class="mt-5 text-3xl font-bold text-slate-800">
                    Reset Password
                </h2>

                <p class="text-slate-500 mt-2">
                    Create a new password for your account
                </p>

            </div>

            <form
                method="POST"
                action="{{ route('password.reset.custom') }}">

                @csrf

                <!-- PASSWORD -->
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">

                        New Password

                    </label>

                    <div class="relative">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-12">

                        <button
                            type="button"
                            onclick="togglePassword('password','eye1')"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-blue-600">

                            <span id="eye1">
                                👁️
                            </span>

                        </button>

                    </div>

                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mt-5">

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">

                        Confirm Password

                    </label>

                    <div class="relative">

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-12">

                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation','eye2')"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-blue-600">

                            <span id="eye2">
                                👁️
                            </span>

                        </button>

                    </div>

                </div>

                <!-- INFO -->
                <div
                    class="mt-5 bg-blue-50 border border-blue-100 rounded-xl p-4">

                    <p class="text-sm text-blue-700">

                        Password should contain at least
                        <strong>8 characters</strong>
                        for better security.

                    </p>

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full mt-8 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-3 rounded-xl font-semibold shadow-lg transition duration-300">

                    Save New Password

                </button>

                <!-- BACK LOGIN -->
                <div class="text-center mt-6">

                    <a
                        href="{{ route('login') }}"
                        class="text-sm text-gray-600 hover:text-blue-600">

                        ← Back to Login

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

function togglePassword(fieldId, eyeId)
{
    const field = document.getElementById(fieldId);

    if (field.type === 'password')
    {
        field.type = 'text';
    }
    else
    {
        field.type = 'password';
    }
}

</script>

</x-guest-layout>