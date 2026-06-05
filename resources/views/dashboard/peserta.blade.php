<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl">
            Participant Dashboard
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4">

            <div class="bg-white rounded-xl shadow p-6 mb-6">

                <h1 class="text-2xl font-bold">
                    Welcome, {{ auth()->user()->name }}
                </h1>

                <p class="text-gray-500 mt-2">
                    Participant Panel
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-gray-500">My Classes</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-gray-500">Assignments</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-gray-500">Certificates</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-gray-500">Portfolio</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>

            </div>

        </div>

    </div>

</x-app-layout>