<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-3d inline-flex items-center px-5 py-2.5 bg-gradient-to-b from-red-600 to-red-700 dark:from-red-500 dark:to-red-600 border border-red-700/30 rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:from-red-500 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-red-500/40 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all duration-300']) }}>
    {{ $slot }}
</button>
