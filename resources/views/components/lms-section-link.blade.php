@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'lms-section-link']) }}>
    {{ $slot }}
</a>
