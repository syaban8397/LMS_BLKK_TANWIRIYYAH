<x-guest-layout>
    <x-slot:title>{{ __('lms.legal.help') }}</x-slot:title>
    <div class="min-h-screen bg-slate-50 py-12 px-4">
        <div class="fixed top-4 right-4 z-50"><x-locale-switcher /></div>
        <div class="max-w-3xl mx-auto bg-white rounded-xl border border-slate-200 shadow-sm p-8">
            <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-14 w-auto mb-6">
            <h1 class="text-2xl font-bold text-slate-800">{{ __('lms.legal.help') }}</h1>
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
            <a href="{{ url('/') }}" class="inline-block mt-8 text-sm text-brand-600 hover:underline">← {{ __('lms.app_name') }}</a>
        </div>
    </div>
</x-guest-layout>
