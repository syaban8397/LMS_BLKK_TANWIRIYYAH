<x-app-layout>

    <div class="lms-page-shell lms-module-shell lms-report-shell space-y-5">

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

        >

            <x-slot:actions>
                @include('admin.reports._export-actions', [
                    'excelRoute' => 'admin.reports.attendance.export',
                    'pdfRoute' => 'admin.reports.attendance.export-pdf',
                    'routeParams' => [$class],
                ])
            </x-slot:actions>

        </x-lms-page-header>

        <x-lms-session-flash />

        <div class="lms-report-table-wrap bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">

            <table class="w-full text-sm min-w-[900px]">

                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">

                    <tr>

                        <th class="px-3 py-3 text-left">{{ __('lms.report.no') }}</th>

                        @include('admin.reports._participant-minimal-head')

                        <th class="px-3 py-3 text-center">{{ __('lms.report.present') }}</th>

                        <th class="px-3 py-3 text-center">{{ __('lms.report.permission') }}</th>

                        <th class="px-3 py-3 text-center">{{ __('lms.report.sick') }}</th>

                        <th class="px-3 py-3 text-center">{{ __('lms.report.absent') }}</th>

                        @foreach($meetings as $meeting)

                            <th class="px-3 py-3 text-center">P{{ $meeting->meeting_number }}</th>

                        @endforeach

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($attendanceMatrix as $index => $row)

                        <tr class="hover:bg-slate-50">

                            <td class="px-3 py-3 text-slate-500">{{ $index + 1 }}</td>

                            @if($row['participant'] ?? null)

                                @include('admin.reports._participant-minimal-row', ['user' => $row['participant']])

                            @else

                                @for($i = 0; $i < 3; $i++)<td class="px-3 py-3">-</td>@endfor

                            @endif

                            <td class="px-3 py-3 text-center text-green-700">{{ $row['present_count'] }}</td>

                            <td class="px-3 py-3 text-center text-amber-700">{{ $row['permission_count'] }}</td>

                            <td class="px-3 py-3 text-center text-blue-700">{{ $row['sick_count'] }}</td>

                            <td class="px-3 py-3 text-center text-red-700">{{ $row['absent_count'] }}</td>

                            @foreach($meetings as $meeting)

                                <td class="px-3 py-3 text-center text-xs">{{ $row['attendances'][$meeting->meeting_number] ?? '-' }}</td>

                            @endforeach

                        </tr>

                    @empty

                        <tr><td colspan="{{ 8 + $meetings->count() }}" class="py-10 text-center text-slate-400">{{ __('lms.no_data') }}</td></tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>
