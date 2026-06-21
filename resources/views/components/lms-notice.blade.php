@props(['tone' => 'info', 'title' => null, 'icon' => null])

@php
    [$toneClass, $defaultIcon] = match ($tone) {
        'success' => ['lms-notice--success', 'check-circle'],
        'warning' => ['lms-notice--warning', 'warning'],
        'danger' => ['lms-notice--danger', 'x-circle'],
        default => ['lms-notice--info', 'info'],
    };
    $iconName = $icon ?? $defaultIcon;
@endphp

<div {{ $attributes->merge(['class' => 'lms-notice '.$toneClass]) }}>
    <span class="lms-notice__icon" aria-hidden="true">
        <x-lms-icon :name="$iconName" class="w-5 h-5" />
    </span>
    <div class="lms-notice__body">
        @if($title)
            <p class="lms-notice__title">{{ $title }}</p>
        @endif
        @if($slot->isNotEmpty())
            <div class="lms-notice__content">{{ $slot }}</div>
        @endif
    </div>
</div>
