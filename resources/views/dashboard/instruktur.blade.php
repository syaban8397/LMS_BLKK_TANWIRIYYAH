<x-app-layout>

<div class="space-y-6">

    <!-- HERO -->
    <div class="bg-gradient-to-r from-emerald-600 via-green-600 to-teal-700 rounded-3xl p-8 text-white shadow-xl">

        <h1 class="text-3xl font-bold">
            Welcome Back, {{ auth()->user()->name }}
        </h1>

        <p class="mt-2 text-green-100">
            Instructor Dashboard - LMS BLKK Tanwiriyyah
        </p>

    </div>

    <!-- STATISTICS -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-3xl p-6 shadow-sm border">
            <p class="text-gray-500">
                My Classes
            </p>

            <h2 class="text-4xl font-bold text-emerald-600 mt-2">
                {{ $classes ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border">
            <p class="text-gray-500">
                Learning Materials
            </p>

            <h2 class="text-4xl font-bold text-blue-600 mt-2">
                {{ $materials ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border">
            <p class="text-gray-500">
                Assignments
            </p>

            <h2 class="text-4xl font-bold text-purple-600 mt-2">
                {{ $assignments ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border">
            <p class="text-gray-500">
                Students
            </p>

            <h2 class="text-4xl font-bold text-orange-600 mt-2">
                {{ $participants ?? 0 }}
            </h2>
        </div>

    </div>

    <!-- ACTIVITY -->
    <div class="grid md:grid-cols-3 gap-5">

        <div class="bg-green-50 border border-green-200 rounded-3xl p-5">

            <h3 class="font-semibold text-green-700">
                Active Classes
            </h3>

            <div class="text-4xl font-bold text-green-600 mt-2">
                {{ $activeClasses ?? 0 }}
            </div>

        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-5">

            <h3 class="font-semibold text-yellow-700">
                Pending Grading
            </h3>

            <div class="text-4xl font-bold text-yellow-600 mt-2">
                {{ $pendingGrades ?? 0 }}
            </div>

        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-3xl p-5">

            <h3 class="font-semibold text-blue-700">
                Attendance Sessions
            </h3>

            <div class="text-4xl font-bold text-blue-600 mt-2">
                {{ $attendanceSessions ?? 0 }}
            </div>

        </div>

    </div>

    <!-- QUICK ACCESS -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-xl font-bold text-gray-800">
                Quick Access
            </h2>

            <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm">
                Instructor Tools
            </span>

        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <a href="#"
                class="bg-green-600 text-white p-5 rounded-2xl hover:bg-green-700 transition">

                🏫 My Classes

            </a>

            <a href="#"
                class="bg-blue-600 text-white p-5 rounded-2xl hover:bg-blue-700 transition">

                📖 Materials

            </a>

            <a href="#"
                class="bg-purple-600 text-white p-5 rounded-2xl hover:bg-purple-700 transition">

                📝 Assignments

            </a>

            <a href="#"
                class="bg-orange-600 text-white p-5 rounded-2xl hover:bg-orange-700 transition">

                📅 Attendance

            </a>

        </div>

    </div>

</div>

</x-app-layout>