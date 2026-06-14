<x-app-layout>
    <div class="dashboard-wrapper lms-page-shell space-y-6">
        <x-lms-page-header title="Dashboard" :subtitle="'Welcome back, ' . auth()->user()->name">
            <x-slot:actions>
                <div class="stat-card px-4 py-2 !shadow-sm">
                    <span class="text-xs text-slate-500 dark:text-slate-400">Role</span>
                    <p class="font-semibold text-slate-700 dark:text-slate-200">Instruktur</p>
                </div>
            </x-slot:actions>
        </x-lms-page-header>

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif
        @if(session('error'))
            <x-lms-flash type="error">{{ session('error') }}</x-lms-flash>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="stat-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-500 dark:text-indigo-400 text-sm font-semibold uppercase tracking-wide">Total Classes</p>
                        <h3 class="text-5xl font-black text-slate-800 dark:text-slate-100 mt-2 counter" data-value="{{ $totalClasses }}">0</h3>
                    </div>
                    <div class="lms-kpi-icon bg-gradient-to-br from-blue-500 to-indigo-600 text-white w-14 h-14 text-2xl">📚</div>
                </div>
            </div>
            <div class="stat-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-500 dark:text-emerald-400 text-sm font-semibold uppercase tracking-wide">Active Classes</p>
                        <h3 class="text-5xl font-black text-slate-800 dark:text-slate-100 mt-2 counter" data-value="{{ $activeClasses }}">0</h3>
                    </div>
                    <div class="lms-kpi-icon bg-gradient-to-br from-emerald-500 to-teal-600 text-white w-14 h-14 text-2xl">✅</div>
                </div>
            </div>
            <div class="stat-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-500 dark:text-purple-400 text-sm font-semibold uppercase tracking-wide">Total Students</p>
                        <h3 class="text-5xl font-black text-slate-800 dark:text-slate-100 mt-2 counter" data-value="{{ $totalStudents }}">0</h3>
                    </div>
                    <div class="lms-kpi-icon bg-gradient-to-br from-purple-500 to-pink-600 text-white w-14 h-14 text-2xl">👥</div>
                </div>
            </div>
        </div>

        <x-lms-card class="table-card p-0" title="Class List" :meta="'Showing ' . ($classes->firstItem() ?? 0) . ' - ' . ($classes->lastItem() ?? 0) . ' of ' . $classes->total()">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-left">Class</th>
                            <th class="px-6 py-4 text-left">Program</th>
                            <th class="px-6 py-4 text-center">Period</th>
                            <th class="px-6 py-4 text-center">Students</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/55">
                        @forelse($classes as $classItem)
                            <tr class="class-row transition">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-slate-800 dark:text-slate-100">{{ $classItem->title }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $classItem->code }}</div>
                                </td>
                                <td class="px-6 py-5 text-slate-600 dark:text-slate-300">{{ $classItem->program->name }}</td>
                                <td class="px-6 py-5 text-center text-slate-600 dark:text-slate-300">
                                    {{ \Carbon\Carbon::parse($classItem->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($classItem->end_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="font-bold text-slate-800 dark:text-slate-100">{{ $classItem->participants->count() }}</span>
                                        <span class="text-slate-400">/</span>
                                        <span class="text-slate-500 dark:text-slate-400">{{ $classItem->quota }}</span>
                                        <div class="w-12 h-1.5 bg-slate-200 dark:bg-slate-600 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full rounded-full" style="width: {{ ($classItem->participants->count() / max($classItem->quota,1)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @switch($classItem->status)
                                        @case('draft') <span class="lms-badge">Draft</span> @break
                                        @case('active') <span class="lms-badge lms-badge--success">Active</span> @break
                                        @case('completed') <span class="lms-badge lms-badge--info">Completed</span> @break
                                        @case('cancelled') <span class="lms-badge lms-badge--danger">Cancelled</span> @break
                                        @default <span class="lms-badge">{{ ucfirst($classItem->status) }}</span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('instruktur.classes.stream', $classItem) }}" class="lms-btn-primary btn-3d px-4 py-2 text-xs">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-slate-500 dark:text-slate-400">
                                    No classes assigned yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($classes->hasPages())
                <div class="px-6 py-3 border-t border-slate-100 dark:border-slate-700/55 bg-slate-50 dark:bg-slate-800/40">
                    {{ $classes->links() }}
                </div>
            @endif
        </x-lms-card>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.counter').forEach(el => {
                let start = 0;
                const end = parseInt(el.dataset.value) || 0;
                const step = Math.ceil(end / 40) || 1;
                const interval = setInterval(() => {
                    start += step;
                    if (start >= end) {
                        start = end;
                        clearInterval(interval);
                    }
                    el.innerText = start;
                }, 20);
            });
        });
    </script>
</x-app-layout>
