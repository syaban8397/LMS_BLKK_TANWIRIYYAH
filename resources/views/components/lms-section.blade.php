@props(['title' => null, 'description' => null, 'icon' => null, 'compact' => false])

<section {{ $attributes->merge(['class' => 'lms-section'.($compact ? ' lms-section--compact' : '')]) }}>
    @if($title || isset($headerActions))
        <header class="lms-section__header">
            <div class="lms-section__heading">
                @if($icon)
                    <span class="lms-section__icon" aria-hidden="true">
                        <x-lms-icon :name="$icon" class="w-4 h-4" />
                    </span>
                @endif
                <div class="lms-section__titles">
                    @if($title)
                        <h2 class="lms-section__title">{{ $title }}</h2>
                    @endif
                    @if($description)
                        <p class="lms-section__description">{{ $description }}</p>
                    @endif
                </div>
            </div>
            @isset($headerActions)
                <div class="lms-section__actions">{{ $headerActions }}</div>
            @endisset
        </header>
    @endif
    <div class="lms-section__body">{{ $slot }}</div>
</section>
