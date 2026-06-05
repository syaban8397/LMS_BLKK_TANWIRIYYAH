<x-app-layout>

<div class="space-y-6">

    <!-- HERO -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-2xl p-6 text-white shadow-lg">

        <h1 class="text-3xl font-bold">
            Welcome Back, {{ auth()->user()->name }}
        </h1>

        <p class="mt-2 text-blue-100">
            LMS BLKK Tanwiriyyah Administration Dashboard
        </p>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-gray-500">Participants</p>
            <h2 class="text-4xl font-bold mt-2 text-blue-700">
                {{ $participants ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-gray-500">Instructors</p>
            <h2 class="text-4xl font-bold mt-2 text-green-700">
                {{ $instructors ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-gray-500">Classes</p>
            <h2 class="text-4xl font-bold mt-2 text-purple-700">
                {{ $classes ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-gray-500">Certificates</p>
            <h2 class="text-4xl font-bold mt-2 text-orange-700">
                {{ $certificates ?? 0 }}
            </h2>
        </div>

    </div>

    <!-- APPROVAL -->
    <div class="grid md:grid-cols-3 gap-5">

        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5">
            <h3 class="text-yellow-700 font-semibold">
                Pending Approval
            </h3>

            <div class="text-4xl font-bold mt-2 text-yellow-600">
                {{ $pendingParticipants ?? 0 }}
            </div>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
            <h3 class="text-green-700 font-semibold">
                Approved
            </h3>

            <div class="text-4xl font-bold mt-2 text-green-600">
                {{ $approvedParticipants ?? 0 }}
            </div>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
            <h3 class="text-red-700 font-semibold">
                Rejected
            </h3>

            <div class="text-4xl font-bold mt-2 text-red-600">
                {{ $rejectedParticipants ?? 0 }}
            </div>
        </div>

    </div>

    <!-- QUICK ACCESS -->
    <div class="bg-white rounded-2xl p-6 shadow">

        <div class="flex justify-between items-center mb-5">

            <h2 class="text-xl font-bold">
                Quick Access
            </h2>

            <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm">
                Administrator Tools
            </span>

        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <a href="{{ route('admin.users.index') }}"
               class="bg-blue-600 text-white rounded-xl p-4 hover:bg-blue-700">

                👥 User Management

            </a>

            <a href="#"
               class="bg-green-600 text-white rounded-xl p-4 hover:bg-green-700">

                🎓 Programs

            </a>

            <a href="#"
               class="bg-purple-600 text-white rounded-xl p-4 hover:bg-purple-700">

                🏫 Classes

            </a>

            <a href="#"
               class="bg-orange-600 text-white rounded-xl p-4 hover:bg-orange-700">

                📈 Reports

            </a>

        </div>

    </div>

</div>

</x-app-layout>