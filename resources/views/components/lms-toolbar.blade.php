@props(['align' => 'end'])

<div {{ $attributes->merge(['class' => 'lms-toolbar lms-toolbar--'.$align]) }}>
    {{ $slot }}
</div>
