<x-app-layout>
    <div class="lms-page-shell space-y-5">
        <x-lms-page-header :title="__('lms.nav.classes')" :subtitle="__('lms.common.manage_classes_desc')">
            <x-slot:actions>
                <x-ds.button tag="a" :href="route('admin.classes.create')" variant="primary">{{ __('lms.common.new_class') }}</x-ds.button>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />

        <x-lms-stat-grid>
            <x-lms-stat-card
                :label="__('lms.common.total_classes')"
                :value="$totalClasses"
                icon="book"
                tone="blue"
            />
            <x-lms-stat-card
                :label="__('lms.common.active_classes')"
                :value="$activeClasses"
                icon="check-circle"
                tone="green"
            />
            <x-lms-stat-card
                :label="__('lms.common.draft_classes')"
                :value="$draftClasses"
                icon="document"
                tone="amber"
            />
        </x-lms-stat-grid>

        <x-lms-data-table :paginator="$classes" :skeleton-cols="6">
            <x-slot:head>
                <tr>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.report.class_name') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.report.program') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.report.instructor') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.period') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.status') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                </tr>
            </x-slot:head>

            @forelse($classes as $class)
                <tr>
                    <td>
                        <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $class->title }}</div>
                        <div class="text-xs text-slate-500">{{ $class->code }}</div>
                    </td>
                    <td class="text-slate-600 dark:text-slate-300 text-xs">{{ $class->program->name }}</td>
                    <td class="text-slate-600 dark:text-slate-300 text-xs">{{ $class->instructor->name }}</td>
                    <td class="text-center text-slate-600 dark:text-slate-300 text-xs">
                        {{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}
                    </td>
                    <td class="text-center">
                        <x-lms-status-badge :status="$class->status" type="class" />
                    </td>
                    <td>
                        <x-lms-row-actions>
                            <x-lms-action-btn variant="view" :href="route('admin.classes.show', $class)">{{ __('lms.view') }}</x-lms-action-btn>
                            <x-lms-action-btn variant="edit" :href="route('admin.classes.edit', $class)">{{ __('lms.edit') }}</x-lms-action-btn>
                            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <x-lms-action-btn variant="delete" type="submit" :confirm="__('lms.common.delete_class')">{{ __('lms.common.del') }}</x-lms-action-btn>
                            </form>
                        </x-lms-row-actions>
                    </td>
                </tr>
            @empty
                <x-lms-table-empty :colspan="6" :message="__('lms.common.no_classes_found')" />
            @endforelse
        </x-lms-data-table>
    </div>
</x-app-layout>
