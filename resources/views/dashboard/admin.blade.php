<x-app-layout>

<div class="space-y-6">


<!-- HERO -->
<div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 text-white shadow-lg">

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold">
                Welcome Back, {{ auth()->user()->name }}
            </h1>

            <p class="mt-2 text-blue-100">
                LMS BLKK Tanwiriyyah Administration Dashboard
            </p>

        </div>

        <div class="hidden lg:flex items-center justify-center w-24 h-24 rounded-3xl bg-white/10 text-5xl">
            🎓
        </div>

    </div>

</div>

<!-- STATISTICS -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-slate-500 text-sm">
                    Total Participants
                </p>

                <h2 class="text-4xl font-bold text-blue-700 mt-2">
                    {{ $participants ?? 0 }}
                </h2>
            </div>

            <div class="text-4xl">
                👨‍🎓
            </div>

        </div>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-slate-500 text-sm">
                    Total Instructors
                </p>

                <h2 class="text-4xl font-bold text-green-700 mt-2">
                    {{ $instructors ?? 0 }}
                </h2>
            </div>

            <div class="text-4xl">
                👨‍🏫
            </div>

        </div>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-slate-500 text-sm">
                    Active Classes
                </p>

                <h2 class="text-4xl font-bold text-purple-700 mt-2">
                    {{ $classes ?? 0 }}
                </h2>
            </div>

            <div class="text-4xl">
                🏫
            </div>

        </div>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-slate-500 text-sm">
                    Certificates Issued
                </p>

                <h2 class="text-4xl font-bold text-orange-600 mt-2">
                    {{ $certificates ?? 0 }}
                </h2>
            </div>

            <div class="text-4xl">
                📜
            </div>

        </div>

    </div>

</div>

<!-- MODULE SUMMARY -->
<div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <div class="text-3xl mb-3">📚</div>

        <h3 class="font-bold text-slate-800">
            Programs
        </h3>

        <div class="text-3xl font-bold text-blue-700 mt-2">
            {{ $programs ?? 0 }}
        </div>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <div class="text-3xl mb-3">📖</div>

        <h3 class="font-bold text-slate-800">
            Materials
        </h3>

        <div class="text-3xl font-bold text-indigo-700 mt-2">
            {{ $materials ?? 0 }}
        </div>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <div class="text-3xl mb-3">📝</div>

        <h3 class="font-bold text-slate-800">
            Assignments
        </h3>

        <div class="text-3xl font-bold text-green-700 mt-2">
            {{ $assignments ?? 0 }}
        </div>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <div class="text-3xl mb-3">📢</div>

        <h3 class="font-bold text-slate-800">
            Announcements
        </h3>

        <div class="text-3xl font-bold text-red-600 mt-2">
            {{ $announcements ?? 0 }}
        </div>

    </div>

</div>

<!-- QUICK ACCESS -->
<div class="bg-white rounded-3xl p-6 shadow-sm">

    <div class="flex items-center justify-between mb-6">

        <h2 class="text-xl font-bold text-slate-800">
            Quick Access
        </h2>

        <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm">
            Administrator Tools
        </span>

    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <a href="{{ route('admin.users.index') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white p-5 rounded-2xl transition">

            <div class="text-2xl mb-2">
                👥
            </div>

            <div class="font-semibold">
                User Management
            </div>

        </a>

        <a href="#"
            class="bg-green-600 hover:bg-green-700 text-white p-5 rounded-2xl transition">

            <div class="text-2xl mb-2">
                📚
            </div>

            <div class="font-semibold">
                Programs
            </div>

        </a>

        <a href="#"
            class="bg-purple-600 hover:bg-purple-700 text-white p-5 rounded-2xl transition">

            <div class="text-2xl mb-2">
                🏫
            </div>

            <div class="font-semibold">
                Classes
            </div>

        </a>

        <a href="#"
            class="bg-orange-600 hover:bg-orange-700 text-white p-5 rounded-2xl transition">

            <div class="text-2xl mb-2">
                📈
            </div>

            <div class="font-semibold">
                Reports
            </div>

        </a>

    </div>

</div>

<!-- SYSTEM OVERVIEW -->
<div class="grid lg:grid-cols-2 gap-6">

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <h3 class="font-bold text-lg mb-5">
            Learning Activity
        </h3>

        <div class="space-y-4">

            <div class="flex justify-between">
                <span>Total Attendance Sessions</span>
                <span class="font-bold">{{ $attendanceSessions ?? 0 }}</span>
            </div>

            <div class="flex justify-between">
                <span>Total Attendance Records</span>
                <span class="font-bold">{{ $attendances ?? 0 }}</span>
            </div>

            <div class="flex justify-between">
                <span>Total Grades</span>
                <span class="font-bold">{{ $grades ?? 0 }}</span>
            </div>

        </div>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <h3 class="font-bold text-lg mb-5">
            Portfolio & Achievement
        </h3>

        <div class="space-y-4">

            <div class="flex justify-between">
                <span>Portfolios</span>
                <span class="font-bold">{{ $portfolios ?? 0 }}</span>
            </div>

            <div class="flex justify-between">
                <span>Certificates</span>
                <span class="font-bold">{{ $certificates ?? 0 }}</span>
            </div>

            <div class="flex justify-between">
                <span>Notifications</span>
                <span class="font-bold">{{ $notifications ?? 0 }}</span>
            </div>

        </div>

    </div>

</div>


</div>

</x-app-layout>
