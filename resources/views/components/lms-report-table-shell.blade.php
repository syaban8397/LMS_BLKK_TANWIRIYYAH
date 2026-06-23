@props([
    'excelRoute' => null,
    'pdfRoute' => null,
    'routeParams' => [],
])

<div {{ $attributes->merge(['class' => 'lms-report-panel']) }}>
    @if($excelRoute || $pdfRoute)
        <div class="lms-report-panel__toolbar">
            @include('admin.reports._export-actions', [
                'excelRoute' => $excelRoute,
                'pdfRoute' => $pdfRoute,
                'routeParams' => $routeParams,
            ])
        </div>
    @endif

    <div class="lms-report-table-wrap">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="lms-report-panel__footer">{{ $footer }}</div>
    @endif
</div>
