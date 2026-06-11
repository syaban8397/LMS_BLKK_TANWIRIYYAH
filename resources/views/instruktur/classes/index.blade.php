<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
                <p class="text-sm text-slate-500 mt-0.5">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-200">
                    <span class="text-xs text-slate-500">Role</span>
                    <p class="font-semibold text-slate-700">Instruktur</p>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="dashboard-card bg-white rounded-xl p-6 shadow-md border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-500 text-sm font-semibold uppercase tracking-wide">Total Classes</p>
                        <h3 class="text-5xl font-black text-slate-800 mt-2">{{ $totalClasses }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
            </div>

            <div class="dashboard-card bg-white rounded-xl p-6 shadow-md border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-500 text-sm font-semibold uppercase tracking-wide">Active Classes</p>
                        <h3 class="text-5xl font-black text-slate-800 mt-2">{{ $activeClasses }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="dashboard-card bg-white rounded-xl p-6 shadow-md border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-500 text-sm font-semibold uppercase tracking-wide">Total Students</p>
                        <h3 class="text-5xl font-black text-slate-800 mt-2">{{ $totalStudents }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Classes Table --}}
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white flex justify-between items-center flex-wrap gap-3">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Class List
                </h3>
                <div class="text-xs text-slate-500">Showing {{ $classes->firstItem() ?? 0 }} - {{ $classes->lastItem() ?? 0 }} of {{ $classes->total() }}</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Class</th>
                            <th class="px-6 py-4 text-left font-semibold">Program</th>
                            <th class="px-6 py-4 text-center font-semibold">Period</th>
                            <th class="px-6 py-4 text-center font-semibold">Students</th>
                            <th class="px-6 py-4 text-center font-semibold">Status</th>
                            <th class="px-6 py-4 text-center font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($classes as $classItem)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-slate-800">{{ $classItem->title }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $classItem->code }}</div>
                                </td>
                                <td class="px-6 py-5 text-slate-600">{{ $classItem->program->name }}</td>
                                <td class="px-6 py-5 text-center text-slate-600 text-sm">
                                    {{ \Carbon\Carbon::parse($classItem->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($classItem->end_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="font-bold text-slate-800">{{ $classItem->participants->count() }}</span>
                                        <span class="text-slate-400">/</span>
                                        <span class="text-slate-500">{{ $classItem->quota }}</span>
                                        <div class="w-12 h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full rounded-full" style="width: {{ ($classItem->participants->count() / max($classItem->quota,1)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusBadge = [
                                            'draft'     => 'bg-slate-100 text-slate-700',
                                            'active'    => 'bg-emerald-100 text-emerald-700',
                                            'completed' => 'bg-blue-100 text-blue-700',
                                            'cancelled' => 'bg-red-100 text-red-700'
                                        ];
                                        $statusLabel = [
                                            'draft'     => 'Draft',
                                            'active'    => 'Active',
                                            'completed' => 'Completed',
                                            'cancelled' => 'Cancelled'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusBadge[$classItem->status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $statusLabel[$classItem->status] ?? ucfirst($classItem->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('instruktur.classes.stream', $classItem) }}" class="btn-3d inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white rounded-lg text-xs font-medium transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 21v-4H7v4"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6"></path></svg>
                                        <p class="text-slate-500">No classes assigned yet.</p>
                                        <p class="text-xs text-slate-400">You haven't been assigned to any classes.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($classes->hasPages())
                <div class="px-6 py-3 border-t border-slate-100 bg-slate-50">
                    {{ $classes->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
        .btn-3d {
            transition: all 0.2s ease;
        }
        .btn-3d:active {
            transform: translateY(1px);
        }
    </style>
</x-app-layout>