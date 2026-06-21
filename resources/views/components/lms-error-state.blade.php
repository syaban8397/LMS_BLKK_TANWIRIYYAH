@props(['title', 'description' => null, 'icon' => 'warning'])

<div {{ $attributes->merge(['class' => 'lms-error-state']) }} role="alert">
    <div class="lms-error-state__icon" aria-hidden="true">
        <x-lms-icon :name="$icon" class="w-6 h-6" />
    </div>
    <p class="lms-error-state__title">{{ $title }}</p>
    @if ($description)
        <p class="lms-error-state__desc">{{ $description }}</p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
