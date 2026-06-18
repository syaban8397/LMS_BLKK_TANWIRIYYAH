<div {{ $attributes->merge(['class' => 'lms-module-shell lms-page-shell']) }}>
    <x-lms-session-flash />
    {{ $slot }}
</div>
