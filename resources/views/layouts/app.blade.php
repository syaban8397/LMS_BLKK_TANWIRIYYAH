<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LMS BLKK Tanwiriyyah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Modern professional style */
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        }

        /* Smooth sidebar transition */
        #sidebar {
            transition: width 0.3s ease;
        }

        /* Hover effects for cards (only on hover) */
        .dashboard-card {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.1);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #2b4f8c;
            border-radius: 10px;
        }
    </style>
</head>
<body class="antialiased">

<!-- SIDEBAR -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 via-indigo-900 to-slate-900 shadow-2xl transition-all duration-300 overflow-hidden">
    @include('layouts.navigation')
</div>

<!-- MAIN CONTENT -->
<div id="mainContent" class="ml-64 min-h-screen transition-all duration-300">
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm">
        <div class="h-16 px-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button id="toggleSidebarBtn" class="text-2xl text-slate-600 hover:text-blue-600 transition">
                    ☰
                </button>
                <h1 class="text-lg font-bold text-slate-800">LMS BLKK Tanwiriyyah</h1>
            </div>

            <div class="flex items-center gap-5">
                <!-- Clock -->
                <div class="text-right">
                    <div id="current-date" class="text-xs text-slate-500"></div>
                    <div id="current-time" class="font-bold text-blue-700 text-sm"></div>
                </div>

                <!-- Profile Dropdown dengan Foto -->
                <div class="relative">
                    <button id="profileButton" class="flex items-center gap-3 hover:bg-slate-100 rounded-xl px-3 py-2 transition">
                        @php $user = Auth::user(); @endphp
                        @if($user->photo)
                            <img src="{{ Storage::url($user->photo) }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="text-left">
                            <div class="font-semibold text-slate-800">{{ $user->name }}</div>
                            <div class="text-xs text-slate-500">{{ ucfirst($user->role) }}</div>
                        </div>
                        <span class="text-slate-500">▼</span>
                    </button>

                    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border overflow-hidden">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 hover:bg-slate-100">👤 Profile</a>
                        <a href="{{ route(auth()->user()->role.'.dashboard') }}" class="block px-4 py-3 hover:bg-slate-100">📊 Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 hover:bg-red-50 text-red-600">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="p-6">
        @isset($header)
            <div class="mb-6">{{ $header }}</div>
        @endisset
        {{ $slot }}
    </main>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    let sidebarOpen;

    if(localStorage.getItem('sidebarOpen') === null) {
        sidebarOpen = true;
        localStorage.setItem('sidebarOpen', true);
    } else {
        sidebarOpen = localStorage.getItem('sidebarOpen') === 'true';
    }

    function applySidebarState() {
        if(sidebarOpen) {
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
        document.getElementById('profileMenu').classList.toggle('hidden');
    });

    window.addEventListener('click', (e) => {
        const menu = document.getElementById('profileMenu');
        const button = document.getElementById('profileButton');
        if(!button.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
    });

    function updateClock() {
        const now = new Date();
        document.getElementById('current-date').innerHTML = now.toLocaleDateString('id-ID', {
            weekday:'long', day:'numeric', month:'long', year:'numeric'
        });
        document.getElementById('current-time').innerHTML = now.toLocaleTimeString('id-ID', {
            hour12:false, hour:'2-digit', minute:'2-digit', second:'2-digit'
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        applySidebarState();
        updateClock();
        setInterval(updateClock, 1000);
    });
</script>
</body>
</html>