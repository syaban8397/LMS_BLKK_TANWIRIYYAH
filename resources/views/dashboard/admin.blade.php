<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Dashboard SaaS LMS
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Real-time monitoring & analytics system BLKK Tanwiriyyah
                </p>
            </div>

            <div class="flex items-center gap-3">

                <div class="flex items-center gap-2 px-3 py-2 bg-green-100 text-green-700 rounded-xl">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-600"></span>
                    </span>
                    <span class="text-sm font-medium">Live System</span>
                </div>

                <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-xl">
                    👑 Admin Panel
                </div>

            </div>

        </div>

    </x-slot>

    <div class="space-y-8">

        {{-- HERO --}}
        <div class="relative overflow-hidden rounded-3xl p-8 text-white shadow-xl bg-gradient-to-r from-indigo-900 via-blue-900 to-slate-900">

            <div class="flex flex-col lg:flex-row justify-between gap-6">

                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold">
                        Welcome back, {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-3 text-blue-100">
                        Enterprise-grade LMS analytics dashboard
                    </p>

                    <p class="mt-2 text-blue-200">
                        All metrics are updated in real-time system pipeline
                    </p>
                </div>

                <div class="hidden lg:flex text-7xl opacity-80">
                    📊
                </div>

            </div>

        </div>

        {{-- KPI SAAS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- PESERTA --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Peserta</p>
                        <h3 class="text-3xl font-bold text-blue-600 counter" data-value="{{ $participants ?? 0 }}">0</h3>

                        <p class="text-xs text-green-500 mt-1">▲ Active growth</p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                        👨‍🎓
                    </div>
                </div>
            </div>

            {{-- INSTRUKTUR --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Instruktur</p>
                        <h3 class="text-3xl font-bold text-green-600 counter" data-value="{{ $instructors ?? 0 }}">0</h3>

                        <p class="text-xs text-green-500 mt-1">▲ Stable</p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                        👨‍🏫
                    </div>
                </div>
            </div>

            {{-- KELAS --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Kelas Aktif</p>
                        <h3 class="text-3xl font-bold text-purple-600 counter" data-value="{{ $classes ?? 0 }}">0</h3>

                        <p class="text-xs text-blue-500 mt-1">● Running</p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-2xl">
                        🏫
                    </div>
                </div>
            </div>

            {{-- SERTIFIKAT --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Sertifikat</p>
                        <h3 class="text-3xl font-bold text-orange-500 counter" data-value="{{ $certificates ?? 0 }}">0</h3>

                        <p class="text-xs text-yellow-500 mt-1">★ Issued</p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-2xl">
                        📜
                    </div>
                </div>
            </div>

        </div>

        {{-- ANALYTICS SECTION --}}
        <div class="grid lg:grid-cols-3 gap-6">

            {{-- LEFT --}}
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm border">

                <div class="flex justify-between mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">
                        Activity Overview
                    </h3>

                    <span id="lastUpdate" class="text-xs text-slate-500">
                        Loading...
                    </span>
                </div>

                <div class="space-y-5 text-slate-600">

                    <div class="flex justify-between border-b pb-3">
                        <span>Attendance Session</span>
                        <span class="font-bold" id="attendanceSessions">{{ $attendanceSessions ?? 0 }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-3">
                        <span>Total Attendance</span>
                        <span class="font-bold" id="attendances">{{ $attendances ?? 0 }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-3">
                        <span>Grades Processed</span>
                        <span class="font-bold" id="grades">{{ $grades ?? 0 }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Notifications</span>
                        <span class="font-bold" id="notifications">{{ $notifications ?? 0 }}</span>
                    </div>

                </div>

            </div>

            {{-- RIGHT SYSTEM STATUS --}}
            <div class="bg-gradient-to-br from-slate-900 to-indigo-900 text-white rounded-3xl p-6 shadow-xl">

                <h3 class="font-bold mb-5 text-lg">System Health</h3>

                <div class="space-y-4 text-sm">

                    <div class="p-4 bg-white/10 rounded-2xl">
                        <p class="text-white/60 text-xs">API Server</p>
                        <p class="font-bold text-green-300">OPERATIONAL</p>
                    </div>

                    <div class="p-4 bg-white/10 rounded-2xl">
                        <p class="text-white/60 text-xs">Database</p>
                        <p class="font-bold text-green-300">SYNCED</p>
                    </div>

                    <div class="p-4 bg-white/10 rounded-2xl">
                        <p class="text-white/60 text-xs">Realtime Engine</p>
                        <p class="font-bold text-green-300">ACTIVE</p>
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- COUNTER + REALTIME --}}
    <script>
        function animateCounter(el, value) {
            let start = 0;
            let end = parseInt(value);
            let step = Math.ceil(end / 40);

            let interval = setInterval(() => {
                start += step;
                if (start >= end) {
                    start = end;
                    clearInterval(interval);
                }
                el.innerText = start;
            }, 20);
        }

        document.addEventListener("DOMContentLoaded", () => {

            document.querySelectorAll('.counter').forEach(el => {
                animateCounter(el, el.dataset.value);
            });

            setInterval(() => {
                document.getElementById('lastUpdate').innerText =
                    "Updated: " + new Date().toLocaleTimeString();
            }, 1000);

        });
    </script>

</x-app-layout>