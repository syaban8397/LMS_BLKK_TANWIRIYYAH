<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.attendance.sessions')"
            :subtitle="$class->title . ' • ' . __('lms.attendance.manage_per_meeting')"
            :back-url="route('instruktur.classes.stream', $class)"
            :back-label="__('lms.common.back_to_class')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.attendance.sessions')],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('instruktur.attendances.create', $class) }}" class="lms-btn-primary inline-flex items-center gap-1">
                    <x-lms-icon name="plus" class="w-4 h-4" />
                    {{ __('lms.attendance.new_session') }}
                </a>
                <a href="{{ route('instruktur.attendances.report', $class) }}" class="lms-btn-secondary">{{ __('lms.attendance.report') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-section :title="__('lms.attendance.sessions')" :description="__('lms.attendance.index_table_meta')" icon="clipboard" compact>
            <x-lms-data-table :skeleton-cols="8">
                <x-slot:head>
                    <tr>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.common.meeting') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.attendance.date') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.report.present') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.report.permission') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.report.sick') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.report.absent') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.total') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                    </tr>
                </x-slot:head>

                @forelse($meetings as $meeting)
                    @php
                        $stats = $meetingStats->get($meeting->meeting_number, collect());
                        $present    = (int) ($stats->firstWhere('status', 'present')?->aggregate ?? 0);
                        $permission = (int) ($stats->firstWhere('status', 'permission')?->aggregate ?? 0);
                        $sick       = (int) ($stats->firstWhere('status', 'sick')?->aggregate ?? 0);
                        $absent     = (int) ($stats->firstWhere('status', 'absent')?->aggregate ?? 0);
                        $total      = $present + $permission + $sick + $absent;
                    @endphp
                    <tr class="attendance-row transition">
                        <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-100">{{ __('lms.common.meeting') }} {{ $meeting->meeting_number }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($meeting->attendance_date)->format('d F Y H:i') }}</td>
                        <td class="px-6 py-4 text-center lms-status-col lms-status-col--present">{{ $present }}</td>
                        <td class="px-6 py-4 text-center lms-status-col lms-status-col--permission">{{ $permission }}</td>
                        <td class="px-6 py-4 text-center lms-status-col lms-status-col--sick">{{ $sick }}</td>
                        <td class="px-6 py-4 text-center lms-status-col lms-status-col--absent">{{ $absent }}</td>
                        <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">{{ $total }}</td>
                        <td class="px-6 py-4 text-center">
                            <x-lms-row-actions>
                                <x-lms-action-btn variant="view" :href="route('instruktur.attendances.show', [$class, $meeting->meeting_number])">{{ __('lms.view') }}</x-lms-action-btn>
                                <x-lms-action-btn variant="edit" :href="route('instruktur.attendances.edit', [$class, $meeting->meeting_number])">{{ __('lms.edit') }}</x-lms-action-btn>
                                <form action="{{ route('instruktur.attendances.destroy', [$class, $meeting->meeting_number]) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <x-lms-action-btn variant="delete" type="submit" :confirm="__('lms.attendance.delete_session_confirm')">{{ __('lms.delete') }}</x-lms-action-btn>
                                </form>
                            </x-lms-row-actions>
                        </td>
                    </tr>
                @empty
                    <x-lms-table-empty :colspan="8" :message="__('lms.attendance.no_sessions')" icon="calendar">
                        <x-slot:actions>
                            <a href="{{ route('instruktur.attendances.create', $class) }}" class="text-blue-600 dark:text-blue-400 hover:underline mt-2 inline-block">{{ __('lms.attendance.create_first') }}</a>
                        </x-slot:actions>
                    </x-lms-table-empty>
                @endforelse
            </x-lms-data-table>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
