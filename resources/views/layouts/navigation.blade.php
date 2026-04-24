<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-beige-200 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Left: Logo -->
            <div class="flex shrink-0 items-center">
                <a href="{{ route('home') }}" class="group flex items-center space-x-2">
                    <span class="text-2xl font-bold tracking-tighter text-sepia-600 italic group-hover:text-sepia-700 transition-colors">Rynna</span>
                    <span class="text-2xl font-light text-earth-300 tracking-widest hidden md:inline group-hover:text-earth-400 transition-colors uppercase text-xs">Stationery</span>
                </a>
            </div>

                <!-- Center: Navigation Links (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:space-x-10 uppercase tracking-[0.2em] font-bold text-[10px]">
                <a href="{{ route('home') }}" class="nav-link-premium {{ request()->routeIs('home') ? 'text-earth-900 after:w-full' : '' }}">
                    Trang Chủ
                </a>
                <a href="{{ route('products.index') }}" class="nav-link-premium {{ request()->routeIs('products.index') ? 'text-earth-900 after:w-full' : '' }}">
                    Sản Phẩm
                </a>
                <a href="{{ route('flash_sale') }}" class="text-red-400 hover:text-red-700 transition-colors duration-500 flex items-center {{ request()->routeIs('flash_sale') ? 'text-red-600 font-black' : '' }}">
                    <span class="mr-1">⚡</span> Flash Sale
                </a>
                @if(Auth::user() && Auth::user()->role === 'admin')
                    <div class="h-4 w-px bg-beige-200"></div>
                    <a href="{{ route('admin.dashboard') }}" class="text-sepia-400 hover:text-sepia-600 transition font-bold">Bảng điều khiển</a>
                    <a href="{{ route('admin.categories.index') }}" class="text-sepia-400 hover:text-sepia-600 transition">Danh mục</a>
                    <a href="{{ route('admin.products.index') }}" class="text-sepia-400 hover:text-sepia-600 transition">Sản phẩm</a>
                    <a href="{{ route('admin.flash_sale.active') }}" class="text-red-500 hover:text-red-700 transition font-bold">⚡ Quản lý Sale</a>
                    <a href="{{ route('admin.orders.index') }}" class="text-sepia-400 hover:text-sepia-600 transition">Đơn hàng</a>
                    <a href="{{ route('admin.chat.index') }}" class="text-sepia-400 hover:text-sepia-600 transition font-bold flex items-center">
                        Support Chat
                        @php
                            $unreadChats = \App\Models\ChatMessage::where('sender', 'user')->where('is_read', false)->count();
                        @endphp
                        @if($unreadChats > 0)
                            <span class="ml-1 bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">{{ $unreadChats }}</span>
                        @endif
                    </a>
                @endif
            </div>

            <!-- Right: Icons & Profile -->
            <div class="flex items-center space-x-5">
                <!-- Cart (Triggers Drawer) -->
                <a href="#" @click.prevent="$dispatch('open-cart-drawer')" class="relative text-earth-400 hover:text-sepia-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-1 -right-2 bg-sepia-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold">{{ count(session('cart')) }}</span>
                    @endif
                </a>

                @auth
                    <!-- Profile Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-earth-400 hover:text-sepia-500 transition focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-beige-100">
                                <p class="text-xs text-earth-300">Xin chào,</p>
                                <p class="text-sm font-semibold text-earth-500 truncate">{{ Auth::user()->name }}</p>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Thông tin tài khoản') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('orders.index')">
                                {{ __('Đơn hàng của tôi') }}
                            </x-dropdown-link>
                            @if(Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('dashboard')">
                                    {{ __('Bảng điều khiển Admin') }}
                                </x-dropdown-link>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Đăng xuất') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-earth-400 hover:text-sepia-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </a>
                @endauth

                <!-- Hamburger (Mobile) -->
                <div class="sm:hidden flex items-center">
                    <button @click="open = ! open" class="text-earth-400 hover:text-sepia-500 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-beige-50 border-t border-beige-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Trang Chủ') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                {{ __('Sản Phẩm') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('flash_sale')" :active="request()->routeIs('flash_sale')" class="text-red-500">
                {{ __('Flash Sale') }}
            </x-responsive-nav-link>
            
            @if(Auth::user() && Auth::user()->role === 'admin')
                <div class="border-t border-beige-100 my-2"></div>
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-sepia-600 font-bold">
                    {{ __('Bảng điều khiển Admin') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.flash_sale.active')" :active="request()->routeIs('admin.flash_sale.active')" class="text-red-600 font-bold">
                    {{ __('⚡ Quản lý Flash Sale') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.chat.index')" :active="request()->routeIs('admin.chat.index')" class="text-sepia-600 font-bold">
                    {{ __('Hỗ trợ Khách hàng (Chat)') }}
                    @if($unreadChats > 0)
                        <span class="ml-1 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadChats }}</span>
                    @endif
                </x-responsive-nav-link>
            @endif
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-beige-200">
                <div class="px-4">
                    <div class="font-medium text-base text-earth-500">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-earth-300">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Thông tin cá nhân') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('orders.index')">
                        {{ __('Đơn hàng') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Đăng xuất') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
