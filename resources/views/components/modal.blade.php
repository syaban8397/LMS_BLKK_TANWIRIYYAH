@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl',
])

<x-ds.modal :name="$name" :show="$show" :maxWidth="$maxWidth" {{ $attributes }}>
    {{ $slot }}
</x-ds.modal>
