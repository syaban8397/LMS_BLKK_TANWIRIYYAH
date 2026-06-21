<x-app-layout>
    <x-lms-page-shell class="lms-report-shell space-y-5">
        @include('admin.reports._header', [
            'title' => __('lms.report.participants'),
            'description' => __('lms.report.participants_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.participants')],
            ],
        ])

        <x-lms-panel flush :pad="false">
            <div class="flex justify-end p-4 border-b border-slate-100">
                @include('admin.reports._export-actions', [
                    'excelRoute' => 'admin.reports.participants.export',
                    'pdfRoute' => 'admin.reports.participants.export-pdf',
                ])
            </div>

            <div class="lms-report-table-wrap">
                <table class="w-full text-sm min-w-[1400px]">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-3 py-3 text-left">{{ __('lms.report.no') }}</th>
                            @include('admin.reports._user-columns-head')
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($participants as $index => $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-3 py-3 text-slate-500">{{ $index + 1 }}</td>
                                @include('admin.reports._user-columns-row', ['user' => $user])
                            </tr>
                        @empty
                            <tr><td colspan="14" class="py-10 text-center text-slate-400">{{ __('lms.no_data') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-lms-panel>
    </x-lms-page-shell>
</x-app-layout>
