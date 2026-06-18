<div class="flex flex-wrap gap-2 justify-end">
    @if(!empty($excelRoute))
        <a href="{{ route($excelRoute, $routeParams ?? []) }}" class="lms-btn-success">
            {{ __('lms.export_excel') }}
        </a>
    @endif
    @if(!empty($pdfRoute))
        <a href="{{ route($pdfRoute, $routeParams ?? []) }}" class="lms-btn-secondary">
            {{ __('lms.export_pdf') }}
        </a>
    @endif
</div>
