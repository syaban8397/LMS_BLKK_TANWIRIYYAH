<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('lms.certificate.verify_title') }} — {{ __('lms.app_name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-slate-50 via-indigo-50/30 to-slate-100 dark:from-slate-950 dark:via-slate-900 dark:to-indigo-950/40">

<x-lms-page-loader />

    <div class="max-w-lg w-full p-8 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-3d-lg">
        <div class="text-center mb-6">
            <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-14 w-auto mx-auto mb-4 drop-shadow-sm">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 text-2xl mb-3 shadow-sm">✓</div>
            <h1 class="text-xl font-bold text-slate-900 dark:text-slate-50">{{ __('lms.certificate.verify_valid') }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('lms.certificate.verify_registered') }}</p>
        </div>
        <div class="space-y-3 text-sm rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 p-4">
            <div class="flex justify-between gap-4 border-b border-slate-200/80 dark:border-slate-700 pb-2">
                <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('lms.report.name') }}</span>
                <span class="font-semibold text-slate-900 dark:text-slate-100 text-right">{{ $certificate->participant->name }}</span>
            </div>
            <div class="flex justify-between gap-4 border-b border-slate-200/80 dark:border-slate-700 pb-2">
                <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('lms.certificate.program_label') }}</span>
                <span class="font-medium text-slate-900 dark:text-slate-100 text-right">{{ $certificate->class->program->name }}</span>
            </div>
            <div class="flex justify-between gap-4 border-b border-slate-200/80 dark:border-slate-700 pb-2">
                <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('lms.certificate.class_label') }}</span>
                <span class="font-medium text-slate-900 dark:text-slate-100 text-right">{{ $certificate->class->title }}</span>
            </div>
            <div class="flex justify-between gap-4 border-b border-slate-200/80 dark:border-slate-700 pb-2">
                <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('lms.certificate.certificate_number') }}</span>
                <span class="font-mono font-semibold text-indigo-700 dark:text-indigo-300 text-right">{{ $certificate->certificate_number }}</span>
            </div>
            <div class="flex justify-between gap-4">
                <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('lms.certificate.issued_date') }}</span>
                <span class="font-medium text-slate-900 dark:text-slate-100">{{ $certificate->issued_at->format('d M Y') }}</span>
            </div>
        </div>
        <div class="mt-6 flex flex-col gap-2">
            <x-locale-switcher class="justify-center" />
            <a href="{{ url('/') }}" class="text-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">{{ __('lms.app_name') }}</a>
        </div>
    </div>
</body>
</html>
