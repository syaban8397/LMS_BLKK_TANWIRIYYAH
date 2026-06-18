<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ __('lms.welcome.meta_desc') }}">
    <meta name="theme-color" content="#004071">
    <title>@if(!empty($title)){{ $title }} — @endif{{ $lmsAppDisplayName ?? __('lms.app_name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased m-0 p-0 overflow-x-hidden min-h-screen flex flex-col bg-slate-50 dark:bg-slate-900">

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer class="py-5 px-4 text-center text-xs text-slate-500 dark:text-slate-400 border-t border-slate-200/80 dark:border-slate-700/60">
        <p>© {{ date('Y') }} {{ $lmsAppDisplayName ?? __('lms.app_name') }} · {{ __('lms.welcome.powered_by') }}</p>
        <p class="mt-2">
            <a href="{{ route('legal.help') }}" class="hover:text-brand-600 dark:hover:text-brand-400 transition">{{ __('lms.welcome.help') }}</a>
            <span class="mx-2">·</span>
            <a href="{{ route('legal.privacy') }}" class="hover:text-brand-600 dark:hover:text-brand-400 transition">{{ __('lms.welcome.privacy') }}</a>
            <span class="mx-2">·</span>
            <a href="{{ route('legal.terms') }}" class="hover:text-brand-600 dark:hover:text-brand-400 transition">{{ __('lms.welcome.terms') }}</a>
        </p>
    </footer>

</body>
</html>
