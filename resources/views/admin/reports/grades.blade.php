<x-app-layout>
    <x-lms-page-shell class="lms-report-shell">
        @include('admin.reports._header', [
            'title' => __('lms.report.grades'),
            'description' => __('lms.report.grades_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.grades')],
            ],
        ])

        <x-lms-report-table-shell
            excel-route="admin.reports.grades.export"
            pdf-route="admin.reports.grades.export-pdf"
        >
            <table class="lms-report-table min-w-[1200px]">
                <thead>
                    <tr>
                        <th>{{ __('lms.report.no') }}</th>
                        @include('admin.reports._participant-minimal-head')
                        <th>{{ __('lms.common.code') }}</th>
                        <th>{{ __('lms.report.class_name') }}</th>
                        <th>{{ __('lms.report.program') }}</th>
                        <th>{{ __('lms.report.instructor') }}</th>
                        <th class="text-center">{{ __('lms.report.assignment_score') }}</th>
                        <th class="text-center">{{ __('lms.report.attendance_score') }}</th>
                        <th class="text-center">{{ __('lms.report.final_score') }}</th>
                        <th class="text-center">{{ __('lms.report.graduation_status') }}</th>
                        <th>{{ __('lms.report.feedback') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grades as $index => $grade)
                        <tr>
                            <td class="text-slate-500 tabular-nums">{{ $index + 1 }}</td>
                            @if($grade->participant)
                                @include('admin.reports._participant-minimal-row', ['user' => $grade->participant])
                            @else
                                @for($i = 0; $i < 3; $i++)<td>-</td>@endfor
                            @endif
                            <td class="text-slate-600 font-mono text-xs">{{ $grade->class->code ?? '-' }}</td>
                            <td class="text-slate-600">{{ $grade->class->title ?? '-' }}</td>
                            <td class="text-slate-600">{{ $grade->class->program->name ?? '-' }}</td>
                            <td class="text-slate-600">{{ $grade->class->instructor->name ?? '-' }}</td>
                            <td class="text-center tabular-nums">{{ $grade->assignment_score ?? '-' }}</td>
                            <td class="text-center tabular-nums">{{ $grade->attendance_score ?? '-' }}</td>
                            <td class="text-center font-semibold tabular-nums">{{ $grade->final_score ?? '-' }}</td>
                            <td class="text-center"><span class="lms-status-pill lms-status-pill--neutral">{{ $grade->status ?? '-' }}</span></td>
                            <td class="text-slate-600">{{ $grade->feedback ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="13" class="py-10 text-center text-slate-400">{{ __('lms.report.no_grades') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-lms-report-table-shell>
    </x-lms-page-shell>
</x-app-layout>
