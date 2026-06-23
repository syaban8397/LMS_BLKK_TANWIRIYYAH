<x-app-layout>
    <x-lms-page-shell class="lms-report-shell">
        @include('admin.reports._header', [
            'title' => __('lms.report.certificates'),
            'description' => __('lms.report.certificates_desc'),
            'breadcrumbs' => [
                ['label' => __('lms.report.index_title'), 'url' => route('admin.reports.index')],
                ['label' => __('lms.report.certificates')],
            ],
        ])

        <x-lms-report-table-shell
            excel-route="admin.reports.certificates.export"
            pdf-route="admin.reports.certificates.export-pdf"
        >
            <table class="lms-report-table min-w-[1300px]">
                <thead>
                    <tr>
                        <th>{{ __('lms.report.no') }}</th>
                        <th>{{ __('lms.report.cert_number') }}</th>
                        @include('admin.reports._participant-minimal-head')
                        <th>{{ __('lms.common.code') }}</th>
                        <th>{{ __('lms.report.class_name') }}</th>
                        <th>{{ __('lms.report.program') }}</th>
                        <th>{{ __('lms.report.instructor') }}</th>
                        <th class="text-center">{{ __('lms.report.final_score') }}</th>
                        <th class="text-center">{{ __('lms.report.attendance_percentage') }}</th>
                        <th class="text-center">{{ __('lms.report.issued_at') }}</th>
                        <th>{{ __('lms.report.pdf_file') }}</th>
                        <th>{{ __('lms.report.qr_code') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $index => $certificate)
                        <tr>
                            <td class="text-slate-500 tabular-nums">{{ $index + 1 }}</td>
                            <td class="font-mono text-xs text-slate-700">{{ $certificate->certificate_number ?? '-' }}</td>
                            @if($certificate->participant)
                                @include('admin.reports._participant-minimal-row', ['user' => $certificate->participant])
                            @else
                                @for($i = 0; $i < 3; $i++)<td>-</td>@endfor
                            @endif
                            <td class="font-mono text-xs text-slate-600">{{ $certificate->class->code ?? '-' }}</td>
                            <td class="text-slate-600">{{ $certificate->class->title ?? '-' }}</td>
                            <td class="text-slate-600">{{ $certificate->class->program->name ?? '-' }}</td>
                            <td class="text-slate-600">{{ $certificate->class->instructor->name ?? '-' }}</td>
                            <td class="text-center tabular-nums">{{ $certificate->final_score ?? '-' }}</td>
                            <td class="text-center tabular-nums">{{ $certificate->attendance_percentage ?? '-' }}</td>
                            <td class="text-center text-xs whitespace-nowrap">{{ $certificate->issued_at ? $certificate->issued_at->format('Y-m-d H:i') : '-' }}</td>
                            <td class="text-xs text-slate-600">{{ $certificate->pdf_file ?? '-' }}</td>
                            <td class="text-xs text-slate-600">{{ $certificate->qr_code ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="14" class="py-10 text-center text-slate-400">{{ __('lms.report.no_certificates') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-lms-report-table-shell>
    </x-lms-page-shell>
</x-app-layout>
