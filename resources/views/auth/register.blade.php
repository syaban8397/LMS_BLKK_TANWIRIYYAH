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

        /* Card Register — profesional */
        .register-card {
            background: #ffffff;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 20px 40px -16px rgba(15, 23, 42, 0.12);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            animation: fadeInUp 0.7s ease-out forwards;
            opacity: 0;
            width: 100%;
            max-width: 1000px;
        }

        .register-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 48px -16px rgba(15, 23, 42, 0.16);
        }

        /* Input field modern */
        .input-luxury {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 0.7rem 1rem;
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

        select.input-luxury {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23475569' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.2rem;
        }

        /* Tombol Register 3D */
        .btn-register {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: none;
            border-radius: 1rem;
            padding: 0.8rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            cursor: pointer;
            transform: translateY(0) scale(1);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.2);
        }

        .btn-register:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #0f172a, #020617);
        }

        .btn-register:active {
            transform: translateY(2px) scale(0.98);
        }

        /* Floating shapes 3D - background */
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

        /* Label */
        label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
            display: block;
        }

        /* Link login */
        .login-link {
            color: #3b82f6;
            transition: all 0.2s;
            text-decoration: none;
            font-weight: 500;
        }
        .login-link:hover {
            color: #1e3a8a;
            text-decoration: underline;
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
    </style>

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
        <div class="register-card p-6 md:p-8">
            <!-- Logo & Title -->
            <div class="text-center mb-5">
                <img src="{{ asset('storage/images/Logo.png') }}" alt="YMT Creator Base" class="h-16 w-auto mx-auto drop-shadow-md mb-2">
                <h2 class="text-2xl font-bold text-slate-800">Create Account</h2>
                <p class="text-slate-500 text-sm">Join YMT Creator Base community</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- FULL NAME -->
                    <div>
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="input-luxury" placeholder="John Doe">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-luxury" placeholder="john@example.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label>NIK (KTP)</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" class="input-luxury" placeholder="16-digit number">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- PHONE -->
                    <div>
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="input-luxury" placeholder="+62 xxx">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- GENDER -->
                    <div>
                        <label>Gender</label>
                        <select name="gender" class="input-luxury">
                            <option value="" disabled selected>Select</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Male</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- BIRTH PLACE -->
                    <div>
                        <label>Birth Place</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="input-luxury" placeholder="City">
                        @error('birth_place') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- BIRTH DATE -->
                    <div>
                        <label>Birth Date</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="input-luxury">
                        @error('birth_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- ADDRESS -->
                    <div>
                        <label>Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="input-luxury" placeholder="Full address">
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label>Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required class="input-luxury pr-12" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>
                        <label>Confirm Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="input-luxury pr-12" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-register mt-6">
                    Create Account
                </button>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="login-link text-sm">
                        Already have an account? <span class="font-bold">Sign In</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const field = document.getElementById(id);
            const icon = field.parentElement.querySelector('button i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 3000);
    </script>
</x-guest-layout>