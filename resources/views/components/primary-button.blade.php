<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-sepia-500 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-sepia-600 focus:bg-sepia-600 active:bg-sepia-700 focus:outline-none focus:ring-2 focus:ring-sepia-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-sepia-500/20 active:scale-95']) }}>
    {{ $slot }}
</button>
