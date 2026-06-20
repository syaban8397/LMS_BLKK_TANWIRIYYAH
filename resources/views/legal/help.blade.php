<x-guest-layout>
    <x-slot:title>{{ __('lms.legal.help') }}</x-slot:title>
    <x-lms-public-shell>
        <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="lms-public-card__logo">
        <h1>{{ __('lms.legal.help') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('lms.legal.help_subtitle') }}</p>
        <div class="mt-6 space-y-5 text-sm text-slate-600 leading-relaxed">
            <div>
                <h2 class="font-semibold text-slate-800">{{ __('lms.legal.help_register_title') }}</h2>
                <p class="mt-1">{{ __('lms.legal.help_register_desc') }}</p>
            </div>
            <div>
                <h2 class="font-semibold text-slate-800">{{ __('lms.legal.help_forgot_title') }}</h2>
                <p class="mt-1">{{ __('lms.legal.help_forgot_desc') }}</p>
            </div>
            <div>
                <h2 class="font-semibold text-slate-800">{{ __('lms.legal.help_contact_title') }}</h2>
                <p class="mt-1">{{ __('lms.legal.help_contact_desc') }}</p>
            </div>
        </div>
        <a href="{{ url('/') }}" class="inline-block mt-8 text-sm font-medium text-brand-600 hover:text-brand-700 transition">← {{ __('lms.app_name') }}</a>
    </x-lms-public-shell>
</x-guest-layout>
