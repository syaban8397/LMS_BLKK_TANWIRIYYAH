<x-guest-layout>
    <x-slot:title>{{ __('lms.errors_page.403_title') }}</x-slot:title>
    <x-lms-public-shell centered>
        <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="lms-public-card__logo">
        <p class="lms-error-code lms-error-code--warning">403</p>
        <h1 class="mt-4">{{ __('lms.errors_page.403_title') }}</h1>
        <p class="mt-2 text-slate-500">{{ __('lms.errors_page.403_desc') }}</p>
        <a href="{{ url('/') }}" class="inline-block mt-8 lms-btn-primary px-6 py-3">
            {{ __('lms.errors_page.back_home') }}
        </a>
    </x-lms-public-shell>
</x-guest-layout>
