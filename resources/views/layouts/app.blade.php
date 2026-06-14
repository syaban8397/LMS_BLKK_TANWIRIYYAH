<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="h-full"
      data-authenticated-app="1"
      data-user-role="{{ auth()->user()->role ?? 'guest' }}"
      data-user-id="{{ auth()->id() ?? '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LMS BLKK Tanwiriyyah</title>

    {{-- Navigation loader — sync with sessionStorage from previous page --}}
    <script>
        (function () {
            try {
                if (sessionStorage.getItem('lms-nav-active') === '1') {
                    document.documentElement.classList.add('lms-nav-loading');
                }
            } catch (e) {}
        })();
    </script>
    <script>
        (function () {
            try {
                var role = @json(auth()->user()->role ?? 'guest');
                var uid = @json(auth()->id() ?? '');
                var base = 'lms-theme-' + role;
                var key = uid ? base + '-' + uid : base;
                var theme = localStorage.getItem(key) || localStorage.getItem(base) || 'light';
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen">

<x-lms-page-loader />

<!-- SIDEBAR -->
<div id="sidebar" class="premium-sidebar w-64">
    @include('layouts.navigation')
</div>

<!-- MAIN CONTENT -->
<div id="mainContent" class="ml-64 min-h-screen transition-all duration-300">
    <!-- Top Navigation Bar -->
    <header class="glass-nav h-16">
        <div class="h-full px-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button id="toggleSidebarBtn"
                        class="theme-toggle-btn w-9 h-9 text-lg text-slate-600 dark:text-slate-300"
                        aria-label="Toggle sidebar">
                    ☰
                </button>
                <div>
                    <h1 class="text-base font-bold text-slate-800 dark:text-slate-100">LMS BLKK Tanwiriyyah</h1>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Learning Management System</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Theme Toggle -->
                <x-theme-toggle />

                <!-- Clock -->
                <div class="hidden sm:block text-right glass-panel px-3 py-1.5 rounded-xl border border-slate-200/60 dark:border-slate-600/50">
                    <div id="current-date" class="text-[10px] text-slate-500 dark:text-slate-400"></div>
                    <div id="current-time" class="font-bold text-brand-700 dark:text-brand-300 text-sm tabular-nums"></div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileButton"
                            class="flex items-center gap-3 glass-panel hover:ring-2 hover:ring-brand-500/20 rounded-xl px-3 py-2 transition-all duration-300">
                        @php $user = Auth::user(); @endphp
                        @if($user->photo)
                            <img src="{{ Storage::url($user->photo) }}" class="w-9 h-9 rounded-xl object-cover ring-2 ring-white/20" alt="">
                        @else
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-600 to-indigo-700 flex items-center justify-center text-white font-bold text-sm shadow-3d-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="text-left hidden md:block">
                            <div class="font-semibold text-sm text-slate-800 dark:text-slate-100">{{ $user->name }}</div>
                            <div class="text-[10px] text-slate-500 dark:text-slate-400 capitalize">{{ $user->role }}</div>
                        </div>
                        <span class="text-slate-400 text-xs hidden md:inline">▼</span>
                    </button>

                    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-56 premium-card py-1 z-50 border border-slate-200/80 dark:border-slate-600/60">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-brand-50 dark:hover:bg-slate-700/60 transition">👤 Profile</a>
                        <a href="{{ route(auth()->user()->role.'.dashboard') }}" class="block px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-brand-50 dark:hover:bg-slate-700/60 transition">📊 Dashboard</a>
                        <div class="border-t border-slate-100 dark:border-slate-700/60 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 transition">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="p-4 sm:p-6 lg:p-8 max-w-[1600px] mx-auto page-content-3d">
        @isset($header)
            <div class="mb-6">{{ $header }}</div>
        @endisset
        {{ $slot }}
    </main>
</div>

<x-lms-dialog />

<script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    let sidebarOpen;

    if (localStorage.getItem('sidebarOpen') === null) {
        sidebarOpen = true;
        localStorage.setItem('sidebarOpen', true);
    } else {
        sidebarOpen = localStorage.getItem('sidebarOpen') === 'true';
    }

    function applySidebarState() {
        if (sidebarOpen) {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            mainContent.classList.remove('ml-20');
            mainContent.classList.add('ml-64');
            document.querySelectorAll('.menu-text').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.logo-text').forEach(el => el.classList.remove('hidden'));
        } else {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            mainContent.classList.remove('ml-64');
            mainContent.classList.add('ml-20');
            document.querySelectorAll('.menu-text').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.logo-text').forEach(el => el.classList.add('hidden'));
        }
    }

    document.getElementById('toggleSidebarBtn').addEventListener('click', () => {
        sidebarOpen = !sidebarOpen;
        localStorage.setItem('sidebarOpen', sidebarOpen);
        applySidebarState();
    });

    document.getElementById('profileButton').addEventListener('click', (e) => {
        e.stopPropagation();
        document.getElementById('profileMenu').classList.toggle('hidden');
    });

    window.addEventListener('click', (e) => {
        const menu = document.getElementById('profileMenu');
        const button = document.getElementById('profileButton');
        if (!button.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });

    function updateClock() {
        const now = new Date();
        const dateEl = document.getElementById('current-date');
        const timeEl = document.getElementById('current-time');
        if (dateEl) {
            dateEl.innerHTML = now.toLocaleDateString('id-ID', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
            });
        }
        if (timeEl) {
            timeEl.innerHTML = now.toLocaleTimeString('id-ID', {
                hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        applySidebarState();
        updateClock();
        setInterval(updateClock, 1000);
    });
</script>
</body>
</html>
