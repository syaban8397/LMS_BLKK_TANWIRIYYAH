@props([
    'variant' => 'primary',
    'type' => 'button',
    'tag' => 'button',
])

@php
    $variantClass = match ($variant) {
        'secondary' => 'ds-btn ds-btn--secondary',
        'outline' => 'ds-btn ds-btn--outline',
        'danger' => 'ds-btn ds-btn--danger',
        default => 'ds-btn ds-btn--primary',
    };
@endphp

@if ($tag === 'a')
    <a {{ $attributes->merge(['class' => $variantClass]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $variantClass]) }}>{{ $slot }}</button>
@endif
