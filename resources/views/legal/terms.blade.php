<x-guest-layout>
    <x-slot:title>{{ __('lms.legal.terms') }}</x-slot:title>
    <x-lms-public-shell>
        <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="lms-public-card__logo">
        <h1>{{ __('lms.legal.terms') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('lms.app_name') }}</p>
        <div class="mt-6 prose prose-sm text-slate-600 space-y-4">
            <p>{{ __('lms.legal.terms_p1') }}</p>
            <p>{{ __('lms.legal.terms_p2') }}</p>
            <p>{{ __('lms.legal.terms_p3') }}</p>
            <p>{{ __('lms.legal.terms_p4') }}</p>
        </div>
        <a href="{{ url('/') }}" class="inline-block mt-8 text-sm font-medium text-brand-600 hover:text-brand-700 transition">← {{ __('lms.app_name') }}</a>
    </x-lms-public-shell>
</x-guest-layout>
