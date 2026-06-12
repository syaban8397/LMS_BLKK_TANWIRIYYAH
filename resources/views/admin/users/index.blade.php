<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% {
                opacity: 0;
                transform: translateY(30px) rotateX(10deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotateX(0);
            }
        }

        /* Animasi untuk setiap kartu (staggered) */
        @keyframes cardPop3D {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(20px) rotateX(5deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0) rotateX(0);
            }
        }

        /* Animasi untuk baris tabel */
        @keyframes rowFadeIn {
            0% {
                opacity: 0;
                transform: translateX(-10px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Wrapper utama */
        .user-management-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Stat card 3D */
        .stat-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform-style: preserve-3d;
        }

        .stat-card:hover {
            transform: translateY(-6px) rotateX(2deg) rotateY(2deg) scale(1.02);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.2);
        }

        /* Stagger delay untuk 4 kartu */
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.2s; }

        /* Form filter dan tombol 3D */
        .filter-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.25s;
        }

        /* Tabel dengan efek baris */
        .user-table {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.3s;
        }

        .user-table tbody tr {
            animation: rowFadeIn 0.3s ease forwards;
            opacity: 0;
        }

        /* Stagger untuk baris tabel */
        .user-table tbody tr:nth-child(1) { animation-delay: 0.35s; }
        .user-table tbody tr:nth-child(2) { animation-delay: 0.4s; }
        .user-table tbody tr:nth-child(3) { animation-delay: 0.45s; }
        .user-table tbody tr:nth-child(4) { animation-delay: 0.5s; }
        .user-table tbody tr:nth-child(5) { animation-delay: 0.55s; }
        .user-table tbody tr:nth-child(6) { animation-delay: 0.6s; }
        .user-table tbody tr:nth-child(7) { animation-delay: 0.65s; }
        .user-table tbody tr:nth-child(8) { animation-delay: 0.7s; }
        .user-table tbody tr:nth-child(9) { animation-delay: 0.75s; }
        .user-table tbody tr:nth-child(10) { animation-delay: 0.8s; }

        /* Tombol 3D */
        .btn-3d {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            transform: translateY(0);
        }
        .btn-3d:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.15);
        }
        .btn-3d:active {
            transform: translateY(1px);
        }

        /* Link aksi 3D */
        .action-btn {
            transition: all 0.2s ease;
            display: inline-block;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
        }
    </style>

    <div class="user-management-wrapper space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">User Management</h1>
                <p class="text-sm text-slate-500 mt-0.5">Manage administrators, instructors, and participants</p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 btn-3d">
                + Create User
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm shadow-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card bg-white rounded-xl p-4 border border-slate-200 shadow-md">
                <div class="flex justify-between items-start">
                    <div><p class="text-xs text-slate-400 uppercase">Total Users</p><p class="text-2xl font-bold text-blue-600 mt-1">{{ $users->total() }}</p></div>
                    <div class="text-xl">👥</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 border border-slate-200 shadow-md">
                <div class="flex justify-between items-start">
                    <div><p class="text-xs text-slate-400 uppercase">Active</p><p class="text-2xl font-bold text-green-600 mt-1">{{ \App\Models\User::where('is_active',1)->count() }}</p></div>
                    <div class="text-xl">✅</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 border border-slate-200 shadow-md">
                <div class="flex justify-between items-start">
                    <div><p class="text-xs text-slate-400 uppercase">Pending</p><p class="text-2xl font-bold text-yellow-500 mt-1">{{ \App\Models\User::where('approval_status','pending')->count() }}</p></div>
                    <div class="text-xl">⏳</div>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 border border-slate-200 shadow-md">
                <div class="flex justify-between items-start">
                    <div><p class="text-xs text-slate-400 uppercase">Instructors</p><p class="text-2xl font-bold text-indigo-600 mt-1">{{ \App\Models\User::where('role','instruktur')->count() }}</p></div>
                    <div class="text-xl">👨‍🏫</div>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="filter-card bg-white rounded-xl p-4 border border-slate-200 shadow-md">
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
                    <button type="submit" class="btn-3d bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-md hover:shadow-lg">Search</button>
                    <a href="{{ route('admin.users.index') }}" class="btn-3d bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm hover:shadow">Reset</a>
                </div>
            </form>
        </div>

        {{-- User Table --}}
        <div class="user-table bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
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
                                        <a href="{{ route('admin.users.show', $user) }}" class="action-btn px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm hover:shadow">View</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="action-btn px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-xs transition shadow-sm hover:shadow">Edit</a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs transition shadow-sm hover:shadow">Del</button>
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