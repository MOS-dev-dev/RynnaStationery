<x-app-layout>
    <!-- Hero Section -->
    <section class="relative min-h-[95vh] flex items-center justify-center overflow-hidden bg-beige-50">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover opacity-70" alt="Pet Shop Background">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-beige-50/10 to-beige-50"></div>
        </div>

        <!-- Floating Elements for Aesthetic -->
        <div class="absolute top-20 left-10 w-64 h-64 bg-sepia-100 rounded-full blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-earth-100 rounded-full blur-3xl opacity-20 animate-pulse"></div>

        <!-- Decorative Large Text Behind -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.03] select-none">
            <span class="text-[40rem] font-serif font-black text-earth-900 leading-none">M</span>
        </div>

        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <!-- Glassmorphism Container for Text Readability -->
            <div class="backdrop-blur-[2px] bg-white/5 p-8 md:p-12 rounded-[3rem] border border-white/10 shadow-2xl shadow-earth-900/5">
                <div class="inline-flex items-center space-x-3 mb-10 overflow-hidden">
                    <span class="h-px w-8 bg-sepia-400"></span>
                    <span class="text-[10px] uppercase tracking-[0.6em] font-bold text-sepia-900">The Premium Pet Boutique</span>
                    <span class="h-px w-8 bg-sepia-400"></span>
                </div>
                
                <h1 class="text-6xl md:text-9xl font-serif text-earth-900 mb-12 leading-[1.05] tracking-tighter drop-shadow-sm">
                    Tình yêu nhỏ <br> 
                    <span class="italic font-normal text-sepia-600">tạo Hạnh phúc to</span>
                </h1>
                
                <p class="text-lg md:text-xl text-earth-800/80 mb-16 max-w-2xl mx-auto font-medium leading-relaxed tracking-tight">
                    Dành trọn những điều tuyệt vời nhất cho người bạn bốn chân với bộ sưu tập các sản phẩm thú cưng cao cấp 5 sao.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-6 sm:space-y-0 sm:space-x-10 animate-fade-in-up" style="animation-delay: 0.6s">
                    <a href="#all-products" class="btn-sepia px-12 py-5 text-sm uppercase tracking-[0.3em] shadow-xl shadow-earth-900/20">
                        Khám Phá Bộ Sưu Tập
                    </a>
                    <a href="{{ route('flash_sale') }}" class="group flex items-center text-earth-900 font-bold text-xs uppercase tracking-widest hover:text-sepia-600 transition-all font-sans">
                        <span>Ưu đãi Flash Sale</span>
                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-2 transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center space-y-4">
            <span class="text-[9px] uppercase tracking-[0.4em] font-bold text-earth-300">Cuộn để xem</span>
            <div class="w-px h-16 bg-gradient-to-b from-sepia-400 to-transparent"></div>
        </div>
    </section>

    <!-- Banner Slider Section (Featured Events/New Arrivals) -->
    <section class="py-12 bg-beige-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Swiper CSS & JS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
            <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
            
            <div class="swiper myBannerSlider rounded-[3rem] overflow-hidden shadow-2xl relative bg-white section-animate">
                <div class="swiper-wrapper">
                    @foreach($products->take(5) as $product)
                    <div class="swiper-slide cursor-grab active:cursor-grabbing">
                        <div class="grid grid-cols-1 md:grid-cols-2 h-full">
                            <!-- Image Half -->
                            <div class="relative h-72 md:h-full min-h-[400px]">
                                @php
                                    $imageUrl = $product->image;
                                    if ($imageUrl && !Str::startsWith($imageUrl, ['http://', 'https://'])) {
                                        $imageUrl = asset('storage/' . $imageUrl);
                                    }
                                @endphp
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-earth-100 flex items-center justify-center font-bold text-earth-300">Rynna Pet Shop</div>
                                @endif
                                <!-- Tag -->
                                <div class="absolute top-6 left-6 bg-red-500 text-white px-5 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-xl animate-bounce">🔥 Hot / Mới Nhất</div>
                            </div>
                            
                            <!-- Content Half -->
                            <div class="p-10 md:p-16 flex flex-col justify-center items-start bg-gradient-to-r from-white to-beige-50">
                                <span class="text-[10px] text-sepia-400 font-bold uppercase tracking-[0.3em] mb-4">{{ $product->category->name ?? 'Nổi Bật' }}</span>
                                <h3 class="text-3xl md:text-5xl font-serif text-earth-900 mb-6 leading-tight">{{ $product->name }}</h3>
                                <p class="text-earth-400 text-sm md:text-base mb-10 leading-relaxed font-medium">Bạn muốn dành điều tuyệt vời nhất cho người bạn bốn chân? Đây là lựa chọn không thể bỏ qua tại Rynna.</p>
                                
                                <div class="flex items-center space-x-8">
                                    <span class="text-3xl font-bold text-red-500 font-mono">{{ number_format($product->sale_price ?? $product->price) }}đ</span>
                                    <a href="{{ route('product.show', $product->id) }}" class="inline-flex items-center text-[10px] font-bold uppercase tracking-[0.2em] text-earth-900 border-b-2 border-earth-900 hover:text-sepia-600 hover:border-sepia-600 pb-1 transition-all">
                                        Xem ngay <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Indicators -->
                <div class="swiper-pagination"></div>
            </div>
            
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const swiper = new Swiper('.myBannerSlider', {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    loop: true,
                    grabCursor: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            });
            </script>
            <style>
                .swiper-pagination-bullet { background: #d5b593; opacity: 0.5; width: 10px; height: 10px; margin: 0 6px !important; }
                .swiper-pagination-bullet-active { background: #704214; opacity: 1; width: 30px; border-radius: 5px; transition: all 0.3s; }
                .swiper-pagination { position: absolute; bottom: 20px !important; text-align: center; width: 100%; z-index: 10; }
            </style>
        </div>
    </section>

    <!-- Flash Sale Section -->
    @if(count($flashSaleProducts) > 0)
    <section id="flash-sale" class="py-32 bg-white relative section-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-end mb-24 space-y-10 lg:space-y-0">
                <div class="max-w-xl">
                    <div class="text-red-500 font-bold text-[10px] tracking-[0.4em] uppercase mb-4">Limited Availability</div>
                    <h2 class="text-4xl md:text-5xl font-serif text-earth-900 tracking-tighter">⚡ Flash Sale Độc Quyền</h2>
                    <p class="text-earth-400 mt-6 text-lg font-medium italic serif">Sở hữu ngay những tuyệt phẩm với mức giá chưa từng có.</p>
                </div>
                
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
                    class="flex items-center space-x-4 bg-beige-50 p-6 rounded-3xl border border-beige-100 shadow-sm"
                >
                    <span class="text-[9px] font-bold text-earth-300 uppercase tracking-widest">Thời gian còn lại</span>
                    <div class="flex space-x-4">
                        <template x-for="(label, key) in { 'days': 'Ngày', 'hours': 'Giờ', 'minutes': 'Phút', 'seconds': 'Giây' }">
                            <div class="text-center">
                                <div class="bg-white px-4 py-2 rounded-xl shadow-lg shadow-earth-900/5 text-xl font-bold text-red-500 font-mono" x-text="String($data[key]).padStart(2, '0')">00</div>
                                <div class="text-[8px] uppercase tracking-tighter text-earth-200 mt-1 font-bold" x-text="label">Label</div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

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
                            
                            <div class="absolute top-6 left-6 bg-red-500 text-white text-[10px] font-bold px-4 py-2 rounded-full shadow-xl">
                                -{{ round((($product->price - $product->sale_price)/$product->price)*100) }}%
                            </div>
                        </div>

                        <div class="p-10">
                            <h3 class="text-base font-bold text-earth-800 mb-4 line-clamp-2 h-12 leading-relaxed tracking-tight">{{ $product->name }}</h3>
                            <div class="flex items-center space-x-4 mb-8">
                                <span class="text-xl font-bold text-red-500 tracking-tighter font-mono">{{ number_format($product->sale_price) }}đ</span>
                                <span class="text-xs text-earth-200 line-through font-medium">{{ number_format($product->price) }}đ</span>
                            </div>
                            
                            <!-- Premium Progress Bar -->
                            <div class="space-y-3">
                                @php
                                    $totalStock = $product->stock + $product->sold_count;
                                    $percentage = $totalStock > 0 ? ($product->sold_count / $totalStock) * 100 : 0;
                                    $percentage = max($percentage, 5); // Minimum 5% to show something
                                @endphp
                                <div class="w-full h-1.5 bg-beige-50 rounded-full overflow-hidden p-0.5 border border-beige-100">
                                    <div class="h-full bg-gradient-to-r from-red-400 to-red-600 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[9px] font-bold uppercase tracking-widest">
                                    <span class="{{ $percentage > 80 ? 'text-red-500 animate-pulse' : 'text-earth-300' }}">
                                        {{ $percentage > 80 ? '🔥 Sắp hết' : 'Đang bán' }}
                                    </span>
                                    <span class="text-earth-200 text-xs">Còn {{ $product->stock }} sp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Main Products Collection -->
    <section id="all-products" class="py-40 bg-beige-50 section-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center mb-32">
                <span class="text-sepia-500 font-bold text-[10px] tracking-[0.5em] uppercase mb-6 block">Premium Pet Collection</span>
                <h2 class="text-5xl md:text-6xl font-serif text-earth-900 tracking-tighter text-center">Sự chăm sóc hoàn hảo</h2>
                <div class="h-px w-32 bg-sepia-500/30 mt-10"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-16">
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
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-earth-100 italic tracking-[0.2em] font-medium text-[9px] uppercase font-bold">Rynna Pet Shop</div>
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
            
            <div class="mt-40 text-center">
                <a href="{{ route('products.index') }}" class="btn-sepia px-12 py-5 text-sm uppercase tracking-[0.3em]">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    </section>

    <!-- Brand Philosophy Section -->
    <section class="py-48 bg-earth-900 relative overflow-hidden section-animate">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-sepia-500/5 skew-x-12 translate-x-20"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-32 items-center">
                <div class="space-y-12">
                    <div class="w-16 h-1 px bg-sepia-500 rounded-full"></div>
                    <h2 class="text-5xl md:text-7xl font-serif text-white tracking-tighter leading-tight">
                        Tình Yêu <br>
                        <span class="text-sepia-400 italic font-normal">Không Điều Kiện</span>
                    </h2>
                    <p class="text-beige-300 text-xl leading-relaxed font-light serif italic">
                        "Chúng tôi tin rằng mọi em Thú cưng đều xứng đáng nhận được sự chăm sóc tuyệt vời và tình yêu thương vô bờ bến như một thành viên ruột thịt trong gia đình."
                    </p>
                    <div class="pt-8">
                        <a href="#" class="inline-flex items-center text-sepia-400 font-bold uppercase tracking-[0.4em] text-[10px] border border-sepia-500/30 px-10 py-5 rounded-full hover:bg-sepia-500 hover:text-white transition-all duration-700">
                            Khám phá triết lý Rynna
                        </a>
                    </div>
                </div>
                
                <div class="relative group">
                    <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl relative">
                        <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=1000&q=80" alt="Philosophy" class="w-full h-full object-cover grayscale-[10%] group-hover:grayscale-0 transition duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-earth-900/60 to-transparent"></div>
                    </div>
                    <!-- Aesthetic Overlay -->
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-sepia-500/20 rounded-[4rem] -z-10 blur-2xl group-hover:scale-125 transition duration-1000"></div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
