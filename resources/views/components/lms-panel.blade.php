@props(['flush' => false, 'pad' => true, 'title' => null, 'meta' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'lms-panel card-3d'.($flush ? ' lms-panel--flush' : '').(!$pad ? ' lms-panel--no-pad' : '')]) }}>
    @if(isset($header) || isset($title))
        <header class="lms-panel__header">
            @isset($header)
                {{ $header }}
            @else
                <div class="lms-panel__header-main">
                    @if(isset($icon))
                        <span class="lms-panel__header-icon" aria-hidden="true">
                            <x-lms-icon :name="$icon" class="w-4 h-4" />
                        </span>
                    @endif
                    <div>
                        @if(isset($title))
                            <h3 class="lms-panel__title">{{ $title }}</h3>
                        @endif
                        @if(isset($meta))
                            <p class="lms-panel__meta">{{ $meta }}</p>
                        @endif
                    </div>
                </div>
            @endisset
            @isset($headerActions)
                <div class="lms-panel__header-actions">{{ $headerActions }}</div>
            @endisset
        </header>
    @endif
    <div class="lms-panel__body">{{ $slot }}</div>
    @isset($footer)
        <footer class="lms-panel__footer">{{ $footer }}</footer>
    @endisset
</div>
