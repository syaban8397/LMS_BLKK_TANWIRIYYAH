@props([
    'variant' => 'default',
    'class' => '',
])

@php
    $src = asset('storage/images/Logo.png');
    $alt = $lmsAppDisplayName ?? __('lms.app_name');

    $classes = match ($variant) {
        'appbar' => 'lms-brand-logo lms-brand-logo--appbar ' . $class,
        'sidebar' => 'lms-brand-logo lms-brand-logo--sidebar ' . $class,
        'sidebar-mark' => 'lms-brand-logo lms-brand-logo--sidebar-mark ' . $class,
        'auth' => 'lms-brand-logo lms-brand-logo--auth ' . $class,
        'public' => 'lms-brand-logo lms-brand-logo--public ' . $class,
        'loader' => 'lms-brand-logo lms-brand-logo--loader ' . $class,
        default => 'lms-brand-logo ' . $class,
    };
@endphp

<img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => trim($classes)]) }}>
