@props(['disabled' => false, 'type' => 'text'])

@if ($type === 'textarea')
    <textarea @disabled($disabled) {{ $attributes->merge(['class' => 'ds-textarea']) }}>{{ $slot }}</textarea>
@elseif ($type === 'select')
    <select @disabled($disabled) {{ $attributes->merge(['class' => 'ds-select']) }}>{{ $slot }}</select>
@else
    <input @disabled($disabled) {{ $attributes->merge(['class' => 'ds-input', 'type' => $type]) }}>
@endif
