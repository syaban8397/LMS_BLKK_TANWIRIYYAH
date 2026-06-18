@props([
    'variant' => 'view',
    'href' => null,
    'type' => 'button',
    'confirm' => null,
])

@php
    $class = 'lms-action-btn lms-action-btn--'.$variant;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</a>
@else
    <button
        type="{{ $type }}"
        @if($confirm) data-lms-confirm="{{ $confirm }}" @endif
        {{ $attributes->merge(['class' => $class]) }}
    >{{ $slot }}</button>
@endif
