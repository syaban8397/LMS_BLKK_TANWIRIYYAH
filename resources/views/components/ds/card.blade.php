@props(['title' => null, 'meta' => null])

<div {{ $attributes->merge(['class' => 'ds-card lms-surface-card card-3d overflow-hidden']) }}>
    @if($title || $meta)
        <div class="ds-card__header lms-card-header">
            @if($title)
                <h3 class="ds-card__title text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $title }}</h3>
            @endif
            @if($meta)
                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $meta }}</span>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
