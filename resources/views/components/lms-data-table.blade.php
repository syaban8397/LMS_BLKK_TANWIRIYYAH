@props([
    'paginator' => null,
    'skeletonRows' => 5,
    'skeletonCols' => 5,
    'title' => null,
    'meta' => null,
])

<div {{ $attributes->merge(['class' => 'lms-data-table card-3d']) }}>
    @if($title || $meta)
        <div class="lms-data-table__header">
            @if($title)
                <h3 class="lms-data-table__title">{{ $title }}</h3>
            @endif
            @if($meta)
                <p class="lms-data-table__meta">{{ $meta }}</p>
            @endif
        </div>
    @endif

    <div class="lms-data-table__skeleton" aria-hidden="true">
        <x-lms-table-skeleton :rows="$skeletonRows" :cols="$skeletonCols" />
    </div>

    <div class="lms-data-table__body-wrap">
        <x-ds.table>
            @isset($head)
                <thead class="lms-data-table__head">{{ $head }}</thead>
            @endisset
            <tbody class="lms-data-table__body">{{ $slot }}</tbody>
        </x-ds.table>
    </div>

    @if($paginator)
        <x-lms-pagination :paginator="$paginator" />
    @elseif(isset($pagination))
        <div class="lms-data-table__footer">{{ $pagination }}</div>
    @endif
</div>
