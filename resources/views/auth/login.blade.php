<x-guest-layout>
    <style>
        /* Hover animations only - no auto animation */
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .glass-card:hover {
            transform: translateY(-6px);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.2);
        }

        .login-card {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.25);
        }

        /* Tombol hover effect */
        .btn-login {
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
        }

        /* Input focus effect */
        input:focus {
            transform: scale(1.01);
            transition: transform 0.2s ease;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>

    @if(session('success'))
        <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-green-100 border-l-4 border-green-600 text-green-800 p-4 rounded-xl shadow-lg" style="z-index: 999;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-red-100 border-l-4 border-red-600 text-red-800 p-4 rounded-xl shadow-lg" style="z-index: 999;">
            {{ session('error') }}
        </div>
    @endif

    <div class="min-h-screen flex bg-gradient-to-br from-blue-50 via-indigo-50 to-white">

        <!-- LEFT SIDE: Branding dan Features -->
        <div class="hidden lg:flex w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-800 via-indigo-800 to-sky-800 opacity-90"></div>
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
                    <div class="glass-card p-5">
                        <div class="text-3xl mb-3">📚</div>
                        <h3 class="font-semibold text-lg">Learning Materials</h3>
                        <p class="text-sm text-blue-100 mt-2">Structured modules that are easy to understand.</p>
                    </div>
                    <div class="glass-card p-5">
                        <div class="text-3xl mb-3">🎓</div>
                        <h3 class="font-semibold text-lg">Certification</h3>
                        <p class="text-sm text-blue-100 mt-2">Earn certificates after completing courses.</p>
                    </div>
                    <div class="glass-card p-5">
                        <div class="text-3xl mb-3">📈</div>
                        <h3 class="font-semibold text-lg">Progress Tracking</h3>
                        <p class="text-sm text-blue-100 mt-2">Monitor your learning progress in real-time.</p>
                    </div>
                    <div class="glass-card p-5">
                        <div class="text-3xl mb-3">💻</div>
                        <h3 class="font-semibold text-lg">Online Learning</h3>
                        <p class="text-sm text-blue-100 mt-2">Learn anytime and anywhere.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md login-card bg-white rounded-3xl shadow-2xl p-10">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 mx-auto flex items-center justify-center text-white text-3xl shadow-lg">
                        🎓
                    </div>
                    <h2 class="mt-5 text-3xl font-bold text-slate-800">LMS BLKK Tanwiriyyah</h2>
                    <p class="text-slate-500 mt-2">Sign in to continue your learning journey</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <x-text-input
                            id="email"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- PASSWORD -->
                    <div class="mt-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <x-text-input
                                id="password"
                                class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-12 transition"
                                type="password"
                                name="password"
                                required />
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-blue-600 transition">
                                👁️
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- REMEMBER & FORGOT -->
                    <div class="flex items-center justify-between mt-5">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Remember Me</span>
                        </label>
                        <a href="{{ route('password.request.custom') }}" class="text-sm text-blue-600 hover:text-blue-700 transition">Forgot Password?</a>
                    </div>

                    <!-- LOGIN BUTTON -->
                    <button type="submit" class="btn-login w-full mt-8 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-3 rounded-xl font-semibold shadow-lg transition duration-300">
                        Sign In
                    </button>

                    <!-- REGISTER -->
                    <div class="text-center mt-6">
                        <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">
                            Don't have an account?
                            <span class="font-semibold">Register Now</span>
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

        // Auto-hide flash messages after 3 seconds
        setTimeout(() => {
            document.querySelectorAll('.fixed.top-24').forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 3000);
    </script>
</x-guest-layout>