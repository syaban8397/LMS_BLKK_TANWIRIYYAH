@props(['title', 'description' => null, 'hideBack' => false])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">{{ $title }}</h1>
        @if($description)
            <p class="text-sm text-slate-500 mt-0.5">{{ $description }}</p>
        @endif
    </div>
    @unless($hideBack)
        <a href="{{ route('admin.reports.index') }}"
           class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium">
            ← Kembali ke Laporan
        </a>
    @endunless
</div>
