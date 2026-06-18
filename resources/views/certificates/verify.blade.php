<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('lms.certificate.verify_title') }} — {{ __('lms.app_name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { background: #f8fafc; }</style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<x-lms-page-loader />

    <div class="max-w-lg w-full p-8 bg-white rounded-lg border border-slate-200 shadow-3d-lg">
        <div class="text-center mb-6">
            <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-14 w-auto mx-auto mb-4">
            <div class="text-4xl mb-2">✅</div>
            <h1 class="text-xl font-bold text-slate-800">{{ __('lms.certificate.verify_valid') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('lms.certificate.verify_registered') }}</p>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">{{ __('lms.report.name') }}</span>
                <span class="font-semibold text-slate-800">{{ $certificate->participant->name }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">{{ __('lms.certificate.program_label') }}</span>
                <span class="font-medium text-slate-800 text-right">{{ $certificate->class->program->name }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">{{ __('lms.certificate.class_label') }}</span>
                <span class="font-medium text-slate-800">{{ $certificate->class->title }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">{{ __('lms.certificate.certificate_number') }}</span>
                <span class="font-mono font-semibold text-brand-700">{{ $certificate->certificate_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">{{ __('lms.certificate.issued_date') }}</span>
                <span class="font-medium text-slate-800">{{ $certificate->issued_at->format('d M Y') }}</span>
            </div>
        </div>
        <div class="mt-6 flex flex-col gap-2">
            <x-locale-switcher class="justify-center" />
            <a href="{{ url('/') }}" class="text-center text-sm text-brand-600 hover:underline">{{ __('lms.app_name') }}</a>
        </div>
    </div>
</body>
</html>
