<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Welcome Card -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h1 class="text-2xl font-bold">
                    Welcome, {{ auth()->user()->name }}
                </h1>

                <p class="text-gray-500 mt-2">
                    Administrator Panel
                </p>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500">Participants</h3>
                    <p class="text-3xl font-bold mt-2">
                        {{ $participants ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500">Instructors</h3>
                    <p class="text-3xl font-bold mt-2">
                        {{ $instructors ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500">Classes</h3>
                    <p class="text-3xl font-bold mt-2">
                        {{ $classes ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500">Certificates</h3>
                    <p class="text-3xl font-bold mt-2">
                        {{ $certificates ?? 0 }}
                    </p>
                </div>

            </div>

            <!-- Approval Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-xl">
                    <h3 class="text-yellow-700 font-semibold">
                        Pending Approval
                    </h3>

                    <p class="text-4xl font-bold mt-2 text-yellow-600">
                        {{ $pendingParticipants ?? 0 }}
                    </p>
                </div>

                <div class="bg-green-50 border border-green-200 p-6 rounded-xl">
                    <h3 class="text-green-700 font-semibold">
                        Approved Participants
                    </h3>

                    <p class="text-4xl font-bold mt-2 text-green-600">
                        {{ $approvedParticipants ?? 0 }}
                    </p>
                </div>

                <div class="bg-red-50 border border-red-200 p-6 rounded-xl">
                    <h3 class="text-red-700 font-semibold">
                        Rejected Participants
                    </h3>

                    <p class="text-4xl font-bold mt-2 text-red-600">
                        {{ $rejectedParticipants ?? 0 }}
                    </p>
                </div>

            </div>

            <!-- Quick Menu -->
            <div class="bg-white rounded-xl shadow p-6 mt-6">

                <h3 class="text-lg font-semibold mb-4">
                    Quick Access
                </h3>

                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('admin.users.index') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        User Management
                    </a>

                    <a href="#"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Programs
                    </a>

                    <a href="#"
                       class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Classes
                    </a>

                    <a href="#"
                       class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        Reports
                    </a>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>