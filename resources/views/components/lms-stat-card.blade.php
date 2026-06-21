@props(['label', 'value', 'icon' => 'chart', 'tone' => 'blue', 'hint' => null, 'animate' => false, 'suffix' => null])

@php
    $toneClass = match ($tone) {
        'green' => 'lms-stat-card--green',
        'amber' => 'lms-stat-card--amber',
        'red' => 'lms-stat-card--red',
        'indigo' => 'lms-stat-card--indigo',
        'yellow' => 'lms-stat-card--amber',
        default => 'lms-stat-card--blue',
    };
@endphp

<div {{ $attributes->merge(['class' => 'lms-stat-card card-3d '.$toneClass]) }}>
    <div class="lms-stat-card__content">
        <p class="lms-stat-card__label">{{ $label }}</p>
        <p class="lms-stat-card__value @if($animate) counter @endif" @if($animate) data-value="{{ $value }}" @endif>
            @if($animate)
                0
            @else
                {{ $value }}
            @endif
            @if($suffix)
                <span class="lms-stat-card__suffix">{{ $suffix }}</span>
            @endif
        </p>
        @if($hint)
            <p class="lms-stat-card__hint">{{ $hint }}</p>
        @endif
    </div>
    <div class="lms-stat-card__icon">
        <x-lms-icon :name="$icon" class="w-5 h-5" />
    </div>
</div>
