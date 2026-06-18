@props(['rows' => 5, 'cols' => 5])

<div class="lms-table-skeleton" aria-hidden="true">
    <div class="lms-table-skeleton__head">
        @for ($c = 0; $c < $cols; $c++)
            <x-ds.skeleton variant="line" class="!h-3 !mb-0" />
        @endfor
    </div>
    @for ($r = 0; $r < $rows; $r++)
        <div class="lms-table-skeleton__row">
            @for ($c = 0; $c < $cols; $c++)
                <x-ds.skeleton variant="line" class="!h-3 !mb-0" style="width: {{ $c === $cols - 1 ? '60%' : '100%' }};" />
            @endfor
        </div>
    @endfor
</div>
