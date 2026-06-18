@props(['title' => null, 'meta' => null])

<div {{ $attributes->merge(['class' => 'lms-surface-card overflow-hidden']) }}>
    @if($title || $meta)
        <div class="lms-card-header">
            @if($title)
                <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $title }}</h3>
            @endif
            @if($meta)
                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $meta }}</span>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
