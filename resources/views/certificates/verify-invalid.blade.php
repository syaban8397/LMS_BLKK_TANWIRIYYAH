<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-lms-brand-head :title="__('lms.certificate.verify_invalid')" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="lms-verify-body antialiased">
<x-lms-public-shell centered>
<div class="lms-verify-card text-center">
        <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-16 w-auto mx-auto mb-4">
        <div class="lms-public-card__icon lms-public-card__icon--danger">
            <x-lms-icon name="x-circle" />
        </div>
        <h1 class="text-xl font-bold text-slate-800">{{ __('lms.certificate.verify_invalid') }}</h1>
        <p class="text-sm text-slate-500 mt-2">{{ __('lms.certificate.verify_invalid_desc') }}</p>
        <p class="mt-4 text-xs font-mono text-slate-400 bg-slate-50 rounded-lg px-3 py-2 border border-slate-100">{{ $number }}</p>
        <div class="mt-6 flex flex-col gap-2 items-center">
            <x-locale-switcher class="justify-center" />
            <a href="{{ url('/') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700 transition">{{ __('lms.app_name') }}</a>
        </div>
    </div>
</x-lms-public-shell>
</body>
</html>
