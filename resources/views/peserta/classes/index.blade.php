<x-app-layout>
    <div class="peserta-index-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.nav.my_classes')"
            :subtitle="__('lms.common.view_enrolled')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes')],
            ]"
        />

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
                :label="__('lms.dashboard.completed_classes')"
                :value="$completedClasses"
                icon="graduation-cap"
                tone="indigo"
            />
        </x-lms-stat-grid>

        <x-lms-card class="table-card p-0" :title="__('lms.common.class_list')" :meta="__('lms.common.total') . ': ' . $enrolledClasses->total()">
            <x-lms-data-table :paginator="$enrolledClasses" :skeleton-cols="6">
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
                                @case('active')
                                    <x-lms-status-badge status="active" />
                                    @break
                                @case('completed')
                                    <x-lms-status-badge status="completed" />
                                    @break
                                @case('dropped')
                                    <span class="lms-badge lms-badge--danger">{{ __('lms.common.dropped') }}</span>
                                    @break
                                @default
                                    <x-lms-status-badge :status="$enrollment->status" />
                            @endswitch
                        </td>
                        <td class="px-5 py-4 text-center">
                            <x-lms-row-actions>
                                <x-lms-action-btn variant="view" :href="route('peserta.classes.stream', $enrollment->class)">{{ __('lms.view') }}</x-lms-action-btn>
                            </x-lms-row-actions>
                        </td>
                    </tr>
                @empty
                    <x-lms-table-empty :colspan="6" :message="__('lms.common.not_enrolled')" />
                @endforelse
            </x-lms-data-table>
        </x-lms-card>
    </div>
</x-app-layout>
