@props(['type' => null])

@php
    $icon = match (strtolower((string) $type)) {
        'pdf' => 'document',
        'doc', 'docx' => 'edit',
        'xls', 'xlsx' => 'chart',
        'ppt', 'pptx' => 'clipboard',
        'zip', 'rar' => 'archive',
        'jpg', 'jpeg', 'png', 'gif', 'webp' => 'image',
        'mp4', 'mov', 'avi' => 'film',
        default => 'document',
    };
@endphp

<span {{ $attributes->merge(['class' => 'lms-file-icon']) }}>
    <x-lms-icon :name="$icon" class="w-5 h-5" />
</span>
