<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Montserrat', 'sans-serif'],
                            serif: ['Playfair Display', 'serif'],
                        },
                        colors: {
                            beige: { 50: '#fdfcfb', 100: '#f9f6f2', 200: '#f0eade', 300: '#e8decb', 400: '#d9c9ae', 500: '#cbb692' },
                            earth: { 50: '#f5f2f0', 100: '#ece5e1', 200: '#d0c2ba', 300: '#b49f93', 400: '#987c6c', 500: '#7c5945', 600: '#5a3a2a', 800: '#3d2517', 900: '#2d1a0f' },
                            sepia: { 50: '#fbf8f5', 100: '#f4ece4', 200: '#e5d1bc', 300: '#d5b593', 400: '#a67c52', 500: '#704214', 600: '#5a3510', 700: '#46290c' }
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="font-sans text-earth-800 antialiased bg-beige-50">
        <div class="min-h-screen flex">
            <!-- Left Side: Image (Hidden on Small Screens) -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-beige-200 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=2043&auto=format&fit=crop" 
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 hover:scale-105" 
                     alt="Rynna Pet Shop Background">
                <div class="absolute inset-0 bg-gradient-to-t from-earth-900/60 via-earth-900/20 to-transparent"></div>
                
                <div class="absolute bottom-16 left-16 right-16 text-white z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="bg-white/20 backdrop-blur-md p-3 rounded-2xl border border-white/30">
                            <x-application-logo class="w-10 h-10 fill-current text-white" />
                        </div>
                        <span class="text-2xl font-bold tracking-widest uppercase">RYNNA PET SHOP</span>
                    </div>
                    <h1 class="text-5xl font-bold mb-4 leading-tight">Tình yêu nhỏ,<br>hạnh phúc to.</h1>
                    <p class="text-beige-100/80 text-lg max-w-md font-medium">
                        Cung cấp các sản phẩm thức ăn, đồ chơi và phụ kiện thú cưng cao cấp, mang lại đời sống trọn vẹn nhất cho các bé cưng nhà bạn.
                    </p>
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute top-10 left-10 w-32 h-32 border border-white/10 rounded-full"></div>
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-sepia-500/10 rounded-full blur-3xl"></div>
            </div>

            <!-- Right Side: Form Content -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-beige-50/50 backdrop-blur-sm">
                <!-- Branding for Mobile -->
                <div class="lg:hidden mb-12 text-center">
                    <div class="inline-block bg-white p-4 rounded-3xl shadow-xl border border-beige-100 mb-4">
                        <x-application-logo class="w-12 h-12 fill-current text-sepia-600" />
                    </div>
                    <h2 class="text-2xl font-bold text-earth-900 tracking-widest uppercase">RYNNA PET SHOP</h2>
                </div>

                <div class="w-full max-w-md">
                    <div class="text-center mb-10 hidden lg:block">
                        <h2 class="text-3xl font-bold text-earth-900 mb-2">Chào mừng bạn!</h2>
                        <p class="text-earth-500 font-medium">Vui lòng nhập thông tin để tiếp tục.</p>
                    </div>

                    <div class="bg-white/70 backdrop-blur-md p-8 lg:p-12 rounded-[2.5rem] shadow-2xl shadow-earth-900/5 border border-white">
                        {{ $slot }}
                    </div>
                    
                    <!-- Footer Info -->
                    <div class="mt-12 text-center">
                        <p class="text-sm text-earth-400 font-medium tracking-wide">
                            &copy; {{ date('Y') }} RYNNA PET SHOP. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

