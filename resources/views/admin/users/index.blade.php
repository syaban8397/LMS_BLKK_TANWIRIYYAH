<x-app-layout>
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">User Management</h1>
                <p class="text-sm text-slate-500 mt-0.5">Manage administrators, instructors, and participants</p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                + Create User
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                <div class="flex justify-between items-start">
                    <div><p class="text-xs text-slate-400 uppercase">Total Users</p><p class="text-2xl font-bold text-blue-600 mt-1">{{ $users->total() }}</p></div>
                    <div class="text-xl">👥</div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                <div class="flex justify-between items-start">
                    <div><p class="text-xs text-slate-400 uppercase">Active</p><p class="text-2xl font-bold text-green-600 mt-1">{{ \App\Models\User::where('is_active',1)->count() }}</p></div>
                    <div class="text-xl">✅</div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                <div class="flex justify-between items-start">
                    <div><p class="text-xs text-slate-400 uppercase">Pending</p><p class="text-2xl font-bold text-yellow-500 mt-1">{{ \App\Models\User::where('approval_status','pending')->count() }}</p></div>
                    <div class="text-xl">⏳</div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                <div class="flex justify-between items-start">
                    <div><p class="text-xs text-slate-400 uppercase">Instructors</p><p class="text-2xl font-bold text-indigo-600 mt-1">{{ \App\Models\User::where('role','instruktur')->count() }}</p></div>
                    <div class="text-xl">👨‍🏫</div>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-md">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email" 
                           class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-400 focus:ring-blue-400">
                </div>
                <div class="w-40">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Role</label>
                    <select name="role" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-400 focus:ring-blue-400">
                        <option value="">All</option>
                        <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                        <option value="instruktur" {{ request('role')=='instruktur' ? 'selected' : '' }}>Instructor</option>
                        <option value="peserta" {{ request('role')=='peserta' ? 'selected' : '' }}>Participant</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Search</button>
                    <a href="{{ route('admin.users.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm hover:shadow">Reset</a>
                </div>
            </form>
        </div>

        {{-- User Table - Rapi dengan lebar tetap --}}
        <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm table-auto">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left w-[30%]">User</th>
                            <th class="px-4 py-3 text-center w-[12%]">Role</th>
                            <th class="px-4 py-3 text-center w-[15%]">Phone</th>
                            <th class="px-4 py-3 text-center w-[12%]">Approval</th>
                            <th class="px-4 py-3 text-center w-[10%]">Status</th>
                            <th class="px-4 py-3 text-center w-[21%]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/'.$user->photo) }}" class="w-8 h-8 rounded-lg object-cover border shadow-sm">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-slate-500 to-slate-600 text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                                {{ strtoupper(substr($user->name,0,1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-medium text-slate-800 truncate max-w-[180px]">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-400 truncate max-w-[180px]">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium whitespace-nowrap
                                        {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'instruktur' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600 truncate max-w-[120px]">{{ $user->phone ?: '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($user->approval_status == 'approved')
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium whitespace-nowrap">Approved</span>
                                    @elseif($user->approval_status == 'rejected')
                                        <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium whitespace-nowrap">Rejected</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium whitespace-nowrap">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($user->is_active)
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium whitespace-nowrap">Active</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full text-xs font-medium whitespace-nowrap">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1.5 flex-wrap">
                                        <a href="{{ route('admin.users.show', $user) }}" class="px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm hover:shadow">View</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-xs transition shadow-sm hover:shadow">Edit</a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs transition shadow-sm hover:shadow">Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-slate-100 text-xs">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>