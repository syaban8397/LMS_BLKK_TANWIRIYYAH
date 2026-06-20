<div x-data="themeToggle()" class="inline-flex">
    <button type="button"
            @click="toggle()"
            class="theme-toggle-btn"
            :title="dark ? '{{ __('lms.theme.light') }}' : '{{ __('lms.theme.dark') }}'"
            aria-label="Toggle theme">
        <span x-show="!dark" x-cloak><x-lms-icon name="moon" class="w-[1.125rem] h-[1.125rem]" /></span>
        <span x-show="dark" x-cloak><x-lms-icon name="sun" class="w-[1.125rem] h-[1.125rem]" /></span>
    </button>
</div>
