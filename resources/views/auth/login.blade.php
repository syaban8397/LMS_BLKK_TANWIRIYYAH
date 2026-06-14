<x-guest-layout>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animasi fade in 3D */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px) rotateX(15deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotateX(0);
            }
        }

        /* Card Login — profesional, tidak berlebihan */
        .login-card {
            background: #ffffff;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 20px 40px -16px rgba(15, 23, 42, 0.12);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            animation: fadeInUp 0.7s ease-out forwards;
            opacity: 0;
        }

        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 48px -16px rgba(15, 23, 42, 0.18);
        }

        /* Input field modern dengan efek 3D saat focus */
        .input-luxury {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 0.9rem 1.2rem;
            color: #0f172a;
            width: 100%;
            transition: all 0.3s ease;
        }

        .input-luxury:focus {
            background: #ffffff;
            border-color: #3b82f6;
            outline: none;
            transform: scale(1.02) translateZ(5px);
            box-shadow: 0 10px 20px -8px rgba(0, 0, 0, 0.1), 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .input-luxury::placeholder {
            color: #94a3b8;
        }

        /* Tombol Login 3D dengan efek press */
        .btn-login {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: none;
            border-radius: 1rem;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            cursor: pointer;
            transform: translateY(0) scale(1);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #0f172a, #020617);
        }

        .btn-login:active {
            transform: translateY(2px) scale(0.98);
        }

        /* Floating shapes 3D dengan gerakan organik */
        .shape-3d {
            position: fixed;
            background: rgba(59, 130, 246, 0.05);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            filter: blur(40px);
            z-index: -1;
            animation: morph 15s infinite alternate;
        }

        @keyframes morph {
            0% {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                transform: translate(0, 0) rotate(0deg);
            }
            100% {
                border-radius: 70% 30% 30% 70% / 60% 40% 60% 40%;
                transform: translate(30px, -30px) rotate(10deg);
            }
        }

        .shape1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
            background: rgba(59, 130, 246, 0.08);
        }

        .shape2 {
            width: 500px;
            height: 500px;
            bottom: -150px;
            right: -100px;
            background: rgba(99, 102, 241, 0.06);
            animation-duration: 18s;
        }

        .shape3 {
            width: 300px;
            height: 300px;
            top: 40%;
            right: 10%;
            background: rgba(37, 99, 235, 0.05);
            animation-duration: 12s;
        }

        /* Flash message */
        .flash-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            padding: 12px 24px;
            border-radius: 40px;
            background: white;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
            color: #0f172a;
            font-weight: 500;
            border-left: 4px solid;
            animation: fadeInUp 0.3s ease;
        }

        .flash-success {
            border-left-color: #10b981;
            color: #065f46;
            background: #ecfdf5;
        }

        .flash-error {
            border-left-color: #ef4444;
            color: #991b1b;
            background: #fef2f2;
        }

        /* Link register */
        .register-link {
            color: #3b82f6;
            transition: all 0.2s;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link:hover {
            color: #1e3a8a;
            text-decoration: underline;
        }
    </style>

    <!-- Floating shapes 3D -->
    <div class="shape-3d shape1"></div>
    <div class="shape-3d shape2"></div>
    <div class="shape-3d shape3"></div>

    @if(session('success'))
        <div class="flash-message flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-message flash-error">{{ session('error') }}</div>
    @endif

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="login-card w-full max-w-md p-8 md:p-10">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <img src="{{ asset('storage/images/Logo.png') }}" alt="YMT Creator Base" class="h-20 w-auto mx-auto drop-shadow-md mb-4">
                <h2 class="text-3xl font-bold text-slate-800">Welcome Back</h2>
                <p class="text-slate-500 text-sm mt-1">Sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input-luxury" placeholder="your@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="input-luxury pr-12" placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                            <i class="fas fa-eye-slash" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Login (tanpa loading) -->
                <button type="submit" class="btn-login">
                    Sign In
                </button>

                <!-- Link Register -->
                <div class="text-center mt-6">
                    <a href="{{ route('register') }}" class="register-link text-sm">
                        Don't have an account? <span class="font-bold">Register Now</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                pwd.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        // Auto-hide flash messages after 3 seconds
        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 3000);
    </script>
</x-guest-layout>