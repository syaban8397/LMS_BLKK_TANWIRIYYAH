<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-3d inline-flex items-center px-5 py-2.5 bg-gradient-to-b from-brand-600 to-brand-700 dark:from-brand-500 dark:to-brand-600 border border-brand-700/30 dark:border-brand-400/20 rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:from-brand-500 hover:to-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500/40 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all duration-300']) }}>
    {{ $slot }}
</button>
