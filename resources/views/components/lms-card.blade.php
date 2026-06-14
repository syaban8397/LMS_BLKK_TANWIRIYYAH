@props(['title' => null, 'meta' => null])

<div {{ $attributes->merge(['class' => 'overflow-hidden']) }}>
    @if($title || $meta)
        <div class="lms-card-header">
            @if($title)
                <h3 class="font-bold text-slate-800 dark:text-slate-100">{{ $title }}</h3>
            @endif
            @if($meta)
                <span class="text-xs text-slate-400 dark:text-slate-500">{{ $meta }}</span>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
