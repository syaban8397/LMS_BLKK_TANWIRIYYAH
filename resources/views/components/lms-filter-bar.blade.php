@props(['action' => null, 'method' => 'GET', 'resetUrl' => null])

<form
    method="{{ $method }}"
    action="{{ $action ?? url()->current() }}"
    {{ $attributes->merge(['class' => 'lms-filter-bar']) }}
>
    <div class="lms-filter-bar__fields">
        {{ $slot }}
    </div>
    <div class="lms-filter-bar__actions">
        <x-ds.button type="submit" variant="primary">{{ __('lms.common.search') }}</x-ds.button>
        @if($resetUrl)
            <x-ds.button tag="a" :href="$resetUrl" variant="secondary">{{ __('lms.common.reset') }}</x-ds.button>
        @endif
    </div>
</form>
