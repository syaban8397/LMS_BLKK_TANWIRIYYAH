<x-app-layout>
    <x-lms-page-shell class="lms-report-shell space-y-5">
        @include('admin.reports._header', [
            'title' => __('lms.report.certificates'),
            'description' => __('lms.report.certificates_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.certificates')],
            ],
        ])

        <x-lms-panel flush :pad="false">
            <div class="flex justify-end p-4 border-b border-slate-100">
                @include('admin.reports._export-actions', [
                    'excelRoute' => 'admin.reports.certificates.export',
                    'pdfRoute' => 'admin.reports.certificates.export-pdf',
                ])
            </div>

            <div class="lms-report-table-wrap">
                <table class="w-full text-sm min-w-[1300px]">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                        <tr>
                            <th class="px-3 py-3 text-left">{{ __('lms.report.no') }}</th>
                            <th class="px-3 py-3 text-left">{{ __('lms.report.cert_number') }}</th>
                            @include('admin.reports._participant-minimal-head')
                            <th class="px-3 py-3 text-left">{{ __('lms.common.code') }}</th>
                            <th class="px-3 py-3 text-left">{{ __('lms.report.class_name') }}</th>
                            <th class="px-3 py-3 text-left">{{ __('lms.report.program') }}</th>
                            <th class="px-3 py-3 text-left">{{ __('lms.report.instructor') }}</th>
                            <th class="px-3 py-3 text-center">{{ __('lms.report.final_score') }}</th>
                            <th class="px-3 py-3 text-center">{{ __('lms.report.attendance_percentage') }}</th>
                            <th class="px-3 py-3 text-center">{{ __('lms.report.issued_at') }}</th>
                            <th class="px-3 py-3 text-left">{{ __('lms.report.pdf_file') }}</th>
                            <th class="px-3 py-3 text-left">{{ __('lms.report.qr_code') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($certificates as $index => $certificate)
                            <tr class="hover:bg-slate-50">
                                <td class="px-3 py-3 text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-3 py-3 font-mono text-xs text-slate-700">{{ $certificate->certificate_number ?? '-' }}</td>
                                @if($certificate->participant)
                                    @include('admin.reports._participant-minimal-row', ['user' => $certificate->participant])
                                @else
                                    @for($i = 0; $i < 3; $i++)<td class="px-3 py-3">-</td>@endfor
                                @endif
                                <td class="px-3 py-3 font-mono text-xs text-slate-600">{{ $certificate->class->code ?? '-' }}</td>
                                <td class="px-3 py-3 text-slate-600">{{ $certificate->class->title ?? '-' }}</td>
                                <td class="px-3 py-3 text-slate-600">{{ $certificate->class->program->name ?? '-' }}</td>
                                <td class="px-3 py-3 text-slate-600">{{ $certificate->class->instructor->name ?? '-' }}</td>
                                <td class="px-3 py-3 text-center">{{ $certificate->final_score ?? '-' }}</td>
                                <td class="px-3 py-3 text-center">{{ $certificate->attendance_percentage ?? '-' }}</td>
                                <td class="px-3 py-3 text-center text-xs whitespace-nowrap">{{ $certificate->issued_at ? $certificate->issued_at->format('Y-m-d H:i:s') : '-' }}</td>
                                <td class="px-3 py-3 text-xs text-slate-600">{{ $certificate->pdf_file ?? '-' }}</td>
                                <td class="px-3 py-3 text-xs text-slate-600">{{ $certificate->qr_code ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="14" class="py-10 text-center text-slate-400">{{ __('lms.report.no_certificates') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-lms-panel>
    </x-lms-page-shell>
</x-app-layout>
