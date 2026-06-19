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
    <meta name="description" content="{{ __('lms.welcome.meta_desc') }}">
    <meta name="theme-color" content="#004071">
    <title>@if(!empty($title)){{ $title }} — @endif{{ $lmsAppDisplayName ?? __('lms.app_name') }}</title>

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
                var theme = localStorage.getItem(key) || localStorage.getItem(base) || @json($lmsDefaultTheme ?? 'light');
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen lms-app-body">

<div id="sidebar" class="premium-sidebar w-64">
    @include('layouts.navigation')
</div>

<div id="mainContent" class="ml-64 min-h-screen lms-main-shell">
    <header class="glass-nav lms-appbar h-16 shrink-0 sticky top-0 z-40 relative">
        <div class="h-full px-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button id="toggleSidebarBtn"
                        class="theme-toggle-btn w-9 h-9 text-lg"
                        aria-label="{{ __('lms.layout.toggle_sidebar') }}">
                    ☰
                </button>
                <div class="lms-appbar-logo">
                    <img src="{{ asset('storage/images/Logo.png') }}"
                         alt="{{ __('lms.app_name') }}"
                         class="lms-appbar-logo__img">
                </div>
                <div>
                    <h1 class="text-base font-bold lms-appbar__title">{{ __('lms.app_name') }}</h1>
                    <p class="text-[10px] lms-appbar__tagline uppercase tracking-wider">{{ __('lms.tagline') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <x-locale-switcher />
                <x-theme-toggle />

                <div class="hidden sm:block text-right glass-panel px-3 py-1.5">
                    <div id="current-date" class="text-[10px]"></div>
                    <div id="current-time" class="font-semibold text-sm tabular-nums"></div>
                </div>

                <div class="relative">
                    <button id="profileButton"
                            class="flex items-center gap-3 glass-panel rounded-lg px-3 py-2 transition-all duration-200">
                        @php $user = Auth::user(); @endphp
                        @if($user->hasProfilePhoto())
                            <img src="{{ $user->profilePhotoUrl() }}" class="w-9 h-9 rounded-lg object-cover ring-1 ring-slate-200 dark:ring-slate-600 shadow-3d-sm" alt="">
                        @else
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-600 to-indigo-800 flex items-center justify-center text-white font-semibold text-sm shadow-3d-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="text-left hidden md:block">
                            <div class="font-semibold text-sm lms-appbar__profile-name">{{ $user->name }}</div>
                            <div class="text-[10px] lms-appbar__profile-role capitalize">{{ __('lms.roles.' . $user->role) }}</div>
                        </div>
                        <span class="lms-appbar__chevron text-xs hidden md:inline">▼</span>
                    </button>

                    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-56 premium-card py-1 z-50 border border-slate-200/80 dark:border-slate-600/60">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-brand-50 dark:hover:bg-slate-700/60 transition">👤 {{ __('lms.profile') }}</a>
                        <a href="{{ route(auth()->user()->role.'.dashboard') }}" class="block px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-brand-50 dark:hover:bg-slate-700/60 transition">📊 {{ __('lms.dashboard.menu') }}</a>
                        <div class="border-t border-slate-100 dark:border-slate-700/60 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 transition">🚪 {{ __('lms.logout') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <x-lms-page-loader />

    <div class="lms-content-stage">
        <main class="p-4 sm:p-6 lg:p-8 max-w-[1600px] mx-auto page-content-3d">
            @isset($header)
                <div class="mb-6">{{ $header }}</div>
            @endisset
            {{ $slot }}
        </main>

        <footer class="border-t border-slate-200/80 dark:border-slate-700/60 py-4 px-6 text-center text-xs text-slate-500 dark:text-slate-400">
            <p class="mb-2">© {{ date('Y') }} {{ $lmsAppDisplayName ?? __('lms.app_name') }} · {{ __('lms.welcome.powered_by') }}</p>
            <p>
                <a href="{{ route('legal.help') }}" class="hover:text-brand-600 dark:hover:text-brand-400 transition">{{ __('lms.welcome.help') }}</a>
                <span class="mx-2">·</span>
                <a href="{{ route('legal.privacy') }}" class="hover:text-brand-600 dark:hover:text-brand-400 transition">{{ __('lms.welcome.privacy') }}</a>
                <span class="mx-2">·</span>
                <a href="{{ route('legal.terms') }}" class="hover:text-brand-600 dark:hover:text-brand-400 transition">{{ __('lms.welcome.terms') }}</a>
            </p>
        </footer>
    </div>
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
        const root = document.documentElement;
        if (sidebarOpen) {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            mainContent.classList.remove('ml-20');
            mainContent.classList.add('ml-64');
            root.style.setProperty('--lms-sidebar-width', '16rem');
            document.querySelectorAll('.menu-text').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.logo-text').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.sidebar-logo-mark').forEach(el => { el.classList.add('hidden'); el.classList.remove('flex'); });
        } else {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            mainContent.classList.remove('ml-64');
            mainContent.classList.add('ml-20');
            root.style.setProperty('--lms-sidebar-width', '5rem');
            document.querySelectorAll('.menu-text').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.logo-text').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.sidebar-logo-mark').forEach(el => { el.classList.remove('hidden'); el.classList.add('flex'); });
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
        const locale = @json(app()->getLocale() === 'en' ? 'en-US' : 'id-ID');
        if (dateEl) {
            dateEl.innerHTML = now.toLocaleDateString(locale, {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
            });
        }
        if (timeEl) {
            timeEl.innerHTML = now.toLocaleTimeString(locale, {
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
