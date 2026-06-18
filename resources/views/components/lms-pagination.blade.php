@props(['paginator', 'always' => true])

@if($always || $paginator->hasPages())
    <div {{ $attributes->merge(['class' => 'lms-data-table__footer']) }}>
        {{ $paginator->withQueryString()->links() }}
    </div>
@endif
