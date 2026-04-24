<x-app-layout>
    <div class="bg-beige-50 min-h-screen">
        <!-- Header Section -->
        <section class="py-20 bg-white border-b border-beige-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="text-sepia-500 font-bold text-[10px] tracking-[0.5em] uppercase mb-4 block">Premium Catalog</span>
                <h1 class="text-5xl md:text-6xl font-serif text-earth-900 tracking-tighter">Tất cả sản phẩm</h1>
                <p class="mt-6 text-earth-400 max-w-2xl mx-auto font-medium italic">Khám phá bộ sưu tập văn phòng phẩm tinh tế, được tuyển chọn kỹ lưỡng cho không gian sáng tạo của bạn.</p>
            </div>
        </section>

        <!-- Search & Filter Bar -->
        <section class="sticky top-20 z-40 bg-white/80 backdrop-blur-lg border-b border-beige-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-6 items-center justify-between">
                    <!-- Search Input -->
                    <div class="relative w-full md:w-1/3">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm sản phẩm..." 
                            class="w-full bg-beige-50 border-beige-200 rounded-full py-3 px-6 pl-12 text-sm focus:ring-sepia-500 focus:border-sepia-500 placeholder-earth-300">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-earth-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap items-center justify-center gap-4 w-full md:w-auto">
                        <select name="category" onchange="this.form.submit()" 
                            class="bg-beige-50 border-beige-200 rounded-full py-2.5 px-6 text-xs font-bold uppercase tracking-widest text-earth-500 focus:ring-sepia-500">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="sort" onchange="this.form.submit()" 
                            class="bg-beige-50 border-beige-200 rounded-full py-2.5 px-6 text-xs font-bold uppercase tracking-widest text-earth-500 focus:ring-sepia-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                        </select>

                        @if(request()->anyFilled(['search', 'category', 'sort']))
                            <a href="{{ route('products.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-500 underline underline-offset-4">
                                Xóa bộ lọc
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        <!-- Product Grid -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 sm:gap-16">
                        @foreach($products as $product)
                            <div class="group">
                                <a href="{{ route('product.show', $product->id) }}" class="block aspect-square overflow-hidden rounded-[2.5rem] bg-white border border-beige-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-700 relative mb-8">
                                    <div class="absolute inset-0 bg-earth-900/5 group-hover:opacity-0 transition duration-700"></div>
                                    @php
                                        $imageUrl = $product->image;
                                        if ($imageUrl && !Str::startsWith($imageUrl, ['http://', 'https://'])) {
                                            $imageUrl = asset('storage/' . $imageUrl);
                                        }
                                    @endphp
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-earth-100 italic tracking-[0.2em] font-medium text-[9px] uppercase font-bold">Rynna Stationery</div>
                                    @endif
                                    
                                    @if($product->is_flash_sale)
                                        <div class="absolute top-6 left-6 bg-red-500 text-white text-[10px] font-bold px-4 py-2 rounded-full shadow-xl">
                                            SALE
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 border-[20px] border-white/40 opacity-0 group-hover:opacity-100 transition duration-700 pointer-events-none"></div>
                                </a>

                                <div class="text-center px-4">
                                    <p class="text-[9px] text-sepia-400 font-bold uppercase tracking-[0.3em] mb-3">{{ $product->category->name ?? 'Collection' }}</p>
                                    <h3 class="text-sm font-bold text-earth-800 hover:text-sepia-600 transition duration-300 line-clamp-1 mb-4">{{ $product->name }}</h3>
                                    
                                    <div class="flex flex-col items-center space-y-4">
                                        @if($product->sale_price)
                                            <div class="space-x-3">
                                                <span class="text-base font-bold text-earth-900">{{ number_format($product->sale_price) }}đ</span>
                                                <span class="text-[10px] text-earth-200 line-through">{{ number_format($product->price) }}đ</span>
                                            </div>
                                        @else
                                            <span class="text-base font-bold text-earth-900 tracking-tighter">{{ number_format($product->price) }}đ</span>
                                        @endif

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[10px] font-bold uppercase tracking-[0.2em] text-earth-300 hover:text-sepia-500 border-b border-earth-100 hover:border-sepia-500 pb-1 transition-all duration-500">
                                                + Thêm vào giỏ
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-20">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="py-40 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-beige-100 mb-8">
                            <svg class="w-10 h-10 text-earth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-serif text-earth-900 mb-4">Không tìm thấy sản phẩm nào</h3>
                        <p class="text-earth-400 mb-10">Vui lòng thử điều chỉnh lại bộ lọc hoặc từ khóa tìm kiếm.</p>
                        <a href="{{ route('products.index') }}" class="btn-sepia px-10 py-4 text-[10px] uppercase tracking-widest">Xem tất cả sản phẩm</a>
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
