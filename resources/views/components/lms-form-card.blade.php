@props(['title' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'lms-form-card']) }}>
    @if($title)
        <div class="lms-form-card__header">
            @if($icon)<span aria-hidden="true">{{ $icon }}</span>@endif
            <h3>{{ $title }}</h3>
        </div>
    @endif
    <div class="lms-form-card__body">{{ $slot }}</div>
</div>
