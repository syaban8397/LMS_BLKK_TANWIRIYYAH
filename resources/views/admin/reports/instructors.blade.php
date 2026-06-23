<x-app-layout>
    <x-lms-page-shell class="lms-report-shell">
        @include('admin.reports._header', [
            'title' => __('lms.report.instructors'),
            'description' => __('lms.report.instructors_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.instructors')],
            ],
        ])

        <x-lms-report-table-shell
            excel-route="admin.reports.instructors.export"
            pdf-route="admin.reports.instructors.export-pdf"
        >
            <table class="lms-report-table min-w-[1400px]">
                <thead>
                    <tr>
                        <th>{{ __('lms.report.no') }}</th>
                        @include('admin.reports._user-columns-head')
                    </tr>
                </thead>
                <tbody>
                    @forelse($instructors as $index => $user)
                        <tr>
                            <td class="text-slate-500 tabular-nums">{{ $index + 1 }}</td>
                            @include('admin.reports._user-columns-row', ['user' => $user])
                        </tr>
                    @empty
                        <tr><td colspan="14" class="py-10 text-center text-slate-400">{{ __('lms.no_data') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-lms-report-table-shell>
    </x-lms-page-shell>
</x-app-layout>
