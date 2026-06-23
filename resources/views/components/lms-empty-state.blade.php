@props(['icon' => 'inbox', 'title' => null, 'message' => null, 'description' => null])

@php
    $resolvedTitle = $title ?? $message ?? __('lms.no_data');
@endphp

<x-ds.empty-state :icon="$icon" :title="$resolvedTitle" :description="$description" {{ $attributes }}>
    {{ $slot }}
</x-ds.empty-state>
