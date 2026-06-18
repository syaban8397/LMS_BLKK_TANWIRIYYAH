@props(['type' => 'success'])

<x-ds.toast :type="$type" {{ $attributes }}>
    {{ $slot }}
</x-ds.toast>
