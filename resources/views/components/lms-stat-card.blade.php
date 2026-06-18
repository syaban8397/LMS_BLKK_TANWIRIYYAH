@props(['label', 'value', 'icon' => '📊', 'tone' => 'blue'])

@php
    $toneClass = match ($tone) {
        'green' => 'lms-stat-card--green',
        'amber' => 'lms-stat-card--amber',
        'red' => 'lms-stat-card--red',
        'indigo' => 'lms-stat-card--indigo',
        default => 'lms-stat-card--blue',
    };
@endphp

<div {{ $attributes->merge(['class' => 'lms-stat-card '.$toneClass]) }}>
    <div class="lms-stat-card__content">
        <p class="lms-stat-card__label">{{ $label }}</p>
        <p class="lms-stat-card__value">{{ $value }}</p>
    </div>
    <div class="lms-stat-card__icon">{{ $icon }}</div>
</div>
