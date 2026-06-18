<x-app-layout>
    <div class="programs-wrapper lms-page-shell space-y-5">
        <x-lms-page-header :title="__('lms.nav.training_programs')" :subtitle="__('lms.common.manage_programs_desc')">
            <x-slot:actions>
                <a href="{{ route('admin.programs.create') }}" class="lms-btn-primary btn-create">{{ __('lms.common.new_program') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.total_programs') }}</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalPrograms }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-blue-50 dark:bg-blue-950/40">📚</div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.active_programs') }}</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $activePrograms }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-green-50 dark:bg-green-950/40">✅</div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.inactive_programs') }}</p>
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
                            <th class="px-4 py-3 text-left">{{ __('lms.report.program') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.common.period') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.common.status') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.nav.classes') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.common.actions') }}</th>
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
                                        <span class="lms-badge lms-badge--success">{{ __('lms.active') }}</span>
                                    @else
                                        <span class="lms-badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ __('lms.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-slate-700 font-medium text-xs">
                                    {{ __('lms.common.classes_slot', ['current' => $program->classes_count, 'max' => $program->capacity]) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.programs.show', $program) }}" class="btn-action px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs transition shadow-sm">{{ __('lms.view') }}</a>
                                        <a href="{{ route('admin.programs.edit', $program) }}" class="btn-action px-2 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-md text-xs transition shadow-sm">{{ __('lms.edit') }}</a>
                                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" data-lms-confirm="{{ __('lms.common.delete_program') }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs transition shadow-sm">{{ __('lms.common.del') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-sm">{{ __('lms.common.no_programs') }}</td>
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
