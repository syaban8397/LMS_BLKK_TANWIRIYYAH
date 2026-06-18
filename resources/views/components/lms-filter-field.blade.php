@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'lms-filter-field '.$class]) }}>
    <x-ds.label :for="$name">{{ $label }}</x-ds.label>
    @if($type === 'select')
        <x-ds.input type="select" :name="$name" id="{{ $name }}">{{ $slot }}</x-ds.input>
    @else
        <x-ds.input
            :type="$type"
            :name="$name"
            id="{{ $name }}"
            :value="$value"
            :placeholder="$placeholder"
        />
    @endif
</div>
