@props(['title', 'subtitle' => null, 'backUrl' => null, 'backLabel' => '← Back'])

<div {{ $attributes->merge(['class' => 'page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3']) }}>
    <div>
        <h1 class="text-gradient-brand">{{ $title }}</h1>
        @if($subtitle)
            <p>{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions) || $backUrl)
        <div class="flex items-center gap-2 shrink-0">
            @if($backUrl)
                <a href="{{ $backUrl }}" class="lms-btn-secondary">{{ $backLabel }}</a>
            @endif
            @isset($actions)
                {{ $actions }}
            @endisset
        </div>
    @endif
</div>
