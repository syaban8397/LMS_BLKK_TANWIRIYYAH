<x-app-layout>

<div class="space-y-6">

    <!-- HERO (SAMAKAN STYLE DENGAN DASHBOARD LAIN) -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 text-white shadow-lg">

        <h1 class="text-3xl font-bold">
            Welcome Back, {{ auth()->user()->name }}
        </h1>

        <p class="mt-2 text-blue-100">
            Participant Dashboard - LMS BLKK Tanwiriyyah
        </p>

    </div>

    <!-- STATS (PAKAI STYLE SAMA SEMUA DASHBOARD) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500">My Classes</p>
            <h2 class="text-4xl font-bold text-blue-600 mt-2">
                {{ $classes ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500">Materials</p>
            <h2 class="text-4xl font-bold text-green-600 mt-2">
                {{ $materials ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500">Assignments</p>
            <h2 class="text-4xl font-bold text-purple-600 mt-2">
                {{ $assignments ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500">Certificates</p>
            <h2 class="text-4xl font-bold text-orange-600 mt-2">
                {{ $certificates ?? 0 }}
            </h2>
        </div>

    </div>

    <!-- PROGRESS (SAMAKAN STYLE BOX STATUS DASHBOARD LAIN) -->
    <div class="grid md:grid-cols-3 gap-5">

        <div class="bg-green-50 border border-green-200 rounded-3xl p-5">
            <h3 class="font-semibold text-green-700">Completed Classes</h3>
            <div class="text-4xl font-bold text-green-600 mt-2">
                {{ $completedClasses ?? 0 }}
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-5">
            <h3 class="font-semibold text-yellow-700">Pending Assignments</h3>
            <div class="text-4xl font-bold text-yellow-600 mt-2">
                {{ $pendingAssignments ?? 0 }}
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-3xl p-5">
            <h3 class="font-semibold text-blue-700">Attendance Rate</h3>
            <div class="text-4xl font-bold text-blue-600 mt-2">
                {{ $attendancePercentage ?? 0 }}%
            </div>
        </div>

    </div>

    <!-- QUICK ACCESS (SAMAKAN DENGAN INSTRUCTOR DASHBOARD STYLE) -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-xl font-bold text-slate-800">
                Quick Access
            </h2>

            <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm">
                Participant Menu
            </span>

        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <a href="#"
               class="bg-blue-600 text-white p-5 rounded-2xl hover:bg-blue-700 transition">

                🏫 My Classes

            </a>

            <a href="#"
               class="bg-green-600 text-white p-5 rounded-2xl hover:bg-green-700 transition">

                📖 Materials

            </a>

            <a href="#"
               class="bg-purple-600 text-white p-5 rounded-2xl hover:bg-purple-700 transition">

                📝 Assignments

            </a>

            <a href="#"
               class="bg-orange-600 text-white p-5 rounded-2xl hover:bg-orange-700 transition">

                📜 Certificates

            </a>

        </div>

    </div>

</div>

</x-app-layout>