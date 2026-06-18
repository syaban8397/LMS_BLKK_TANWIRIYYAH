@props(['label', 'name', 'required' => false])

<div {{ $attributes->merge(['class' => 'lms-form-group']) }}>
    <x-ds.label :for="$name">
        {{ $label }}@if($required)<span class="text-red-500"> *</span>@endif
    </x-ds.label>
    {{ $slot }}
    <x-ds.input-error :messages="$errors->get($name)" />
</div>
