@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-sepia-500 text-left text-base font-medium text-sepia-600 bg-beige-100 focus:outline-none focus:text-sepia-700 focus:bg-beige-200 focus:border-sepia-600 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-earth-400 hover:text-sepia-500 hover:bg-beige-50 hover:border-beige-200 focus:outline-none focus:text-sepia-500 focus:bg-beige-50 focus:border-beige-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
