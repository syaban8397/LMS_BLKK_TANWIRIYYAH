<x-app-layout>
    <x-lms-page-shell class="lms-report-shell">
        <x-lms-page-header
            :title="__('lms.report.classes') . ' — ' . $class->title"
            :subtitle="$class->program->name . ' · ' . __('lms.report.instructor') . ': ' . $class->instructor->name . ' · ' . $class->code"
            :back-url="route('admin.reports.classes')"
            :back-label="__('lms.report.back')"
            :breadcrumbs="[
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.classes'), 'url' => route('admin.reports.classes')],
                ['label' => $class->title],
            ]"
        />

        <x-lms-report-table-shell
            excel-route="admin.reports.classes.export-class"
            pdf-route="admin.reports.classes.export-class-pdf"
            :route-params="[$class]"
        >
            <table class="lms-report-table min-w-[1600px]">
                <thead>
                    <tr>
                        <th>{{ __('lms.report.no') }}</th>
                        @include('admin.reports._user-columns-head')
                        <th class="text-center">{{ __('lms.report.attendance_short') }}</th>
                        <th class="text-center">{{ __('lms.report.submission_col') }}</th>
                        <th class="text-center">{{ __('lms.report.graduation_status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $row)
                        @php $status = $row['final_grade']?->status; @endphp
                        <tr>
                            <td class="text-slate-500 tabular-nums">{{ $index + 1 }}</td>
                            @include('admin.reports._user-columns-row', ['user' => $row['participant']])
                            <td class="text-center">
                                <span class="font-semibold text-blue-700 tabular-nums">{{ $row['attendance_count'] }}</span>
                                <span class="text-slate-400">/ {{ $row['total_meetings'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="font-semibold text-purple-700 tabular-nums">{{ $row['submission_count'] }}</span>
                                <span class="text-slate-400">/ {{ $row['total_assignments'] }}</span>
                            </td>
                            <td class="text-center"><span class="lms-status-pill lms-status-pill--neutral">{{ $status ?? '-' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="17" class="py-10 text-center text-slate-400">{{ __('lms.no_data') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-lms-report-table-shell>
    </x-lms-page-shell>
</x-app-layout>
