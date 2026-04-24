<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rynna Pet Shop') }} | Premium Care</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

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

        <style type="text/tailwindcss">
            @layer base {
                :root {
                    --beige-50: #fdfcfb;
                    --earth-800: #3d2517;
                    --sepia-600: #704214;
                }
                body {
                    @apply bg-beige-50 text-earth-800 antialiased;
                    background-color: var(--beige-50);
                    color: var(--earth-800);
                }
            }
            @layer components {
                .btn-sepia {
                    @apply bg-sepia-600 text-white px-10 py-4 rounded-full hover:bg-sepia-700 transition-all duration-500 font-bold tracking-[0.2em] text-[10px] uppercase shadow-xl;
                }
                .card-premium {
                    @apply bg-white border border-beige-100 rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-700 overflow-hidden relative;
                }
                .nav-link-premium {
                    @apply relative text-earth-400 hover:text-earth-900 transition-colors duration-500 font-bold uppercase tracking-[0.2em] text-[10px] py-2;
                }
                .section-animate {
                    @apply opacity-100 transition-all duration-1000;
                }
                .section-animate.v-hidden {
                    @apply opacity-0 translate-y-10;
                }
            }
        </style>
    </head>
    <body class="antialiased text-earth-500">
        <div class="min-h-screen bg-beige-50 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white/70 backdrop-blur-md border-b border-beige-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="font-semibold text-xl text-sepia-600 leading-tight">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer phong cách Ninh Tito -->
            <footer class="bg-earth-900 py-16 text-beige-100 mt-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 border-b border-earth-700 pb-12">
                        <!-- Cột 1: Thông tin thương hiệu -->
                        <div class="space-y-6">
                            <h3 class="text-2xl font-bold italic text-white">Rynna Pet Supply</h3>
                            <div class="space-y-3 text-sm text-beige-300 leading-loose">
                                <p>HỆ THỐNG CỬA HÀNG THÚ CƯNG RYNNA</p>
                                <p>MST: 0123456789</p>
                                <p>Email: <a href="mailto:contact@rynna.vn" class="text-sepia-400 hover:text-sepia-300">contact@rynna.vn</a></p>
                                <p>Hotline: <a href="tel:19008888" class="text-sepia-400 hover:text-sepia-300">1900 8888</a></p>
                                <p>Địa chỉ: 123 Đường Thuý Lĩnh, Quận Hoàng Mai, Hà Nội</p>
                            </div>
                        </div>

                        <!-- Cột 2: Liên kết nhanh -->
                        <div class="space-y-6">
                            <h4 class="text-xs uppercase tracking-[0.2em] font-bold text-sepia-400">Khám Phá</h4>
                            <ul class="space-y-4 text-sm font-medium">
                                <li><a href="{{ route('home') }}" class="hover:text-sepia-300 transition">Trang Chủ</a></li>
                                <li><a href="/#all-products" class="hover:text-sepia-300 transition">Sản Phẩm</a></li>
                                <li><a href="/#flash-sale" class="hover:text-sepia-300 transition text-red-400">⚡ Flash Sale</a></li>
                                <li><a href="{{ route('cart.index') }}" class="hover:text-sepia-300 transition">Giỏ Hàng</a></li>
                            </ul>
                        </div>

                        <!-- Cột 3: Mạng xã hội & Newsletter -->
                        <div class="space-y-6">
                            <h4 class="text-xs uppercase tracking-[0.2em] font-bold text-sepia-400">Kết Nối</h4>
                            <div class="flex space-x-5">
                                <a href="#" class="w-10 h-10 bg-earth-800 rounded-full flex items-center justify-center hover:bg-sepia-500 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                <a href="#" class="w-10 h-10 bg-earth-800 rounded-full flex items-center justify-center hover:bg-sepia-500 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                                <a href="#" class="w-10 h-10 bg-earth-800 rounded-full flex items-center justify-center hover:bg-sepia-500 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                </a>
                            </div>
                            <div class="pt-4">
                                <p class="text-xs text-beige-400 mb-4 italic">Đăng ký để nhận ưu đãi mới nhất từ Rynna.</p>
                                <div class="relative">
                                    <input type="email" placeholder="Email của bạn" class="w-full bg-earth-800 border-earth-700 rounded-lg py-3 px-4 text-sm focus:ring-sepia-500 focus:border-sepia-500 placeholder-earth-600">
                                    <button class="absolute right-2 top-2 bg-sepia-500 hover:bg-sepia-600 px-4 py-1 rounded text-xs font-bold transition">GỬI</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-12 text-center text-[10px] text-earth-600 tracking-[0.3em] uppercase">
                        © 2026 RYNNA PET SHOP. PREMIUM CARE.
                    </div>
                </div>
            </footer>
        </div>

        <!-- Premium Toast Notifications -->
        <div x-data="{ 
                show: false, 
                message: '', 
                type: 'success',
                init() {
                    @if(session('success'))
                        this.showToast('{{ session('success') }}', 'success');
                    @endif
                    @if(session('error'))
                        this.showToast('{{ session('error') }}', 'error');
                    @endif
                },
                showToast(msg, type) {
                    this.message = msg;
                    this.type = type;
                    this.show = true;
                    setTimeout(() => { this.show = false }, 5000);
                }
            }"
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform translate-y-10 scale-95"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 transform translate-y-10 scale-95"
            class="fixed bottom-10 right-10 z-[100] max-w-sm w-full"
            style="display: none;"
        >
            <div class="bg-white border-2 rounded-[2rem] shadow-2xl p-6 flex items-center space-x-6"
                :class="type === 'success' ? 'border-sepia-200' : 'border-red-100'">
                <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center"
                    :class="type === 'success' ? 'bg-beige-100 text-sepia-600' : 'bg-red-50 text-red-500'">
                    <template x-if="type === 'success'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </template>
                    <template x-if="type === 'error'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </template>
                </div>
                <div class="flex-grow">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] mb-1"
                        :class="type === 'success' ? 'text-sepia-400' : 'text-red-400'"
                        x-text="type === 'success' ? 'Thông báo' : 'Cảnh báo'"></p>
                    <p class="text-sm font-bold text-earth-900 leading-tight" x-text="message"></p>
                </div>
                <button @click="show = false" class="text-earth-200 hover:text-earth-900 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Progress Bar -->
            <div class="absolute bottom-0 left-6 right-12 h-1 bg-beige-50 rounded-full overflow-hidden">
                <div class="h-full bg-sepia-500 animate-[progress_5s_linear_forwards]"></div>
            </div>
        </div>

        <style>
            @keyframes progress {
                from { width: 100%; }
                to { width: 0%; }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sections = document.querySelectorAll('.section-animate');
                
                // Add hidden state initially via JS so it's safe if JS fails
                sections.forEach(s => s.classList.add('v-hidden'));

                const observerOptions = {
                    threshold: 0.1
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove('v-hidden');
                            entry.target.classList.add('section-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                sections.forEach(section => {
                    observer.observe(section);
                });
            });
        </script>

        <!-- Cart Drawer Popup -->
        @include('components.cart-drawer')

        <!-- Chat Widget -->
        @include('components.chat-widget')
    </body>
</html>
