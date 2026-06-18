@props([
    'paginator' => null,
    'skeletonRows' => 5,
    'skeletonCols' => 5,
])

<div {{ $attributes->merge(['class' => 'lms-data-table']) }}>
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
