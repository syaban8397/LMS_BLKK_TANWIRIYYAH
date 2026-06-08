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
                    Password
                    <br>
                    Recovery
                </h1>

                <p class="mt-6 text-lg text-blue-100 leading-relaxed">
                    Verify your identity using your registered Email
                    and NIK before creating a new password.
                </p>

            </div>

            <div class="grid grid-cols-2 gap-6">

                <div
                    class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                    <div class="text-3xl mb-3">🔐</div>

                    <h3 class="font-semibold text-lg">
                        Secure Verification
                    </h3>

                    <p class="text-sm text-blue-100 mt-2">
                        Email and NIK validation for account protection.
                    </p>

                </div>

                <div
                    class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                    <div class="text-3xl mb-3">🛡️</div>

                    <h3 class="font-semibold text-lg">
                        Account Security
                    </h3>

                    <p class="text-sm text-blue-100 mt-2">
                        Only active accounts can reset passwords.
                    </p>

                </div>

                <div
                    class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                    <div class="text-3xl mb-3">⚡</div>

                    <h3 class="font-semibold text-lg">
                        Fast Recovery
                    </h3>

                    <p class="text-sm text-blue-100 mt-2">
                        Recover your account within minutes.
                    </p>

                </div>

                <div
                    class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">

                    <div class="text-3xl mb-3">🎓</div>

                    <h3 class="font-semibold text-lg">
                        LMS Access
                    </h3>

                    <p class="text-sm text-blue-100 mt-2">
                        Continue your learning journey securely.
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

                <h2
                    class="mt-5 text-3xl font-bold text-slate-800">

                    Forgot Password

                </h2>

                <p
                    class="text-slate-500 mt-2">

                    Verify your account before resetting password

                </p>

            </div>

            <form
                method="POST"
                action="{{ route('password.verify.custom') }}">

                @csrf

                <!-- EMAIL -->
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">

                        Email Address

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                </div>

                <!-- NIK -->
                <div class="mt-5">

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">

                        NIK

                    </label>

                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik') }}"
                        required
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full mt-8 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-3 rounded-xl font-semibold shadow-lg transition">

                    Verify Account

                </button>

                <!-- BACK -->
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

<!-- =========================
     ERROR POPUP
========================= -->
@if(session('popup_error'))

<div
    id="popup"
    onclick="closePopup(event)"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">

    <div
        onclick="event.stopPropagation()"
        class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden">

        <div
            class="bg-gradient-to-r from-red-600 to-rose-700 p-6 text-center text-white">

            <div class="text-6xl mb-2">
                ❌
            </div>

            <h2 class="text-2xl font-bold">
                Verification Failed
            </h2>

        </div>

        <div class="p-8 text-center">

            <p class="text-slate-600 text-lg leading-relaxed">
                {{ session('popup_error') }}
            </p>

            <button
                onclick="closePopup()"
                class="mt-8 w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition">

                Close

            </button>

        </div>

    </div>

</div>

@endif

<!-- =========================
     SUCCESS POPUP
========================= -->
@if(session('popup_success'))

<div
    id="popup"
    onclick="closePopup(event)"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">

    <div
        onclick="event.stopPropagation()"
        class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden">

        <div
            class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 text-center text-white">

            <div class="text-6xl mb-2">
                ✅
            </div>

            <h2 class="text-2xl font-bold">
                Verification Success
            </h2>

        </div>

        <div class="p-8 text-center">

            <p class="text-slate-600 text-lg leading-relaxed">
                {{ session('popup_success') }}
            </p>

            <div class="mt-8 space-y-3">

                <a
                    href="{{ route('password.form') }}"
                    class="block w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition">

                    Continue Reset Password

                </a>

                <button
                    onclick="closePopup()"
                    class="w-full py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-semibold transition">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>

@endif

<script>

function closePopup()
{
    const popup = document.getElementById('popup');

    if (popup)
    {
        popup.remove();
    }
}

</script>

</x-guest-layout>