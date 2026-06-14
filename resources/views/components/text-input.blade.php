@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input-3d premium-input rounded-xl border-slate-200 dark:border-slate-600 focus:border-brand-400 focus:ring-brand-400/40 dark:focus:border-brand-500']) }}>
