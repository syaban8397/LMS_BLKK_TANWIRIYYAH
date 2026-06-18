@props(['items' => []])

@if (! empty($items))
    <nav {{ $attributes->merge(['class' => 'lms-breadcrumb']) }} aria-label="{{ __('lms.common.breadcrumb') }}">
        @foreach ($items as $index => $item)
            @if ($index > 0)
                <span class="lms-breadcrumb__sep" aria-hidden="true">/</span>
            @endif
            <span class="lms-breadcrumb__item">
                @if (! empty($item['url']) && $index < count($items) - 1)
                    <a href="{{ $item['url'] }}" class="lms-breadcrumb__link">{{ $item['label'] }}</a>
                @else
                    <span class="lms-breadcrumb__current" @if($index === count($items) - 1) aria-current="page" @endif>{{ $item['label'] }}</span>
                @endif
            </span>
        @endforeach
    </nav>
@endif
