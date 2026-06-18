@props(['title', 'description' => null, 'icon' => '⚠️'])

<div {{ $attributes->merge(['class' => 'lms-error-state']) }} role="alert">
    <div class="lms-error-state__icon">{{ $icon }}</div>
    <p class="lms-error-state__title">{{ $title }}</p>
    @if ($description)
        <p class="lms-error-state__desc">{{ $description }}</p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
