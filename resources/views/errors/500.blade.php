<x-guest-layout>
    <x-slot:title>{{ __('lms.errors_page.500_title') }}</x-slot:title>
    <div class="min-h-screen bg-slate-50 flex items-center justify-center px-4">
        <div class="fixed top-4 right-4 z-50"><x-locale-switcher /></div>
        <div class="max-w-md w-full text-center">
            <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-16 w-auto mx-auto mb-6">
            <p class="text-6xl font-extrabold text-red-600">500</p>
            <h1 class="mt-4 text-2xl font-bold text-slate-800">{{ __('lms.errors_page.500_title') }}</h1>
            <p class="mt-2 text-slate-500">{{ __('lms.errors_page.500_desc') }}</p>
            <a href="{{ url('/') }}" class="inline-block mt-8 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                {{ __('lms.errors_page.back_home') }}
            </a>
        </div>
    </div>
</x-guest-layout>
