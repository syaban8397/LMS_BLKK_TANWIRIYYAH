<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LMS BLKK Tanwiriyyah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 antialiased">

    @include('layouts.navigation')

    <div class="ml-64 min-h-screen">

        <!-- TOPBAR -->
        <header class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-40">

            <div class="px-8 py-4 flex justify-between items-center">

                <div>
                    <h1 class="text-xl font-bold text-slate-800">
                        LMS BLKK Tanwiriyyah
                    </h1>

                    <p class="text-sm text-slate-500">
                        Learning Management System
                    </p>
                </div>

                <div class="flex items-center gap-6">

                    <div class="text-right">
                        <div id="current-date" class="text-sm text-slate-500"></div>
                        <div id="current-time" class="font-bold text-blue-700"></div>
                    </div>

                    <div class="h-10 w-px bg-slate-200"></div>

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                        </div>

                        <div>
                            <div class="font-semibold text-slate-800">
                                {{ Auth::user()->name }}
                            </div>

                            <div class="text-sm text-slate-500">
                                {{ ucfirst(Auth::user()->role) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </header>

        <main class="p-6">
            {{ $slot }}
        </main>

    </div>

<script>
function updateClock() {

    const now = new Date();

    document.getElementById('current-date').innerHTML =
        now.toLocaleDateString('id-ID',{
            weekday:'long',
            day:'numeric',
            month:'long',
            year:'numeric'
        });

    document.getElementById('current-time').innerHTML =
        now.toLocaleTimeString('id-ID');
}

setInterval(updateClock,1000);
updateClock();
</script>

</body>
</html>