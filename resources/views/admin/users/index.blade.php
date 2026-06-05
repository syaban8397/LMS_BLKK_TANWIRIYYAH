<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                User Management
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Manage administrators, instructors and participants
            </p>
        </div>

    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4">

            @if(session('success'))

                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>

            @endif

            <!-- FILTER -->

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">

                <form method="GET">

                    <div class="grid lg:grid-cols-4 gap-4">

                        <!-- SEARCH -->

                        <div>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search name, email, NIK..."
                                class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        </div>

                        <!-- ROLE FILTER -->

                        <div>

                            <select
                                name="role"
                                class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                                <option value="">
                                    All Roles
                                </option>

                                <option
                                    value="admin"
                                    @selected(request('role') == 'admin')>
                                    Admin
                                </option>

                                <option
                                    value="instruktur"
                                    @selected(request('role') == 'instruktur')>
                                    Instructor
                                </option>

                                <option
                                    value="peserta"
                                    @selected(request('role') == 'peserta')>
                                    Participant
                                </option>

                            </select>

                        </div>

                        <!-- ACTION -->

                        <div class="lg:col-span-2 flex flex-wrap gap-2">

                            <button
                                type="submit"
                                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition">

                                Search

                            </button>

                            <a
                                href="{{ route('admin.users.index') }}"
                                class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl transition">

                                Reset

                            </a>

                            <a
                                href="{{ route('admin.users.create') }}"
                                class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl transition">

                                + Create User

                            </a>

                        </div>

                    </div>

                </form>

            </div>

            <!-- TABLE -->

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>

                            <tr class="bg-gray-50 border-b">

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    User
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Role
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Phone
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Gender
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Approval
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Active
                                </th>

                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($users as $user)

                                <tr class="border-b hover:bg-gray-50">

                                    <!-- USER -->

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            @if($user->photo)

                                                <img
                                                    src="{{ asset('storage/'.$user->photo) }}"
                                                    class="w-12 h-12 rounded-xl object-cover">

                                            @else

                                                <img
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                                                    class="w-12 h-12 rounded-xl">

                                            @endif

                                            <div>

                                                <div class="font-semibold text-gray-800">
                                                    {{ $user->name }}
                                                </div>

                                                <div class="text-sm text-gray-500">
                                                    {{ $user->email }}
                                                </div>

                                                @if($user->nik)

                                                    <div class="text-xs text-gray-400">
                                                        NIK : {{ $user->nik }}
                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </td>

                                    <!-- ROLE -->

                                    <td class="px-6 py-4">

                                        @if($user->role == 'admin')

                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                                Admin
                                            </span>

                                        @elseif($user->role == 'instruktur')

                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                                                Instructor
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm">
                                                Participant
                                            </span>

                                        @endif

                                    </td>

                                    <!-- PHONE -->

                                    <td class="px-6 py-4">
                                        {{ $user->phone ?: '-' }}
                                    </td>

                                    <!-- GENDER -->

                                    <td class="px-6 py-4">

                                        @if($user->gender == 'L')
                                            Male
                                        @elseif($user->gender == 'P')
                                            Female
                                        @else
                                            -
                                        @endif

                                    </td>

                                    <!-- APPROVAL -->

                                    <td class="px-6 py-4">

                                        @if($user->approval_status == 'approved')

                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                                Approved
                                            </span>

                                        @elseif($user->approval_status == 'rejected')

                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                                Rejected
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                                                Pending
                                            </span>

                                        @endif

                                    </td>

                                    <!-- ACTIVE -->

                                    <td class="px-6 py-4">

                                        @if($user->is_active)

                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                                Active
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-sm">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>

                                    <!-- ACTION -->

                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            <a
                                                href="{{ route('admin.users.show', $user) }}"
                                                class="px-3 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-sm">

                                                View

                                            </a>

                                            <a
                                                href="{{ route('admin.users.edit', $user) }}"
                                                class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm">

                                                Edit

                                            </a>

                                            <form
                                                action="{{ route('admin.users.destroy', $user) }}"
                                                method="POST"
                                                onsubmit="return confirm('Delete this user?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">

                                                    Delete

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center py-12 text-gray-500">

                                        No users found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- PAGINATION -->

            <div class="mt-6">

                {{ $users->links() }}

            </div>

        </div>

    </div>

</x-app-layout>