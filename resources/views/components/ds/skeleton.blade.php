@props([
    'variant' => 'line',
    'lines' => 3,
])

@if ($variant === 'block')
    <div {{ $attributes->merge(['class' => 'ds-skeleton ds-skeleton--block']) }} aria-hidden="true"></div>
@elseif ($variant === 'avatar')
    <div {{ $attributes->merge(['class' => 'ds-skeleton ds-skeleton--avatar']) }} aria-hidden="true"></div>
@elseif ($variant === 'card')
    <div {{ $attributes->merge(['class' => 'space-y-3']) }} aria-hidden="true">
        <div class="ds-skeleton ds-skeleton--title"></div>
        @for ($i = 0; $i < $lines; $i++)
            <div class="ds-skeleton ds-skeleton--line" style="width: {{ $i === $lines - 1 ? '75%' : '100%' }};"></div>
        @endfor
    </div>
@else
    <div {{ $attributes->merge(['class' => 'space-y-2']) }} aria-hidden="true">
        @for ($i = 0; $i < $lines; $i++)
            <div class="ds-skeleton ds-skeleton--line" style="width: {{ $i === $lines - 1 ? '60%' : '100%' }};"></div>
        @endfor
    </div>
@endif
