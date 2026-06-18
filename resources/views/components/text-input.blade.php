@props(['disabled' => false])

<x-ds.input {{ $attributes->merge(['disabled' => $disabled]) }} />
