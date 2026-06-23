<x-app-layout>
    <x-lms-page-shell class="lms-report-shell">
        <x-lms-page-header
            :title="__('lms.report.attendance_summary') . ' — ' . $class->title"
            :subtitle="$class->program->name . ' · ' . $class->instructor->name"
            :back-url="route('admin.reports.attendance')"
            :back-label="__('lms.report.back')"
            :breadcrumbs="[
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.attendance'), 'url' => route('admin.reports.attendance')],
                ['label' => $class->title],
            ]"
        />

        <x-lms-report-table-shell
            excel-route="admin.reports.attendance.export"
            pdf-route="admin.reports.attendance.export-pdf"
            :route-params="[$class]"
        >
            <table class="lms-report-table min-w-[900px]">
                <thead>
                    <tr>
                        <th>{{ __('lms.report.no') }}</th>
                        @include('admin.reports._participant-minimal-head')
                        <th class="text-center">{{ __('lms.report.present') }}</th>
                        <th class="text-center">{{ __('lms.report.permission') }}</th>
                        <th class="text-center">{{ __('lms.report.sick') }}</th>
                        <th class="text-center">{{ __('lms.report.absent') }}</th>
                        @foreach($meetings as $meeting)
                            <th class="text-center">P{{ $meeting->meeting_number }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceMatrix as $index => $row)
                        <tr>
                            <td class="text-slate-500 tabular-nums">{{ $index + 1 }}</td>
                            @if($row['participant'] ?? null)
                                @include('admin.reports._participant-minimal-row', ['user' => $row['participant']])
                            @else
                                @for($i = 0; $i < 3; $i++)<td>-</td>@endfor
                            @endif
                            <td class="text-center text-green-700 tabular-nums">{{ $row['present_count'] }}</td>
                            <td class="text-center text-amber-700 tabular-nums">{{ $row['permission_count'] }}</td>
                            <td class="text-center text-blue-700 tabular-nums">{{ $row['sick_count'] }}</td>
                            <td class="text-center text-red-700 tabular-nums">{{ $row['absent_count'] }}</td>
                            @foreach($meetings as $meeting)
                                <td class="text-center text-xs">{{ $row['attendances'][$meeting->meeting_number] ?? '-' }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="{{ 8 + $meetings->count() }}" class="py-10 text-center text-slate-400">{{ __('lms.no_data') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-lms-report-table-shell>
    </x-lms-page-shell>
</x-app-layout>
