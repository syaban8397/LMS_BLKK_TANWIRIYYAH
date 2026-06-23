<x-app-layout>
    <x-lms-page-shell class="lms-report-shell">
        @include('admin.reports._header', [
            'title' => __('lms.report.attendance'),
            'description' => __('lms.report.attendance_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.attendance')],
            ],
        ])

        <x-lms-report-table-shell>
            <table class="lms-report-table">
                <thead>
                    <tr>
                        <th>{{ __('lms.report.class_name') }}</th>
                        <th>{{ __('lms.report.program') }}</th>
                        <th>{{ __('lms.report.instructor') }}</th>
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
                            <td class="text-center">
                                <x-lms-action-btn variant="view" :href="route('admin.reports.attendance.show', $class)">{{ __('lms.report.view_summary') }}</x-lms-action-btn>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-10 text-center text-slate-400">{{ __('lms.report.no_classes') }}</td></tr>
                    @endforelse
                </tbody>
            </table>

            @if($classes->hasPages())
                <x-slot:footer>{{ $classes->links() }}</x-slot:footer>
            @endif
        </x-lms-report-table-shell>
    </x-lms-page-shell>
</x-app-layout>
