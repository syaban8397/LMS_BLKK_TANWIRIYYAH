@props(['class' => '', 'compact' => false])



@php

    $current = app()->getLocale();

@endphp



<div {{ $attributes->merge(['class' => 'lms-locale-switcher inline-flex items-center rounded-lg border border-slate-200 dark:border-slate-600 overflow-hidden text-xs font-semibold shadow-sm ' . $class]) }}

     data-lms-no-loader

     role="group"

     aria-label="{{ __('lms.language') }}">

    <a href="{{ route('locale.switch', 'id') }}"

       data-lms-locale="id"

       class="lms-locale-switcher__btn px-2.5 py-1.5 transition {{ $current === 'id' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300' }}"

       aria-current="{{ $current === 'id' ? 'true' : 'false' }}"

       title="{{ __('lms.lang_id') }}">ID</a>

    <a href="{{ route('locale.switch', 'en') }}"

       data-lms-locale="en"

       class="lms-locale-switcher__btn px-2.5 py-1.5 transition {{ $current === 'en' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300' }}"

       aria-current="{{ $current === 'en' ? 'true' : 'false' }}"

       title="{{ __('lms.lang_en') }}">EN</a>

</div>

