<x-app-layout>

<div class="space-y-6">

    <!-- HERO (SAMAKAN DENGAN ADMIN STYLE) -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 text-white shadow-lg">

        <h1 class="text-3xl font-bold">
            Welcome Back, {{ auth()->user()->name }}
        </h1>

        <p class="mt-2 text-blue-100">
            Instructor Dashboard - LMS BLKK Tanwiriyyah
        </p>

    </div>

    <!-- STATISTICS (SAMAKAN ADMIN STYLE) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">My Classes</p>
            <h2 class="text-4xl font-bold text-blue-700 mt-2">
                {{ $classes ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Learning Materials</p>
            <h2 class="text-4xl font-bold text-green-600 mt-2">
                {{ $materials ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Assignments</p>
            <h2 class="text-4xl font-bold text-purple-600 mt-2">
                {{ $assignments ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Students</p>
            <h2 class="text-4xl font-bold text-orange-500 mt-2">
                {{ $participants ?? 0 }}
            </h2>
        </div>

    </div>

    <!-- ACTIVITY (DIKONSISTENKAN JADI CARD SYSTEM) -->
    <div class="grid md:grid-cols-3 gap-6">

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Active Classes</p>
            <h3 class="text-3xl font-bold text-green-600 mt-2">
                {{ $activeClasses ?? 0 }}
            </h3>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Pending Grading</p>
            <h3 class="text-3xl font-bold text-yellow-500 mt-2">
                {{ $pendingGrades ?? 0 }}
            </h3>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Attendance Sessions</p>
            <h3 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $attendanceSessions ?? 0 }}
            </h3>
        </div>

    </div>

    <!-- QUICK ACCESS (DIKONSISTENKAN DENGAN SAAS BUTTON CARD) -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-xl font-bold text-slate-800">
                Quick Access
            </h2>

            <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm">
                Instructor Tools
            </span>

        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <a href="#"
               class="bg-blue-600 text-white p-5 rounded-2xl hover:bg-blue-700 transition text-center font-semibold">

                🏫 My Classes

            </a>

            <a href="#"
               class="bg-blue-600 text-white p-5 rounded-2xl hover:bg-blue-700 transition text-center font-semibold">

                📖 Materials

            </a>

            <a href="#"
               class="bg-blue-600 text-white p-5 rounded-2xl hover:bg-blue-700 transition text-center font-semibold">

                📝 Assignments

            </a>

            <a href="#"
               class="bg-blue-600 text-white p-5 rounded-2xl hover:bg-blue-700 transition text-center font-semibold">

                📅 Attendance

            </a>

        </div>

    </div>

</div>

</x-app-layout>