@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input-3d premium-input']) }}>
