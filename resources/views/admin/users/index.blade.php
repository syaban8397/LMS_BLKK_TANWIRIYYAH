<x-app-layout>

<div class="space-y-6">

    {{-- HERO --}}
    <div class="bg-gradient-to-r from-blue-800 via-indigo-800 to-slate-900 rounded-3xl p-8 text-white shadow-lg">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold">
                    User Management
                </h1>

                <p class="mt-2 text-blue-100">
                    Manage administrators, instructors, and training participants.
                </p>

            </div>

            <a href="{{ route('admin.users.create') }}"
               class="bg-white text-slate-900 px-5 py-3 rounded-2xl font-semibold hover:bg-slate-100 transition shadow">

                + Create User

            </a>

        </div>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="bg-green-50 border border-green-200 text-green-700 rounded-2xl p-4 shadow-sm">

            {{ session('success') }}

        </div>

    @endif

    {{-- STATISTICS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Total Users</p>
            <h2 class="text-4xl font-bold text-blue-700 mt-2">{{ $users->total() }}</h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Active Users</p>
            <h2 class="text-4xl font-bold text-green-600 mt-2">
                {{ \App\Models\User::where('is_active',1)->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Pending Approval</p>
            <h2 class="text-4xl font-bold text-yellow-500 mt-2">
                {{ \App\Models\User::where('approval_status','pending')->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm">Instructors</p>
            <h2 class="text-4xl font-bold text-indigo-700 mt-2">
                {{ \App\Models\User::where('role','instruktur')->count() }}
            </h2>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

        <h2 class="text-lg font-bold text-slate-800 mb-5">
            Search & Filter
        </h2>

        <form method="GET">

            <div class="grid md:grid-cols-4 gap-4">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search user..."
                    class="rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">

                <select
                    name="role"
                    class="rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">

                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="instruktur">Instructor</option>
                    <option value="peserta">Participant</option>

                </select>

                <button
                    class="bg-blue-700 hover:bg-blue-800 text-white rounded-2xl transition">

                    Search

                </button>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="bg-slate-200 hover:bg-slate-300 rounded-2xl flex items-center justify-center">

                    Reset

                </a>

            </div>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="p-6 border-b border-slate-200">

            <h2 class="text-lg font-bold text-slate-800">
                User List
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left">User</th>
                        <th class="px-6 py-4 text-center">Role</th>
                        <th class="px-6 py-4 text-center">Phone</th>
                        <th class="px-6 py-4 text-center">Approval</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Actions</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr class="border-t hover:bg-slate-50 transition">

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-4">

                                @if($user->photo)

                                    <img src="{{ asset('storage/'.$user->photo) }}"
                                         class="w-12 h-12 rounded-2xl object-cover">

                                @else

                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-700 text-white flex items-center justify-center font-bold">

                                        {{ strtoupper(substr($user->name,0,1)) }}

                                    </div>

                                @endif

                                <div>

                                    <div class="font-semibold text-slate-800">
                                        {{ $user->name }}
                                    </div>

                                    <div class="text-sm text-slate-500">
                                        {{ $user->email }}
                                    </div>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $user->phone ?: '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($user->approval_status == 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Approved</span>
                            @elseif($user->approval_status == 'rejected')
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Rejected</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Pending</span>
                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($user->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                    Active
                                </span>
                            @else
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-sm">
                                    Inactive
                                </span>
                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.users.show',$user) }}"
                                   class="px-3 py-2 bg-sky-600 text-white rounded-xl hover:bg-sky-700 transition">

                                    Detail

                                </a>

                                <a href="{{ route('admin.users.edit',$user) }}"
                                   class="px-3 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition">

                                    Edit

                                </a>

                                <form method="POST"
                                      action="{{ route('admin.users.destroy',$user) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this user?')"
                                            class="px-3 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-500">
                            No users found.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-6 border-t">
            {{ $users->links() }}
        </div>

    </div>

</div>

</x-app-layout>