<x-app-layout>
    <!-- Header Section -->
    <section class="py-24 bg-beige-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-sepia-100 rounded-full blur-3xl opacity-20 -translate-y-1/2"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center space-x-3 mb-6">
                <span class="h-px w-8 bg-sepia-400"></span>
                <span class="text-[10px] uppercase tracking-[0.6em] font-bold text-sepia-500">Limited Time Offers</span>
                <span class="h-px w-8 bg-sepia-400"></span>
            </div>
            <h1 class="text-5xl md:text-7xl font-serif text-earth-900 mb-8 tracking-tighter">⚡ Flash Sale Độc Quyền</h1>
            <p class="text-earth-400 text-lg max-w-2xl mx-auto font-medium italic serif">Đừng bỏ lỡ cơ hội sở hữu những tuyệt phẩm với mức giá ưu đãi nhất.</p>
            
            <!-- Global Timer -->
            <div x-data="{
                    endTime: '{{ $flashSaleEndTime }}',
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    init() {
                        this.updateCount();
                        setInterval(() => { this.updateCount() }, 1000);
                    },
                    updateCount() {
                        let end = new Date(this.endTime).getTime();
                        let now = new Date().getTime();
                        let dist = end - now;

                        if (dist < 0) return;

                        this.days = Math.floor(dist / (1000 * 60 * 60 * 24));
                        this.hours = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        this.minutes = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                        this.seconds = Math.floor((dist % (1000 * 60)) / 1000);
                    }
                }" 
                class="mt-12 flex justify-center items-center space-x-6"
            >
                <template x-for="(label, key) in { 'days': 'Ngày', 'hours': 'Giờ', 'minutes': 'Phút', 'seconds': 'Giây' }">
                    <div class="text-center group">
                        <div class="bg-white px-6 py-4 rounded-2xl shadow-xl shadow-earth-900/5 text-3xl font-bold text-red-500 font-mono transition-transform hover:-translate-y-1" x-text="String($data[key]).padStart(2, '0')">00</div>
                        <div class="text-[10px] uppercase tracking-widest text-earth-200 mt-2 font-bold" x-text="label">Label</div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
                @foreach($flashSaleProducts as $product)
                    <div class="card-premium group">
                        <div class="relative overflow-hidden aspect-[4/5] bg-beige-50">
                            @php
                                $imageUrl = $product->image;
                                if ($imageUrl && !Str::startsWith($imageUrl, ['http://', 'https://'])) {
                                    $imageUrl = asset('storage/' . $imageUrl);
                                }
                            @endphp
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000 grayscale-[20%] group-hover:grayscale-0">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-earth-100 italic tracking-widest uppercase text-[10px] font-bold">Rynna Select</div>
                            @endif
                            
                            @if($product->sale_price && $product->price > 0)
                            <div class="absolute top-6 left-6 bg-red-500 text-white text-[10px] font-bold px-4 py-2 rounded-full shadow-xl">
                                -{{ round((($product->price - $product->sale_price)/$product->price)*100) }}%
                            </div>
                            @endif
                        </div>

                        <div class="p-10">
                            <h3 class="text-base font-bold text-earth-800 mb-4 line-clamp-2 h-12 leading-relaxed tracking-tight">{{ $product->name }}</h3>
                            <div class="flex items-center space-x-4 mb-8">
                                <span class="text-xl font-bold text-red-500 tracking-tighter font-mono">{{ number_format($product->sale_price) }}đ</span>
                                <span class="text-xs text-earth-200 line-through font-medium">{{ number_format($product->price) }}đ</span>
                            </div>
                            
                            <!-- Premium Progress Bar -->
                            <div class="space-y-3 mb-8">
                                @php
                                    $totalStock = $product->stock + $product->sold_count;
                                    $percentage = $totalStock > 0 ? ($product->sold_count / $totalStock) * 100 : 0;
                                    // Make it look better if 0
                                    $percentage = max($percentage, 10);
                                @endphp
                                <div class="w-full h-1.5 bg-beige-50 rounded-full overflow-hidden p-0.5 border border-beige-100">
                                    <div class="h-full bg-gradient-to-r from-red-400 to-red-600 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[9px] font-bold uppercase tracking-widest">
                                    <span class="{{ $percentage > 80 ? 'text-red-500 animate-pulse' : 'text-earth-300' }}">
                                        {{ $percentage > 80 ? '🔥 Sắp hết' : 'Đang bán chạy' }}
                                    </span>
                                    <span class="text-earth-200 text-xs text-right">Đã bán {{ $product->sold_count }} / {{ $totalStock }}</span>
                                </div>
                            </div>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-earth-900 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-sepia-600 transition-all duration-500 shadow-lg shadow-earth-900/10">
                                    Thêm vào giỏ hàng
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-20">
                {{ $flashSaleProducts->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
