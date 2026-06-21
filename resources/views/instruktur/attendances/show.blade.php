<x-app-layout>
    <x-lms-page-shell>
        <x-lms-page-header
            :title="__('lms.attendance.meeting_title_instruktur', ['number' => $meetingNumber])"
            :subtitle="$class->title . ' • ' . \Carbon\Carbon::parse($meetingDate)->format('d F Y H:i')"
            :back-url="route('instruktur.attendances.index', $class)"
            :back-label="__('lms.attendance.back_to_sessions')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.attendance.sessions'), 'url' => route('instruktur.attendances.index', $class)],
                ['label' => __('lms.attendance.meeting_title_instruktur', ['number' => $meetingNumber])],
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('instruktur.attendances.edit', [$class, $meetingNumber]) }}" class="lms-btn-warning inline-flex items-center gap-1">
                    <x-lms-icon name="edit" class="w-4 h-4" />
                    {{ __('lms.edit') }}
                </a>
            </x-slot:actions>
        </x-lms-page-header>

        @if(isset($deadline) && $deadline)
            <x-lms-notice tone="info">
                <x-slot:title>
                    {{ __('lms.attendance.deadline_label') }} {{ $deadline->format('d F Y H:i') }}
                    @if(now()->gt($deadline))
                        <span class="lms-badge lms-badge--danger ml-2">{{ __('lms.attendance.closed_students') }}</span>
                    @else
                        <span class="lms-badge lms-badge--success ml-2">{{ __('lms.attendance.open_students') }}</span>
                    @endif
                </x-slot:title>
            </x-lms-notice>
        @endif

        <x-lms-section :title="__('lms.common.statistics')" icon="chart" compact>
            <x-lms-panel flush pad="false">
                <x-lms-stat-grid class="lms-stat-grid--4">
                    <x-lms-stat-card :label="__('lms.report.present')" :value="$summary['present']" icon="check-circle" tone="green" />
                    <x-lms-stat-card :label="__('lms.report.permission')" :value="$summary['permission']" icon="clock" tone="amber" />
                    <x-lms-stat-card :label="__('lms.report.sick')" :value="$summary['sick']" icon="document" tone="indigo" />
                    <x-lms-stat-card :label="__('lms.report.absent')" :value="$summary['absent']" icon="x-circle" tone="blue" />
                </x-lms-stat-grid>
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.attendance.student_details')" :description="__('lms.attendance.status_per_student')" icon="users" compact>
            <x-lms-panel flush pad="false">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-600 text-sm">
                            <tr>
                                <th class="px-6 py-4 text-left">{{ __('lms.attendance.student') }}</th>
                                <th class="px-6 py-4 text-left">{{ __('lms.common.status') }}</th>
                                <th class="px-6 py-4 text-left">{{ __('lms.attendance.submission_type') }}</th>
                                <th class="px-6 py-4 text-left">{{ __('lms.attendance.check_in_time') }}</th>
                                <th class="px-6 py-4 text-left">{{ __('lms.attendance.notes_optional') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                                @php
                                    $statusLabels = [
                                        'present' => __('lms.report.present'),
                                        'permission' => __('lms.report.permission'),
                                        'sick' => __('lms.report.sick'),
                                        'absent' => __('lms.report.absent'),
                                    ];
                                    $statusBadgeClasses = [
                                        'present' => 'lms-badge--success',
                                        'permission' => 'lms-badge--warning',
                                        'sick' => 'lms-badge--warning',
                                        'absent' => 'lms-badge--danger',
                                    ];
                                    $statusIcons = [
                                        'present' => 'check-circle',
                                        'permission' => 'edit',
                                        'sick' => 'warning',
                                        'absent' => 'ban',
                                    ];
                                @endphp
                                <tr class="attendance-row border-t border-slate-100 hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-800">{{ $attendance->participant->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $attendance->participant->email }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="lms-badge {{ $statusBadgeClasses[$attendance->status] }} inline-flex items-center gap-1">
                                            <x-lms-icon :name="$statusIcons[$attendance->status]" class="w-3 h-3" />
                                            {{ $statusLabels[$attendance->status] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4 text-slate-600">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $attendance->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>
</x-app-layout>
