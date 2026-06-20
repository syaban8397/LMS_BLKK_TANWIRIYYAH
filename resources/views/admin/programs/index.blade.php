<x-app-layout>
    <div class="programs-wrapper lms-page-shell space-y-5">
        <x-lms-page-header :title="__('lms.nav.training_programs')" :subtitle="__('lms.common.manage_programs_desc')">
            <x-slot:actions>
                <x-ds.button tag="a" :href="route('admin.programs.create')" variant="primary">{{ __('lms.common.new_program') }}</x-ds.button>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />

        <x-lms-stat-grid>
            <x-lms-stat-card
                :label="__('lms.common.total_programs')"
                :value="$totalPrograms"
                icon="book"
                tone="blue"
            />
            <x-lms-stat-card
                :label="__('lms.common.active_programs')"
                :value="$activePrograms"
                icon="check-circle"
                tone="green"
            />
            <x-lms-stat-card
                :label="__('lms.common.inactive_programs')"
                :value="$inactivePrograms"
                icon="pause"
                tone="red"
            />
        </x-lms-stat-grid>

        <x-lms-data-table :paginator="$programs" :skeleton-cols="5">
            <x-slot:head>
                <tr>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.report.program') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.period') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.status') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.nav.classes') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                </tr>
            </x-slot:head>

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
                        <x-lms-status-badge :status="$program->status" type="program" />
                    </td>
                    <td class="px-4 py-3 text-center text-slate-700 font-medium text-xs">
                        {{ __('lms.common.classes_slot', ['current' => $program->classes_count, 'max' => $program->capacity]) }}
                    </td>
                    <td class="px-4 py-3">
                        <x-lms-row-actions>
                            <x-lms-action-btn variant="view" :href="route('admin.programs.show', $program)">{{ __('lms.view') }}</x-lms-action-btn>
                            <x-lms-action-btn variant="edit" :href="route('admin.programs.edit', $program)">{{ __('lms.edit') }}</x-lms-action-btn>
                            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <x-lms-action-btn variant="delete" type="submit" :confirm="__('lms.common.delete_program')">{{ __('lms.common.del') }}</x-lms-action-btn>
                            </form>
                        </x-lms-row-actions>
                    </td>
                </tr>
            @empty
                <x-lms-table-empty :colspan="5" :message="__('lms.common.no_programs')" />
            @endforelse
        </x-lms-data-table>
    </div>
</x-app-layout>
