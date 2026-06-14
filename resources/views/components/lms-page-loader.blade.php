@php
    $loaderLogo = asset('images/certificates/logo-blkk.png');
@endphp

<div id="lms-page-loader"
     class="lms-page-loader"
     role="status"
     aria-live="polite"
     aria-label="Memuat halaman"
     aria-hidden="true"
     data-min-show="200">
    <div class="lms-page-loader__overlay"></div>
    <div class="lms-page-loader__panel">
        <div class="lms-page-loader__orb lms-page-loader__orb--outer"></div>
        <div class="lms-page-loader__orb lms-page-loader__orb--mid"></div>
        <div class="lms-page-loader__core">
            <div class="lms-page-loader__logo">
                <img src="{{ $loaderLogo }}" alt="BLKK Tanwiriyyah" class="lms-page-loader__logo-img" width="56" height="56">
            </div>
            <div class="lms-page-loader__spinner"></div>
        </div>
        <p class="lms-page-loader__text">Memuat<span class="lms-page-loader__dots"></span></p>
    </div>
</div>
