@props(['target'])

<button type="button"
        {{ $attributes->merge(['class' => 'lms-password-toggle']) }}
        data-lms-password-target="{{ $target }}"
        aria-label="{{ __('lms.auth.password') }}">
    <x-lms-icon name="eye" class="lms-password-toggle__show w-5 h-5" />
    <x-lms-icon name="eye-off" class="lms-password-toggle__hide w-5 h-5 hidden" />
</button>
