@props([
    'value' => 0,
    'max' => 100,
    'label' => null,
    'meta' => null,
    'tone' => 'primary',
])

@php
    $pct = $max > 0 ? min(100, max(0, round(($value / $max) * 100))) : 0;
    $fillClass = match ($tone) {
        'success' => 'lms-progress__fill lms-progress__fill--success',
        'warning' => 'lms-progress__fill lms-progress__fill--warning',
        'purple' => 'lms-progress__fill lms-progress__fill--purple',
        default => 'lms-progress__fill',
    };
@endphp

<div {{ $attributes->merge(['class' => 'lms-progress-wrap']) }}>
    @if ($label || $meta)
        <div class="lms-progress-meta">
            @if ($label)<span>{{ $label }}</span>@endif
            @if ($meta)<span>{{ $meta }}</span>@else<span>{{ $value }}/{{ $max }}</span>@endif
        </div>
    @endif
    <div class="lms-progress" role="progressbar" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
        <div class="{{ $fillClass }}" style="width: {{ $pct }}%"></div>
    </div>
</div>
