<div x-data="themeToggle()" class="inline-flex">
    <button type="button"
            @click="toggle()"
            class="theme-toggle-btn"
            :title="dark ? '{{ __('lms.theme.light') }}' : '{{ __('lms.theme.dark') }}'"
            aria-label="Toggle theme">
        <span x-show="!dark" class="text-lg leading-none" x-cloak>🌙</span>
        <span x-show="dark" class="text-lg leading-none" x-cloak>☀️</span>
    </button>
</div>
