@php
    $loaderLogo = asset('storage/images/Logo.png');
@endphp

<div id="lms-page-loader"
     class="lms-page-loader"
     role="status"
     aria-live="polite"
     aria-label="{{ __('lms.loading') }}"
     aria-hidden="true"
     data-min-show="60">
    <div class="lms-page-loader__overlay"></div>
    <div class="lms-page-loader__panel">
        <div class="lms-page-loader__orb lms-page-loader__orb--outer"></div>
        <div class="lms-page-loader__orb lms-page-loader__orb--mid"></div>
        <div class="lms-page-loader__core">
            <div class="lms-page-loader__logo">
                <img src="{{ $loaderLogo }}" alt="{{ __('lms.app_name') }}" class="lms-page-loader__logo-img" width="56" height="56">
            </div>
            <div class="lms-page-loader__spinner"></div>
        </div>
        <p class="lms-page-loader__text">{{ __('lms.loading') }}<span class="lms-page-loader__dots"></span></p>
    </div>
</div>
