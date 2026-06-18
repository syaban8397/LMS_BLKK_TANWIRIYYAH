<x-app-layout>
    <div class="dashboard-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.nav.my_classes')"
            :subtitle="__('lms.common.welcome_back', ['name' => auth()->user()->name])"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes')],
            ]"
        >
            <x-slot:actions>
                <div class="stat-card px-4 py-2 !shadow-sm">
                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('lms.common.role') }}</span>
                    <p class="font-semibold text-slate-700 dark:text-slate-200">{{ __('lms.roles.instruktur') }}</p>
                </div>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />

        <x-lms-stat-grid>
            <x-lms-stat-card
                :label="__('lms.common.total_classes')"
                :value="$totalClasses"
                icon="📚"
                tone="blue"
            />
            <x-lms-stat-card
                :label="__('lms.common.active_classes')"
                :value="$activeClasses"
                icon="✅"
                tone="green"
            />
            <x-lms-stat-card
                :label="__('lms.common.total_students')"
                :value="$totalStudents"
                icon="👥"
                tone="indigo"
            />
        </x-lms-stat-grid>

        <x-lms-card class="table-card p-0" :title="__('lms.common.class_list')" :meta="__('lms.common.showing', ['from' => $classes->firstItem() ?? 0, 'to' => $classes->lastItem() ?? 0, 'total' => $classes->total()])">
            <x-lms-data-table :paginator="$classes" :skeleton-cols="6">
                <x-slot:head>
                    <tr>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.report.class_name') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.report.program') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.period') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.dashboard.students') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.status') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                    </tr>
                </x-slot:head>

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
                            <x-lms-status-badge :status="$classItem->status" />
                        </td>
                        <td class="px-6 py-5 text-center">
                            <x-lms-row-actions>
                                <x-lms-action-btn variant="view" :href="route('instruktur.classes.stream', $classItem)">{{ __('lms.view') }}</x-lms-action-btn>
                            </x-lms-row-actions>
                        </td>
                    </tr>
                @empty
                    <x-lms-table-empty :colspan="6" :message="__('lms.common.no_classes_assigned')" />
                @endforelse
            </x-lms-data-table>
        </x-lms-card>
    </div>
</x-app-layout>
