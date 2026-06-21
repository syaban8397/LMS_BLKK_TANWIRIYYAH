<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-lms-brand-head :title="__('lms.certificate.verify_title')" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="lms-verify-body antialiased">
<x-lms-public-shell centered>
<x-lms-page-loader />

    <div class="lms-verify-card">
        <div class="text-center mb-6">
            <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-14 w-auto mx-auto mb-4">
            <div class="lms-public-card__icon lms-public-card__icon--success">
                <x-lms-icon name="check-circle" />
            </div>
            <h1 class="text-xl text-slate-900">{{ __('lms.certificate.verify_valid') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('lms.certificate.verify_registered') }}</p>
        </div>
        <div class="lms-verify-details space-y-3 text-sm">
            <div class="flex justify-between gap-4 border-b border-slate-200/80 pb-2">
                <span class="text-slate-500 shrink-0">{{ __('lms.report.name') }}</span>
                <span class="font-semibold text-slate-900 text-right">{{ $certificate->participant->name }}</span>
            </div>
            <div class="flex justify-between gap-4 border-b border-slate-200/80 pb-2">
                <span class="text-slate-500 shrink-0">{{ __('lms.certificate.program_label') }}</span>
                <span class="font-medium text-slate-900 text-right">{{ $certificate->class->program->name }}</span>
            </div>
            <div class="flex justify-between gap-4 border-b border-slate-200/80 pb-2">
                <span class="text-slate-500 shrink-0">{{ __('lms.certificate.class_label') }}</span>
                <span class="font-medium text-slate-900 text-right">{{ $certificate->class->title }}</span>
            </div>
            <div class="flex justify-between gap-4 border-b border-slate-200/80 pb-2">
                <span class="text-slate-500 shrink-0">{{ __('lms.certificate.certificate_number') }}</span>
                <span class="font-mono font-semibold text-indigo-700 text-right">{{ $certificate->certificate_number }}</span>
            </div>
            <div class="flex justify-between gap-4">
                <span class="text-slate-500 shrink-0">{{ __('lms.certificate.issued_date') }}</span>
                <span class="font-medium text-slate-900">{{ $certificate->issued_at->format('d M Y') }}</span>
            </div>
        </div>
        <div class="mt-6 flex flex-col gap-2 items-center">
            <x-locale-switcher class="justify-center" />
            <a href="{{ url('/') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">{{ __('lms.app_name') }}</a>
        </div>
    </div>
</x-lms-public-shell>
</body>
</html>
