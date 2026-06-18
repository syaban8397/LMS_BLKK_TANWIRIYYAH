@props(['title' => null, 'meta' => null])

<x-ds.card :title="$title" :meta="$meta" {{ $attributes }}>
    {{ $slot }}
</x-ds.card>
