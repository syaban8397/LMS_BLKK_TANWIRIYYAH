<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-3d inline-flex items-center px-5 py-2.5 glass-panel font-semibold text-xs text-slate-700 dark:text-slate-200 uppercase tracking-wider hover:ring-2 hover:ring-brand-500/20 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all duration-300']) }}>
    {{ $slot }}
</button>
