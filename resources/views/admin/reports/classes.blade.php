<x-app-layout>
    <x-lms-page-shell class="lms-report-shell">
        @include('admin.reports._header', [
            'title' => __('lms.report.classes'),
            'description' => __('lms.report.classes_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.classes')],
            ],
        ])

        <x-lms-report-table-shell
            excel-route="admin.reports.classes.export"
            pdf-route="admin.reports.classes.export-pdf"
        >
            <table class="lms-report-table min-w-[1100px]">
                <thead>
                    <tr>
                        <th>{{ __('lms.report.class_name') }}</th>
                        <th>{{ __('lms.report.program') }}</th>
                        <th>{{ __('lms.report.instructor') }}</th>
                        <th class="text-center">{{ __('lms.report.participants_col') }}</th>
                        <th class="text-center">{{ __('lms.report.materials') }}</th>
                        <th class="text-center">{{ __('lms.report.assignments_col') }}</th>
                        <th class="text-center">{{ __('lms.report.certificates_col') }}</th>
                        <th class="text-center">{{ __('lms.report.attendance_sessions_count') }}</th>
                        <th>{{ __('lms.report.session_detail') }}</th>
                        <th class="text-center">{{ __('lms.report.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td>
                                <div class="font-semibold">{{ $class->title }}</div>
                                <div class="text-xs text-slate-500">{{ $class->code }}</div>
                            </td>
                            <td class="text-slate-600">{{ $class->program->name }}</td>
                            <td class="text-slate-600">{{ $class->instructor->name }}</td>
                            <td class="text-center tabular-nums">{{ $class->participants_count }}</td>
                            <td class="text-center tabular-nums">{{ $class->materials_count }}</td>
                            <td class="text-center tabular-nums">{{ $class->assignments_count }}</td>
                            <td class="text-center tabular-nums">{{ $class->certificates_count }}</td>
                            <td class="text-center tabular-nums">{{ ($class->meeting_sessions ?? collect())->count() }}</td>
                            <td class="text-xs text-slate-500 max-w-xs">
                                @php
                                    $sessions = $class->meeting_sessions ?? collect();
                                    $sessionText = $sessions->map(function ($meeting) {
                                        $date = $meeting->attendance_date
                                            ? $meeting->attendance_date->format('Y-m-d')
                                            : '-';
                                        return 'P' . $meeting->meeting_number . ' (' . $date . ')';
                                    })->implode(', ');
                                @endphp
                                {{ $sessionText ?: '-' }}
                            </td>
                            <td class="text-center">
                                <x-lms-action-btn variant="view" :href="route('admin.reports.classes.show', $class)">{{ __('lms.report.detail') }}</x-lms-action-btn>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="py-10 text-center text-slate-400">{{ __('lms.report.no_classes') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-lms-report-table-shell>
    </x-lms-page-shell>
</x-app-layout>
