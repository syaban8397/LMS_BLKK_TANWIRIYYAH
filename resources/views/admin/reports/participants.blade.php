<x-app-layout>

    <div class="lms-page-shell lms-module-shell lms-report-shell space-y-5">

        @include('admin.reports._header', [
            'title' => __('lms.report.participants'),
            'description' => __('lms.report.participants_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.participants')],
            ],
        ])

        <x-lms-session-flash />

        <div class="flex justify-end">
            @include('admin.reports._export-actions', [
                'excelRoute' => 'admin.reports.participants.export',
                'pdfRoute' => 'admin.reports.participants.export-pdf',
            ])
        </div>

        <div class="lms-report-table-wrap bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">

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

    </div>

</x-app-layout>
