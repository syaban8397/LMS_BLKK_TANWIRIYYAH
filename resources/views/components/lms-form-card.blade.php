@props(['title' => null, 'icon' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'lms-form-card card-3d']) }}>
    @if($title)
        <div class="lms-form-card__header">
            @if($icon)
                <span class="lms-form-card__icon" aria-hidden="true">
                    <x-lms-icon :name="$icon" class="w-4 h-4" />
                </span>
            @endif
            <div>
                <h3 class="lms-form-card__title">{{ $title }}</h3>
                @if($description)
                    <p class="lms-form-card__description">{{ $description }}</p>
                @endif
            </div>
        </div>
    @endif
    <div class="lms-form-card__body">{{ $slot }}</div>
</div>
