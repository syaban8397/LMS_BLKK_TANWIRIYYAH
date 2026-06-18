@props(['title', 'subtitle' => null, 'backUrl' => null, 'backLabel' => null])

<div {{ $attributes->merge(['class' => 'page-header flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4']) }}>
    <div class="min-w-0">
        <h1>{{ $title }}</h1>
        @if($subtitle)
            <p>{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions) || $backUrl)
        <div class="flex items-center gap-2 shrink-0">
            @if($backUrl)
                <a href="{{ $backUrl }}" class="lms-btn-secondary">{{ $backLabel ?? __('lms.back') }}</a>
            @endif
            @isset($actions)
                {{ $actions }}
            @endisset
        </div>
    @endif
</div>
