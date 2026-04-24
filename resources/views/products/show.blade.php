<x-app-layout>
    <div class="bg-beige-50 min-h-screen">
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <!-- Breadcrumb Tinh Tế -->
            <nav class="flex text-[10px] text-earth-300 gap-4 mb-20 uppercase tracking-[0.4em] font-bold items-center">
                <a href="{{ route('home') }}" class="hover:text-sepia-600 transition duration-500">Atelier</a>
                <span class="w-1 h-1 bg-beige-300 rounded-full"></span>
                <a href="/#all-products" class="hover:text-sepia-600 transition duration-500">{{ $product->category->name ?? 'Collection' }}</a>
                <span class="w-1 h-1 bg-beige-300 rounded-full"></span>
                <span class="text-earth-900 border-b border-earth-100 pb-1">{{ $product->name }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row gap-32">
                <!-- Product Gallery Section -->
                <div class="w-full lg:w-3/5">
                    <div class="relative group">
                        <!-- Background Decorative Element -->
                        <div class="absolute -top-10 -left-10 w-full h-full bg-white/50 rounded-[4rem] -z-10 translate-x-4 translate-y-4"></div>
                        
                        <div class="aspect-[1/1] bg-white rounded-[3.5rem] overflow-hidden shadow-2xl shadow-earth-900/5 relative">
                            @php
                                $imageUrl = $product->image;
                                if ($imageUrl && !Str::startsWith($imageUrl, ['http://', 'https://'])) {
                                    $imageUrl = asset('storage/' . $imageUrl);
                                }
                            @endphp
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-[2s]">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-beige-50">
                                    <span class="text-[10px] font-bold uppercase tracking-[0.5em] text-earth-100 italic">Rynna Atelier Piece</span>
                                </div>
                            @endif
                            
                            @if($product->is_flash_sale)
                                <div class="absolute top-10 left-10 py-3 px-8 bg-white/90 backdrop-blur-md rounded-full shadow-xl">
                                    <span class="text-red-500 text-[10px] font-bold uppercase tracking-[0.3em] flex items-center">
                                        <span class="animate-pulse mr-2">⚡</span> Flash Sale Member
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="w-full lg:w-2/5 flex flex-col pt-10">
                    <div class="mb-16">
                        <div class="flex items-center space-x-4 mb-8">
                            <span class="h-px w-10 bg-sepia-400"></span>
                            <span class="text-[10px] font-bold text-sepia-500 uppercase tracking-[0.5em]">{{ $product->brand ?? 'Artisan Series' }}</span>
                        </div>
                        
                        <h1 class="text-5xl md:text-6xl font-serif text-earth-900 leading-[1.1] tracking-tighter mb-10">{{ $product->name }}</h1>
                        
                        <div class="flex items-center space-x-8">
                            @if($product->sale_price)
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-earth-200 line-through font-bold uppercase tracking-widest mb-1">{{ number_format($product->price) }}đ</span>
                                    <span class="text-4xl font-bold text-red-500 tracking-tighter font-mono">{{ number_format($product->sale_price) }}đ</span>
                                </div>
                                <div class="bg-red-50 px-4 py-2 rounded-xl text-red-500 text-[10px] font-bold uppercase tracking-widest border border-red-100">
                                    Giảm {{ round((($product->price - $product->sale_price)/$product->price)*100) }}%
                                </div>
                            @else
                                <span class="text-4xl font-bold text-earth-900 tracking-tighter">{{ number_format($product->price) }}đ</span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-10 mb-20 text-earth-400 leading-relaxed font-medium serif italic text-xl border-l-2 border-beige-200 pl-10">
                        {{ $product->description ?: 'Một thiết kế tối giản, tập trung vào trải nghiệm tinh tế của chất liệu và độ hoàn thiện thủ công cao cấp nhất.' }}
                    </div>

                    <!-- Meta Info Grid -->
                    <div class="grid grid-cols-2 gap-12 py-10 border-y border-beige-100 mb-16">
                        <div class="space-y-2">
                            <span class="text-[9px] text-earth-300 uppercase tracking-[0.4em] font-bold">Danh mục</span>
                            <p class="text-earth-900 font-bold text-sm tracking-tight capitalize">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="space-y-2">
                            <span class="text-[9px] text-earth-300 uppercase tracking-[0.4em] font-bold">Tính khả dụng</span>
                            @if($product->stock > 0)
                                <p class="text-green-600 font-bold text-sm tracking-tight flex items-center">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span> Sẵn hàng phục vụ
                                </p>
                            @else
                                <p class="text-red-400 font-bold text-sm tracking-tight">Tạm hết hàng</p>
                            @endif
                        </div>
                    </div>

                    <!-- Buying Action -->
                    <div class="space-y-10 group">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full btn-sepia py-7 rounded-[2rem] text-sm uppercase tracking-[0.4em] flex items-center justify-center group" {{ $product->stock < 1 ? 'disabled' : '' }}>
                                <span class="group-hover:scale-110 transition duration-500">
                                    {{ $product->stock < 1 ? 'Coming Soon' : 'Thêm vào Bộ sưu tập' }}
                                </span>
                                <svg class="w-5 h-5 ml-4 group-hover:translate-x-3 transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                        
                        <div class="flex justify-between items-center px-4">
                            @foreach(['Sản phẩm hữu hạn' => '★', 'Giao hàng đặc quyền' => '◈', 'Bảo hành 24 tháng' => '♦'] as $text => $symbol)
                                <div class="flex flex-col items-center space-y-2">
                                    <span class="text-sepia-500 text-lg">{{ $symbol }}</span>
                                    <span class="text-[8px] font-bold text-earth-200 uppercase tracking-widest text-center">{{ $text }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
