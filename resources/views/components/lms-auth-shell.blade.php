@props([
    'wide' => false,
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'lms-auth-shell'.($wide ? ' lms-auth-shell--wide' : '')]) }}>
    <aside class="lms-auth-shell__brand">
        <div class="lms-auth-shell__brand-inner">
            <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ $lmsAppDisplayName ?? __('lms.app_name') }}" class="lms-auth-shell__logo" width="120" height="48">
            <p class="lms-auth-shell__app-name">{{ $lmsAppDisplayName ?? __('lms.app_name') }}</p>
            <p class="lms-auth-shell__tagline">{{ __('lms.tagline') }}</p>
            <p class="lms-auth-shell__desc">{{ __('lms.welcome.meta_desc') }}</p>
        </div>
    </aside>

    <div class="lms-auth-shell__main">
        <div @class([
            'lms-auth-card',
            'lms-auth-card--register' => $wide,
            'lms-auth-card--login' => ! $wide,
            'p-8 md:p-10',
        ])>
            @if($title)
                <div class="lms-auth-card__intro text-center mb-8">
                    <h2 class="lms-auth-card__title">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="lms-auth-card__subtitle">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>
