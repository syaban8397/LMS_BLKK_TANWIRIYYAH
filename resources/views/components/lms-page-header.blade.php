@props(['title', 'subtitle' => null, 'backUrl' => null, 'backLabel' => null, 'breadcrumbs' => []])

@if(!empty($breadcrumbs))
    <x-lms-breadcrumb :items="$breadcrumbs" class="mb-3" />
@endif

<div {{ $attributes->merge(['class' => 'lms-page-header page-header flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4']) }}>
    <div class="min-w-0">
        <h1 class="lms-page-header__title">{{ $title }}</h1>
        @if($subtitle)
            <p class="lms-page-header__subtitle">{{ $subtitle }}</p>
        @endif
        <div class="lms-page-header__accent" aria-hidden="true"></div>
    </div>
    @if(isset($actions) || $backUrl)
        <div class="flex items-center gap-2 shrink-0 sm:pt-1">
            @if($backUrl)
                <a href="{{ $backUrl }}" class="lms-btn-secondary">{{ $backLabel ?? __('lms.back') }}</a>
            @endif
            @isset($actions)
                {{ $actions }}
            @endisset
        </div>
    @endif
</div>
