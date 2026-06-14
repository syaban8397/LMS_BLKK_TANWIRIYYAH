<x-app-layout>
    <div class="programs-wrapper lms-page-shell space-y-5">
        <x-lms-page-header title="Training Programs" subtitle="Manage all training programs available in the LMS.">
            <x-slot:actions>
                <a href="{{ route('admin.programs.create') }}" class="lms-btn-primary btn-create">+ New Program</a>
            </x-slot:actions>
        </x-lms-page-header>

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Total Programs</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalPrograms }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-blue-50 dark:bg-blue-950/40">📚</div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Active Programs</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $activePrograms }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-green-50 dark:bg-green-950/40">✅</div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Inactive Programs</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $inactivePrograms }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-red-50 dark:bg-red-950/40">⏸️</div>
                </div>
            </div>
        </div>

        <div class="programs-table overflow-hidden p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">Program</th>
                            <th class="px-4 py-3 text-center">Period</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Classes</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($programs as $program)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800">{{ $program->name }}</div>
                                    <div class="text-xs text-slate-500">{{ Str::limit($program->description, 70) }}</div>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600 text-xs">
                                    {{ $program->start_date->format('d M Y') }} - {{ $program->end_date->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($program->status == 'active')
                                        <span class="lms-badge lms-badge--success">Active</span>
                                    @else
                                        <span class="lms-badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-slate-700 font-medium text-xs">
                                    {{ $program->classes_count }}/{{ $program->capacity }} kelas
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.programs.show', $program) }}" class="btn-action px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm">View</a>
                                        <a href="{{ route('admin.programs.edit', $program) }}" class="btn-action px-2 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-md text-xs transition shadow-sm">Edit</a>
                                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" data-lms-confirm="Delete this program?" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs transition shadow-sm">Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-sm">No training programs available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-slate-100 text-xs">
                {{ $programs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>