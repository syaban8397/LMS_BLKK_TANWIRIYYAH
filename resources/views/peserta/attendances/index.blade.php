{{-- resources/views/peserta/attendances/index.blade.php --}}
<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="$class->title . ' - ' . __('lms.common.attendance')"
            :subtitle="__('lms.attendance.index_subtitle')"
            :back-url="route('peserta.classes.stream', $class)"
            :back-label="__('lms.common.back_to_class')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('peserta.classes.index')],
                ['label' => $class->title, 'url' => route('peserta.classes.show', $class)],
                ['label' => __('lms.common.attendance')],
            ]"
        />

        <x-lms-section :title="__('lms.attendance.sessions')" :description="__('lms.attendance.index_card_meta')" icon="clipboard" compact>
            <x-lms-data-table :skeleton-cols="7">
                <x-slot:head>
                    <tr>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.common.meeting') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.attendance.date') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.attendance.your_status') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.attendance.submitted_via') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.attendance.check_in_time') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.due') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.attendance.action') }}</th>
                    </tr>
                </x-slot:head>

                @forelse($attendances as $attendance)
                    @php
                        $deadline = $attendance->attendance_deadline;
                        $hasStarted = now()->gte($attendance->attendance_date);
                        $canSubmit = $hasStarted && $deadline && now()->lessThanOrEqualTo($deadline);
                        $isNotStarted = !$hasStarted;
                        $isModifiedByInstructor = $attendance->submission_type == 'instructor';
                        $isSubmitted = $attendance->status != 'absent' || $attendance->check_in_time;
                    @endphp
                    <tr class="attendance-row transition">
                        <td class="px-5 py-4 font-medium text-slate-800 dark:text-slate-100">{{ __('lms.common.meeting') }} {{ $attendance->meeting_number }}</td>
                        <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d F Y H:i') }}</td>
                        <td class="px-5 py-4 text-center">
                            @switch($attendance->status)
                                @case('present')
                                    <span class="lms-badge lms-badge--success inline-flex items-center gap-1">
                                        <x-lms-icon name="check-circle" class="w-3 h-3" />
                                        {{ __('lms.report.present') }}
                                    </span>
                                    @break
                                @case('permission')
                                    <span class="lms-badge lms-badge--warning inline-flex items-center gap-1">
                                        <x-lms-icon name="edit" class="w-3 h-3" />
                                        {{ __('lms.report.permission') }}
                                    </span>
                                    @break
                                @case('sick')
                                    <span class="lms-badge lms-badge--warning inline-flex items-center gap-1">
                                        <x-lms-icon name="warning" class="w-3 h-3" />
                                        {{ __('lms.report.sick') }}
                                    </span>
                                    @break
                                @default
                                    <span class="lms-badge lms-badge--danger inline-flex items-center gap-1">
                                        <x-lms-icon name="ban" class="w-3 h-3" />
                                        {{ __('lms.report.absent') }}
                                    </span>
                            @endswitch
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($attendance->submission_type == 'self')
                                <span class="lms-badge lms-badge--info inline-flex items-center gap-1">
                                    <x-lms-icon name="clipboard" class="w-3 h-3" />
                                    {{ __('lms.attendance.self') }}
                                </span>
                            @else
                                <span class="lms-badge lms-badge--warning inline-flex items-center gap-1">
                                    <x-lms-icon name="edit" class="w-3 h-3" />
                                    {{ __('lms.attendance.by_instructor') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center text-slate-600 dark:text-slate-300">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}</td>
                        <td class="px-5 py-4 text-center">
                            @if($deadline)
                                @if($canSubmit)
                                    <span class="text-xs text-green-600 dark:text-green-400 font-medium">{{ $deadline->format('d M Y H:i') }}</span>
                                @else
                                    <span class="text-xs text-red-500 dark:text-red-400 font-medium">{{ __('lms.attendance.closed') }}</span>
                                @endif
                            @else
                                <span class="text-xs text-slate-400">{{ __('lms.attendance.no_deadline') }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($canSubmit && !$isModifiedByInstructor)
                                <x-lms-row-actions>
                                    <x-lms-action-btn variant="edit" :href="route('peserta.attendances.show', [$class, $attendance->meeting_number])">
                                        {{ $isSubmitted ? __('lms.edit') : __('lms.attendance.submit_btn') }}
                                    </x-lms-action-btn>
                                </x-lms-row-actions>
                            @elseif($isNotStarted)
                                <span class="lms-badge lms-badge--info">{{ __('lms.attendance.not_started') }}</span>
                            @elseif($isModifiedByInstructor)
                                <span class="lms-badge lms-badge--warning">{{ __('lms.attendance.locked') }}</span>
                            @else
                                <span class="lms-badge">{{ __('lms.attendance.closed') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <x-lms-table-empty :colspan="7" :message="__('lms.attendance.no_sessions')" />
                @endforelse
            </x-lms-data-table>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
