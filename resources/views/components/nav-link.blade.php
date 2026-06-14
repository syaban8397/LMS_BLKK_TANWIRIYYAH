@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-brand-50 dark:bg-brand-950/40 text-brand-700 dark:text-brand-300 font-semibold ring-1 ring-brand-500/20'
            : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-100';
@endphp

<a {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-2 rounded-xl text-sm transition-all duration-300 '.$classes]) }}>
    {{ $slot }}
</a>
