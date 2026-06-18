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
                    Buat Kata Sandi
                    <br>
                    Baru
                </h1>

                <p class="mt-6 text-lg text-blue-100 leading-relaxed">
                    Identitas Anda telah berhasil diverifikasi.
                    Buat kata sandi yang kuat untuk mengamankan akun LMS Anda.
                </p>

            </div>

            <div class="grid grid-cols-2 gap-6">

                <div
                    class="bg-white/10 backdrop-blur-md rounded-lg p-5 border border-white/20">

                    <div class="text-3xl mb-3">🔐</div>

                    <h3 class="font-semibold text-lg">
                        Akun Aman
                    </h3>

                    <p class="text-sm text-blue-100 mt-2">
                        Lindungi data pembelajaran Anda dengan kata sandi yang kuat.
                    </p>

                </div>

                <div
                    class="bg-white/10 backdrop-blur-md rounded-lg p-5 border border-white/20">

                    <div class="text-3xl mb-3">🛡️</div>

                    <h3 class="font-semibold text-lg">
                        Keamanan Kata Sandi
                    </h3>

                    <p class="text-sm text-blue-100 mt-2">
                        Gunakan kata sandi unik yang hanya Anda ketahui.
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
                    class="w-20 h-20 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-700 mx-auto flex items-center justify-center text-white shadow-lg overflow-hidden">

                    <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-14 w-auto">

                </div>

                <h2 class="mt-5 text-3xl font-bold text-slate-800">
                    Atur Ulang Kata Sandi
                </h2>

                <p class="text-slate-500 mt-2">
                    Buat kata sandi baru untuk akun Anda
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

                        Kata Sandi Baru

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

                        Konfirmasi Kata Sandi

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

                        Kata sandi sebaiknya minimal
                        <strong>8 karakter</strong>
                        untuk keamanan yang lebih baik.

                    </p>

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full mt-8 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-3 rounded-xl font-semibold shadow-lg transition duration-300">

                    Simpan Kata Sandi Baru

                </button>

                <!-- BACK LOGIN -->
                <div class="text-center mt-6">

                    <a
                        href="{{ route('login') }}"
                        class="text-sm text-gray-600 hover:text-blue-600">

                        ← Kembali ke Login

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