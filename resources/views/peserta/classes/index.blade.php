<x-app-layout>
    <!-- Header sederhana tanpa background -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">My Classes</h1>
            <p class="text-sm text-slate-500 mt-0.5">View your enrolled classes</p>
        </div>
        <!-- (tidak ada tombol khusus, bisa ditambahkan nanti) -->
    </div>

    <div class="space-y-6">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg p-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Cards (3D) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Total Classes</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $totalClasses }}</h3>
                <div class="mt-2 text-xs text-slate-500">All enrolled classes</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Active Classes</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $activeClasses }}</h3>
                <div class="mt-2 text-xs text-slate-500">Currently ongoing</div>
            </div>
            <div class="stat-card bg-white rounded-xl p-5 shadow-md border border-slate-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Completed Classes</p>
                <h3 class="text-3xl font-bold text-purple-600 mt-1">{{ $completedClasses }}</h3>
                <div class="mt-2 text-xs text-slate-500">Finished classes</div>
            </div>
        </div>

        <!-- Classes Table Card -->
        <div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Class List
                </h3>
                <span class="text-xs text-slate-400">Total: {{ $enrolledClasses->total() }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-600 text-sm border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3 text-left">Class</th>
                            <th class="px-5 py-3 text-left">Program</th>
                            <th class="px-5 py-3 text-left">Instructor</th>
                            <th class="px-5 py-3 text-center">Period</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($enrolledClasses as $enrollment)
                            <tr class="hover:bg-slate-50 transition group">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-800">{{ $enrollment->class->title }}</div>
                                    <div class="text-xs text-slate-400">{{ $enrollment->class->code }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-600 text-sm">{{ $enrollment->class->program->name }}</td>
                                <td class="px-5 py-4 text-slate-600 text-sm">{{ $enrollment->class->instructor->name }}</td>
                                <td class="px-5 py-4 text-center text-slate-600 text-sm">
                                    {{ $enrollment->class->start_date->format('d M Y') }} - {{ $enrollment->class->end_date->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @switch($enrollment->status)
                                        @case('active')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                                            @break
                                        @case('completed')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Completed</span>
                                            @break
                                        @case('dropped')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Dropped</span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">{{ ucfirst($enrollment->status) }}</span>
                                    @endswitch
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('peserta.classes.stream', $enrollment->class) }}" 
                                       class="btn-3d inline-flex items-center gap-1 px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs font-medium transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center text-slate-400">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 21v-4H7v4"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6"></path></svg>
                                        <p class="text-sm">You are not enrolled in any classes yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($enrolledClasses->hasPages())
                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">
                    {{ $enrolledClasses->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .stat-card {
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -8px rgba(0, 0, 0, 0.1);
        }
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