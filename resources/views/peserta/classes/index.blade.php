<x-app-layout>
    <div class="peserta-index-wrapper lms-page-shell">
        <x-lms-page-header title="My Classes" subtitle="View your enrolled classes" />

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="stat-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Total Classes</p>
                <h3 class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $totalClasses }}</h3>
                <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">All enrolled classes</div>
            </div>
            <div class="stat-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Active Classes</p>
                <h3 class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $activeClasses }}</h3>
                <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">Currently ongoing</div>
            </div>
            <div class="stat-card p-5">
                <p class="text-xs text-slate-400 uppercase tracking-wide">Completed Classes</p>
                <h3 class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $completedClasses }}</h3>
                <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">Finished classes</div>
            </div>
        </div>

        <x-lms-card class="table-card p-0" title="Class List" :meta="'Total: ' . $enrolledClasses->total()">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 text-left">Class</th>
                            <th class="px-5 py-3 text-left">Program</th>
                            <th class="px-5 py-3 text-left">Instructor</th>
                            <th class="px-5 py-3 text-center">Period</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/55">
                        @forelse($enrolledClasses as $enrollment)
                            <tr class="class-row transition">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $enrollment->class->title }}</div>
                                    <div class="text-xs text-slate-400">{{ $enrollment->class->code }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $enrollment->class->program->name }}</td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $enrollment->class->instructor->name }}</td>
                                <td class="px-5 py-4 text-center text-slate-600 dark:text-slate-300">
                                    {{ $enrollment->class->start_date->format('d M Y') }} - {{ $enrollment->class->end_date->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @switch($enrollment->status)
                                        @case('active') <span class="lms-badge lms-badge--success">Active</span> @break
                                        @case('completed') <span class="lms-badge lms-badge--info">Completed</span> @break
                                        @case('dropped') <span class="lms-badge lms-badge--danger">Dropped</span> @break
                                        @default <span class="lms-badge">{{ ucfirst($enrollment->status) }}</span>
                                    @endswitch
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('peserta.classes.stream', $enrollment->class) }}" class="action-btn px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs font-medium">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-slate-500 dark:text-slate-400">
                                    You are not enrolled in any classes yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($enrolledClasses->hasPages())
                <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700/55 bg-slate-50 dark:bg-slate-800/40">
                    {{ $enrolledClasses->links() }}
                </div>
            @endif
        </x-lms-card>
    </div>
</x-app-layout>
