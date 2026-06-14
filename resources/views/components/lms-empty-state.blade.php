@props(['icon' => '📭', 'title', 'description' => null])

<div {{ $attributes->merge(['class' => 'lms-empty-state']) }}>
    <div class="lms-empty-state__icon">{{ $icon }}</div>
    <p class="lms-empty-state__title">{{ $title }}</p>
    @if($description)
        <p class="lms-empty-state__desc">{{ $description }}</p>
    @endif
    @if(isset($slot) && ! $slot->isEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
