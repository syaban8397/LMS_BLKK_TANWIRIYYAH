@props(['status', 'type' => 'class'])

@php
    [$variant, $label] = match ($type) {
        'approval' => match ($status) {
            'approved' => ['success', __('lms.common.approved')],
            'rejected' => ['danger', __('lms.common.rejected')],
            default => ['warning', __('lms.common.pending')],
        },
        'program' => $status === 'active'
            ? ['success', __('lms.active')]
            : ['info', __('lms.inactive')],
        'boolean' => ($status || $status === 1 || $status === '1')
            ? ['success', __('lms.active')]
            : ['info', __('lms.inactive')],
        default => match ($status) {
            'draft' => ['warning', __('lms.common.draft')],
            'active' => ['success', __('lms.active')],
            'completed' => ['info', __('lms.common.completed')],
            'cancelled' => ['danger', __('lms.common.cancelled')],
            default => ['info', ucfirst((string) $status)],
        },
    };
@endphp

<x-ds.badge :variant="$variant">{{ $label }}</x-ds.badge>
