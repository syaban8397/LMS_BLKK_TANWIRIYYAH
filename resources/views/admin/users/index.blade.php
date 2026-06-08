<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-2xl font-bold text-slate-800">
                User Management
            </h2>

            <p class="text-slate-500 mt-1">
                Manage administrators, instructors and participants
            </p>

        </div>

    </x-slot>

    <div class="space-y-6">

        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div
                class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">

                {{ session('success') }}

            </div>

        @endif

        {{-- HEADER CARD --}}

        <div
            class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 text-white shadow-xl">

            <div class="flex justify-between items-center">

                <div>

                    <h1 class="text-3xl font-bold">
                        User Management
                    </h1>

                    <p class="mt-2 text-blue-100">
                        Manage user accounts, roles, approvals and permissions.
                    </p>

                </div>

                <a
                    href="{{ route('admin.users.create') }}"
                    class="bg-white text-blue-700 px-5 py-3 rounded-xl font-semibold hover:bg-blue-50">

                    + Create User

                </a>

            </div>

        </div>

        {{-- STATISTICS --}}

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-gray-500">
                    Total Users
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $users->total() }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-gray-500">
                    Active Users
                </p>

                <h2 class="text-3xl font-bold text-green-600 mt-2">
                    {{ \App\Models\User::where('is_active',true)->count() }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-gray-500">
                    Pending Approval
                </p>

                <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                    {{ \App\Models\User::where('approval_status','pending')->count() }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-gray-500">
                    Instructors
                </p>

                <h2 class="text-3xl font-bold text-blue-600 mt-2">
                    {{ \App\Models\User::where('role','instruktur')->count() }}
                </h2>

            </div>

        </div>

        {{-- FILTER CARD --}}

        <div class="bg-white rounded-2xl shadow p-6">

            <form method="GET">

                <div class="grid md:grid-cols-4 gap-4">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search user..."
                        class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                    <select
                        name="role"
                        class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            All Roles
                        </option>

                        <option value="admin">
                            Admin
                        </option>

                        <option value="instruktur">
                            Instructor
                        </option>

                        <option value="peserta">
                            Participant
                        </option>

                    </select>

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl">

                        Search

                    </button>

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 rounded-xl flex items-center justify-center">

                        Reset

                    </a>

                </div>

            </form>

        </div>

        {{-- USER TABLE --}}

        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="bg-slate-50">

                            <th class="p-4 text-left">
                                User
                            </th>

                            <th class="p-4 text-left">
                                Role
                            </th>

                            <th class="p-4 text-left">
                                Phone
                            </th>

                            <th class="p-4 text-left">
                                Approval
                            </th>

                            <th class="p-4 text-left">
                                Status
                            </th>

                            <th class="p-4 text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr
                                class="border-t hover:bg-slate-50">

                                <td class="p-4">

                                    <div class="flex items-center gap-3">

                                        @if($user->photo)

                                            <img
                                                src="{{ $user->photo }}"
                                                class="w-12 h-12 rounded-xl object-cover">

                                        @else

                                            <div
                                                class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex items-center justify-center font-bold">

                                                {{ strtoupper(substr($user->name,0,1)) }}

                                            </div>

                                        @endif

                                        <div>

                                            <div class="font-semibold">

                                                {{ $user->name }}

                                            </div>

                                            <div class="text-sm text-gray-500">

                                                {{ $user->email }}

                                            </div>

                                            <div class="text-xs text-gray-400">

                                                {{ $user->nik }}

                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td class="p-4">

                                    <span
                                        class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">

                                        {{ ucfirst($user->role) }}

                                    </span>

                                </td>

                                <td class="p-4">

                                    {{ $user->phone ?: '-' }}

                                </td>

                                <td class="p-4">

                                    @if($user->approval_status=='approved')

                                        <span
                                            class="px-3 py-1 rounded-full bg-green-100 text-green-700">

                                            Approved

                                        </span>

                                    @elseif($user->approval_status=='rejected')

                                        <span
                                            class="px-3 py-1 rounded-full bg-red-100 text-red-700">

                                            Rejected

                                        </span>

                                    @else

                                        <span
                                            class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">

                                            Pending

                                        </span>

                                    @endif

                                </td>

                                <td class="p-4">

                                    @if($user->is_active)

                                        <span
                                            class="px-3 py-1 rounded-full bg-green-100 text-green-700">

                                            Active

                                        </span>

                                    @else

                                        <span
                                            class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">

                                            Inactive

                                        </span>

                                    @endif

                                </td>

                                <td class="p-4">

                                    <div
                                        class="flex justify-center gap-2">

                                        <a
                                            href="{{ route('admin.users.show',$user) }}"
                                            class="px-3 py-2 bg-sky-500 text-white rounded-lg">

                                            View

                                        </a>

                                        <a
                                            href="{{ route('admin.users.edit',$user) }}"
                                            class="px-3 py-2 bg-yellow-500 text-white rounded-lg">

                                            Edit

                                        </a>

                                        <form
                                            action="{{ route('admin.users.destroy',$user) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="px-3 py-2 bg-red-600 text-white rounded-lg">

                                                Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-12 text-gray-500">

                                    No users found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINATION --}}

        <div>

            {{ $users->links() }}

        </div>

    </div>

</x-app-layout>