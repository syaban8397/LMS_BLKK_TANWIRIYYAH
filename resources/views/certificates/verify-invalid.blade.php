<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('lms.certificate.verify_invalid') }} — {{ __('lms.app_name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased min-h-screen bg-slate-50 flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center">
        <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-16 w-auto mx-auto mb-4">
        <div class="text-5xl mb-3">❌</div>
        <h1 class="text-xl font-bold text-slate-800">{{ __('lms.certificate.verify_invalid') }}</h1>
        <p class="text-sm text-slate-500 mt-2">{{ __('lms.certificate.verify_invalid_desc') }}</p>
        <p class="mt-4 text-xs font-mono text-slate-400 bg-slate-50 rounded-lg px-3 py-2">{{ $number }}</p>
        <div class="mt-6 flex flex-col gap-2">
            <x-locale-switcher class="justify-center" />
            <a href="{{ url('/') }}" class="text-sm text-brand-600 hover:underline">{{ __('lms.app_name') }}</a>
        </div>
    </div>
</body>
</html>
