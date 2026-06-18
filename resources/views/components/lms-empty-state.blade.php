@props(['icon' => '📭', 'title', 'description' => null])

<x-ds.empty-state :icon="$icon" :title="$title" :description="$description" {{ $attributes }}>
    {{ $slot }}
</x-ds.empty-state>
