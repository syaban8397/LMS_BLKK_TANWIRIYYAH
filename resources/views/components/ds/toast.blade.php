@props(['type' => 'success'])

@php
    $classes = match ($type) {
        'error', 'danger' => 'ds-toast lms-flash ds-toast--error lms-flash--error',
        'warning' => 'ds-toast lms-flash ds-toast--warning lms-flash--warning',
        'info' => 'ds-toast lms-flash ds-toast--info lms-flash--info',
        default => 'ds-toast lms-flash ds-toast--success lms-flash--success',
    };
@endphp

@if ($slot->isNotEmpty())
    <div {{ $attributes->merge(['class' => $classes]) }} role="status">
        {{ $slot }}
    </div>
@endif
