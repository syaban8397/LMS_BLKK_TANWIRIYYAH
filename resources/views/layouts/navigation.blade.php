<nav class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 via-indigo-900 to-slate-900 shadow-2xl overflow-y-auto">

    <!-- LOGO -->
    <div class="px-6 py-6 border-b border-white/10">

        <div class="flex items-center gap-3">

            <div
                class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-2xl">

                🎓

            </div>

            <div>

                <h1 class="text-white text-xl font-bold">
                    LMS BLKK
                </h1>

                <p class="text-blue-200 text-sm">
                    Tanwiriyyah
                </p>

            </div>

        </div>

    </div>

    <!-- USER INFO -->
    <div class="px-5 py-5">

        <div
            class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10">

            <div class="flex items-center gap-3">

                <div
                    class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-lg">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>

                <div>

                    <div class="text-white font-semibold">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="text-blue-200 text-sm">
                        {{ ucfirst(Auth::user()->role) }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- MENU -->
    <div class="px-4 flex-1 overflow-y-auto">

        <p class="text-xs uppercase text-blue-300 font-semibold px-3 mb-3">
            Main Menu
        </p>

        <div class="space-y-2">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">📊</span>

                <span>
                    Dashboard
                </span>

            </a>

            <!-- Users -->
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">👥</span>

                <span>
                    User Management
                </span>

            </a>

            <!-- Participants -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">🎓</span>

                <span>
                    Participants
                </span>

            </a>

            <!-- Instructors -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">🧑‍🏫</span>

                <span>
                    Instructors
                </span>

            </a>

            <!-- Programs -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">📚</span>

                <span>
                    Training Programs
                </span>

            </a>

            <!-- Classes -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">🏫</span>

                <span>
                    Classes
                </span>

            </a>

            <!-- Certificates -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">📜</span>

                <span>
                    Certificates
                </span>

            </a>

            <!-- Reports -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">📈</span>

                <span>
                    Reports
                </span>

            </a>

            <!-- Settings -->
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition">

                <span class="text-lg">⚙️</span>

                <span>
                    Settings
                </span>

            </a>

        </div>

    </div>

    <!-- SYSTEM STATUS -->
    <div class="px-5 mt-8">

        <div
            class="bg-green-500/10 border border-green-500/20 rounded-2xl p-4">

            <div class="flex items-center gap-3">

                <div class="w-3 h-3 rounded-full bg-green-400 animate-pulse">
                </div>

                <div>

                    <div class="text-green-300 text-sm font-semibold">
                        System Status
                    </div>

                    <div class="text-white text-xs">
                        Online & Running
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="px-4 mt-8 pb-6">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold shadow-lg transition">

                🚪 Logout

            </button>

        </form>

        <div class="text-center mt-4">

            <p class="text-xs text-blue-300">
                LMS BLKK Tanwiriyyah
            </p>

            <p class="text-xs text-blue-400">
                Version 1.0
            </p>

        </div>

    </div>

</nav>