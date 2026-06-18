@props(['variant' => 'info'])

@php
    $classes = match ($variant) {
        'success' => 'ds-badge ds-badge--success',
        'warning' => 'ds-badge ds-badge--warning',
        'danger' => 'ds-badge ds-badge--danger',
        default => 'ds-badge ds-badge--info',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</span>
