@props([
    'icon' => 'document',
    'tone' => 'blue',
    'title',
    'subtitle' => null,
    'meta' => null,
    'metaAccent' => null,
    'href' => null,
])

@php
    $toneClass = match ($tone) {
        'green' => 'lms-feed-item--green',
        'amber' => 'lms-feed-item--amber',
        'indigo', 'purple' => 'lms-feed-item--indigo',
        default => 'lms-feed-item--blue',
    };
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => 'lms-feed-item '.$toneClass.($href ? ' lms-feed-item--link' : '')]) }}
>
    <span class="lms-feed-item__icon" aria-hidden="true">
        <x-lms-icon :name="$icon" class="w-4 h-4" />
    </span>
    <span class="lms-feed-item__content">
        <span class="lms-feed-item__title">{{ $title }}</span>
        @if($subtitle)
            <span class="lms-feed-item__subtitle">{{ $subtitle }}</span>
        @endif
    </span>
    @if($meta || $metaAccent)
        <span class="lms-feed-item__meta">
            @if($meta)
                <span class="lms-feed-item__meta-line">{{ $meta }}</span>
            @endif
            @if($metaAccent)
                <span class="lms-feed-item__meta-accent">{{ $metaAccent }}</span>
            @endif
        </span>
    @endif
</{{ $tag }}>
