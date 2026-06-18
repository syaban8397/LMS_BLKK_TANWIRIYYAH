<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #111827; }
        h1 { font-size: 16px; margin: 0 0 4px; }
        .meta { font-size: 8px; color: #6b7280; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 4px 5px; vertical-align: top; }
        th { background: #f3f4f6; font-weight: bold; }
        tr:nth-child(even) td { background: #fafafa; }
    </style>
</head>
<body>
    <h1>{{ $title ?? 'Laporan' }}</h1>
    <div class="meta">{{ $appName ?? config('app.name') }} • {{ __('lms.report.generated_at') }}: {{ ($generatedAt ?? now())->format('d/m/Y H:i') }}</div>
    @yield('content')
</body>
</html>
