@props(['centered' => false])

<div {{ $attributes->merge(['class' => 'lms-public-page'.($centered ? ' lms-public-page--centered' : '')]) }}>
    <div class="lms-public-page__toolbar">
        <x-locale-switcher />
    </div>
    <div class="lms-public-card">
        {{ $slot }}
    </div>
</div>
