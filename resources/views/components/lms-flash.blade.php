@props(['type' => 'success'])

@php
    $classes = match ($type) {
        'error', 'danger' => 'lms-flash lms-flash--error',
        'warning' => 'lms-flash lms-flash--warning',
        'info' => 'lms-flash lms-flash--info',
        default => 'lms-flash lms-flash--success',
    };
@endphp

@if ($slot->isNotEmpty())
    <div {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </div>
@endif
