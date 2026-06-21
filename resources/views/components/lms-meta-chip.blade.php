@props(['icon' => 'info'])

<span {{ $attributes->merge(['class' => 'lms-meta-chip']) }}>
    <x-lms-icon :name="$icon" class="w-3.5 h-3.5 shrink-0" />
    <span>{{ $slot }}</span>
</span>
