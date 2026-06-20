@props(['icon' => 'inbox', 'title', 'description' => null])

<div {{ $attributes->merge(['class' => 'ds-empty lms-empty-state']) }}>
    <div class="ds-empty__icon lms-empty-state__icon">
        <x-lms-icon :name="$icon" class="w-8 h-8" />
    </div>
    <p class="ds-empty__title lms-empty-state__title">{{ $title }}</p>
    @if($description)
        <p class="ds-empty__desc lms-empty-state__desc">{{ $description }}</p>
    @endif
    @if(isset($slot) && ! $slot->isEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
