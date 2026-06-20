<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ __('lms.welcome.meta_desc') }}">
    <meta name="theme-color" content="#004071">
    <x-lms-brand-head :title="$title ?? null" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased m-0 p-0 overflow-x-hidden min-h-screen flex flex-col lms-guest-body">

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer class="lms-guest-footer">
        <p>© {{ date('Y') }} {{ $lmsAppDisplayName ?? __('lms.app_name') }} · {{ __('lms.welcome.powered_by') }}</p>
        <p class="lms-guest-footer__links">
            <a href="{{ route('legal.help') }}">{{ __('lms.welcome.help') }}</a>
            <span aria-hidden="true">·</span>
            <a href="{{ route('legal.privacy') }}">{{ __('lms.welcome.privacy') }}</a>
            <span aria-hidden="true">·</span>
            <a href="{{ route('legal.terms') }}">{{ __('lms.welcome.terms') }}</a>
        </p>
    </footer>

    <script>
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-lms-password-target]');
            if (!btn) return;
            var input = document.getElementById(btn.getAttribute('data-lms-password-target'));
            if (!input) return;
            var show = btn.querySelector('.lms-password-toggle__show');
            var hide = btn.querySelector('.lms-password-toggle__hide');
            var visible = input.type === 'text';
            input.type = visible ? 'password' : 'text';
            if (show) show.classList.toggle('hidden', !visible);
            if (hide) hide.classList.toggle('hidden', visible);
        });
        setTimeout(function () {
            document.querySelectorAll('.lms-flash').forEach(function (el) {
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 500);
            });
        }, 3000);
    </script>
</body>
</html>
