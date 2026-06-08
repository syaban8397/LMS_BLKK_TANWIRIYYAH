<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


<meta charset="utf-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<meta name="csrf-token"
      content="{{ csrf_token() }}">

<title>
    LMS BLKK Tanwiriyyah
</title>

@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])


</head>

<body class="bg-slate-100 antialiased">

<!-- SIDEBAR -->
<div
    id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 via-indigo-900 to-slate-900 shadow-2xl transition-all duration-300 overflow-hidden">

    @include('layouts.navigation')

</div>

<!-- MAIN CONTENT -->
<div
    id="mainContent"
    class="ml-64 min-h-screen transition-all duration-300">

    <!-- APP BAR -->
    <header
        class="sticky top-0 z-40 bg-white border-b border-slate-200 shadow-sm">

        <div
            class="h-16 px-6 flex items-center justify-between">

            <!-- LEFT -->
            <div
                class="flex items-center gap-4">

                <button
                    id="toggleSidebarBtn"
                    class="text-2xl text-slate-600 hover:text-blue-600 transition">

                    ☰

                </button>

                <h1
                    class="text-lg font-bold text-slate-800">

                    LMS BLKK Tanwiriyyah

                </h1>

            </div>

            <!-- RIGHT -->
            <div
                class="flex items-center gap-5">

                <!-- CLOCK -->
                <div
                    class="text-right">

                    <div
                        id="current-date"
                        class="text-xs text-slate-500">
                    </div>

                    <div
                        id="current-time"
                        class="font-bold text-blue-700">
                    </div>

                </div>

                <!-- PROFILE -->
                <div class="relative">

                    <button
                        id="profileButton"
                        class="flex items-center gap-3 hover:bg-slate-100 rounded-xl px-3 py-2 transition">

                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold">

                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                        </div>

                        <div class="text-left">

                            <div
                                class="font-semibold text-slate-800">

                                {{ Auth::user()->name }}

                            </div>

                            <div
                                class="text-xs text-slate-500">

                                {{ ucfirst(Auth::user()->role) }}

                            </div>

                        </div>

                        <span class="text-slate-500">
                            ▼
                        </span>

                    </button>

                    <!-- DROPDOWN -->
                    <div
                        id="profileMenu"
                        class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border overflow-hidden">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="block px-4 py-3 hover:bg-slate-100">

                            👤 Profile

                        </a>

                        <a
                            href="{{ route(auth()->user()->role.'.dashboard') }}"
                            class="block px-4 py-3 hover:bg-slate-100">

                            📊 Dashboard

                        </a>

                        <form
                            method="POST"
                            action="{{ route('logout') }}">

                            @csrf

                            <button
                                type="submit"
                                class="w-full text-left px-4 py-3 hover:bg-red-50 text-red-600">

                                🚪 Logout

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </header>

    <!-- CONTENT -->
    <main class="p-6">

        @isset($header)

            <div class="mb-6">

                {{ $header }}

            </div>

        @endisset

        {{ $slot }}

    </main>

</div>


<script>

    const sidebar =
        document.getElementById('sidebar');

    const mainContent =
        document.getElementById('mainContent');

    let sidebarOpen;

    if(localStorage.getItem('sidebarOpen') === null)
    {
        sidebarOpen = true;

        localStorage.setItem(
            'sidebarOpen',
            true
        );
    }
    else
    {
        sidebarOpen =
            localStorage.getItem('sidebarOpen') === 'true';
    }

    function applySidebarState()
    {
        if(sidebarOpen)
        {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');

            mainContent.classList.remove('ml-20');
            mainContent.classList.add('ml-64');

            document
                .querySelectorAll('.menu-text')
                .forEach(el =>
                    el.classList.remove('hidden'));

            document
                .querySelectorAll('.logo-text')
                .forEach(el =>
                    el.classList.remove('hidden'));
        }
        else
        {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');

            mainContent.classList.remove('ml-64');
            mainContent.classList.add('ml-20');

            document
                .querySelectorAll('.menu-text')
                .forEach(el =>
                    el.classList.add('hidden'));

            document
                .querySelectorAll('.logo-text')
                .forEach(el =>
                    el.classList.add('hidden'));
        }
    }

    document
        .getElementById('toggleSidebarBtn')
        .addEventListener('click', function()
        {
            sidebarOpen = !sidebarOpen;

            localStorage.setItem(
                'sidebarOpen',
                sidebarOpen
            );

            applySidebarState();
        });

    document
        .getElementById('profileButton')
        .addEventListener('click', function()
        {
            document
                .getElementById('profileMenu')
                .classList
                .toggle('hidden');
        });

    window.addEventListener('click', function(e)
    {
        const menu =
            document.getElementById('profileMenu');

        const button =
            document.getElementById('profileButton');

        if(
            !button.contains(e.target)
            &&
            !menu.contains(e.target)
        )
        {
            menu.classList.add('hidden');
        }
    });

    function updateClock()
    {
        const now = new Date();

        document
            .getElementById('current-date')
            .innerHTML =
            now.toLocaleDateString(
                'id-ID',
                {
                    weekday:'long',
                    day:'numeric',
                    month:'long',
                    year:'numeric'
                }
            );

        document
            .getElementById('current-time')
            .innerHTML =
            now.toLocaleTimeString(
                'id-ID',
                {
                    hour12:false,
                    hour:'2-digit',
                    minute:'2-digit',
                    second:'2-digit'
                }
            );
    }

    document.addEventListener(
        'DOMContentLoaded',
        function()
        {
            applySidebarState();

            updateClock();

            setInterval(
                updateClock,
                1000
            );
        }
    );

</script>

</body>
</html>
