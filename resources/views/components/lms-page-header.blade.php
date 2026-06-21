@props(['title', 'subtitle' => null, 'backUrl' => null, 'backLabel' => null, 'breadcrumbs' => [], 'badge' => null])

@if(!empty($breadcrumbs))
    <x-lms-breadcrumb :items="$breadcrumbs" class="lms-page-header__breadcrumb" />
@endif

<header {{ $attributes->merge(['class' => 'lms-page-header']) }}>
    <div class="lms-page-header__main">
        <div class="lms-page-header__content">
            @if($badge)
                <span class="lms-page-header__badge">{{ $badge }}</span>
            @endif
            <h1 class="lms-page-header__title">{{ $title }}</h1>
            @if($subtitle)
                <p class="lms-page-header__subtitle">{{ $subtitle }}</p>
            @endif
            <div class="lms-page-header__accent" aria-hidden="true"></div>
        </div>
        @if(isset($actions) || $backUrl)
            <div class="lms-page-header__toolbar">
                @if($backUrl)
                    <a href="{{ $backUrl }}" class="lms-btn-secondary">{{ $backLabel ?? __('lms.back') }}</a>
                @endif
                @isset($actions)
                    {{ $actions }}
                @endisset
            </div>
        @endif
    </div>
</header>
