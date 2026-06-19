@props(['class' => '', 'compact' => false])

@php
    $current = app()->getLocale();
@endphp

<div {{ $attributes->merge(['class' => 'lms-locale-switcher inline-flex items-center rounded-lg border overflow-hidden text-xs font-semibold shadow-sm ' . $class]) }}
     data-lms-no-loader
     role="group"
     aria-label="{{ __('lms.language') }}">
    <a href="{{ route('locale.switch', 'id') }}"
       data-lms-locale="id"
       class="lms-locale-switcher__btn px-2.5 py-1.5 transition {{ $current === 'id' ? 'lms-locale-switcher__btn--active bg-brand-600 text-white' : '' }}"
       aria-current="{{ $current === 'id' ? 'true' : 'false' }}"
       title="{{ __('lms.lang_id') }}">ID</a>
    <a href="{{ route('locale.switch', 'en') }}"
       data-lms-locale="en"
       class="lms-locale-switcher__btn px-2.5 py-1.5 transition {{ $current === 'en' ? 'lms-locale-switcher__btn--active bg-brand-600 text-white' : '' }}"
       aria-current="{{ $current === 'en' ? 'true' : 'false' }}"
       title="{{ __('lms.lang_en') }}">EN</a>
</div>
