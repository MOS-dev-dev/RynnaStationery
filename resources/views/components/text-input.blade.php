@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-beige-300 focus:border-sepia-500 focus:ring-sepia-500 rounded-xl shadow-sm bg-beige-50/30']) !!}>
