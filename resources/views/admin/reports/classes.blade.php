<x-app-layout>
    <x-lms-page-shell class="lms-report-shell space-y-5">
        @include('admin.reports._header', [
            'title' => __('lms.report.classes'),
            'description' => __('lms.report.classes_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.classes')],
            ],
        ])

        <x-lms-panel flush :pad="false">
            <div class="flex justify-end p-4 border-b border-slate-100">
                @include('admin.reports._export-actions', [
                    'excelRoute' => 'admin.reports.classes.export',
                    'pdfRoute' => 'admin.reports.classes.export-pdf',
                ])
            </div>

            <div class="lms-report-table-wrap">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">{{ __('lms.report.class_name') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('lms.report.program') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('lms.report.instructor') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.report.participants_col') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.report.materials') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.report.assignments_col') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.report.certificates_col') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.report.attendance_sessions_count') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('lms.report.session_detail') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('lms.report.action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($classes as $class)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800">{{ $class->title }}</div>
                                    <div class="text-xs text-slate-500">{{ $class->code }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $class->program->name }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $class->instructor->name }}</td>
                                <td class="px-4 py-3 text-center">{{ $class->participants_count }}</td>
                                <td class="px-4 py-3 text-center">{{ $class->materials_count }}</td>
                                <td class="px-4 py-3 text-center">{{ $class->assignments_count }}</td>
                                <td class="px-4 py-3 text-center">{{ $class->certificates_count }}</td>
                                <td class="px-4 py-3 text-center">{{ ($class->meeting_sessions ?? collect())->count() }}</td>
                                <td class="px-4 py-3 text-xs text-slate-500 max-w-xs">
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
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('admin.reports.classes.show', $class) }}"
                                       class="lms-action-btn lms-action-btn--view">{{ __('lms.report.detail') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="py-10 text-center text-slate-400">{{ __('lms.report.no_classes') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-lms-panel>
    </x-lms-page-shell>
</x-app-layout>
