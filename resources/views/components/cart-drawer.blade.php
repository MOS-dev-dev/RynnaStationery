<?php
$cart = session('cart', []);
$cartTotal = 0;
foreach($cart as $item) {
    $cartTotal += $item['price'] * $item['quantity'];
}

// Fetch active vouchers for milestones
$vouchers = \App\Models\Voucher::where('min_order_value', '>', 0)->orderBy('min_order_value', 'asc')->get();
if ($vouchers->isEmpty()) {
    $vouchers = collect([
        (object)['type' => 'freeship', 'min_order_value' => 150000, 'discount_value' => 'Freeship', 'max_discount' => 0],
        (object)['type' => 'percent', 'min_order_value' => 300000, 'discount_value' => 10, 'max_discount' => 50000],
        (object)['type' => 'percent', 'min_order_value' => 500000, 'discount_value' => 20, 'max_discount' => 100000],
    ]);
}

$unlockedVouchers = [];
$nextVoucher = null;
$distance = 0;

foreach($vouchers as $v) {
    if ($cartTotal >= $v->min_order_value) {
        $unlockedVouchers[] = $v;
    } else {
        if (!$nextVoucher) {
            $nextVoucher = $v;
        }
    }
}

$bestDiscount = 0;
$bestDiscountLabel = '';
$hasFreeship = false;

foreach($unlockedVouchers as $v) {
    $d = 0;
    if ($v->type == 'percent') {
        $d = ($cartTotal * $v->discount_value) / 100;
        if (isset($v->max_discount) && $v->max_discount > 0 && $d > $v->max_discount) $d = $v->max_discount;
        if ($d > $bestDiscount) {
            $bestDiscount = $d;
            $bestDiscountLabel = $v->discount_value . '% off';
        }
    } elseif ($v->type == 'amount') {
        $d = $v->discount_value;
        if ($d > $bestDiscount) {
            $bestDiscount = $d;
            $bestDiscountLabel = number_format($v->discount_value) . 'đ off';
        }
    } elseif ($v->type == 'freeship') {
        $hasFreeship = true;
    }
}

$maxMilestone = $vouchers->max('min_order_value');
if (!$maxMilestone) $maxMilestone = 150000;
$progress = min(100, ($cartTotal / $maxMilestone) * 100);

if ($nextVoucher) {
    $distance = $nextVoucher->min_order_value - $cartTotal;
}

$finalTotal = max(0, $cartTotal - $bestDiscount);

$cartIds = array_keys($cart);
$recommendation = \App\Models\Product::whereNotIn('id', $cartIds)->inRandomOrder()->first();
?>

<div x-data="{ showDrawer: {{ session('show_cart_drawer') ? 'true' : 'false' }} }" 
     @open-cart-drawer.window="showDrawer = true"
     @keydown.escape.window="showDrawer = false"
     class="relative z-[100]" 
     aria-labelledby="slide-over-title" 
     role="dialog" 
     aria-modal="true"
     x-show="showDrawer"
     style="display: none;">
    
    <!-- Background backdrop -->
    <div x-show="showDrawer"
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-earth-900/40 backdrop-blur-sm transition-opacity" 
         @click="showDrawer = false"></div>

    <div class="fixed inset-0 overflow-hidden z-[101]">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full sm:pl-10">
                <!-- Slide-over panel -->
                <div x-show="showDrawer"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="pointer-events-auto w-screen max-w-md relative">
                     
                     <div class="flex h-full flex-col overflow-y-scroll bg-beige-50 shadow-2xl sm:rounded-l-[2.5rem] border-l border-sepia-200/40">
                        <div class="flex-1 overflow-y-auto px-6 py-10 sm:px-10">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-10">
                                <h2 class="text-3xl font-serif text-earth-900 flex items-center gap-4" id="slide-over-title">
                                    Giỏ Hàng
                                    @if(count($cart) > 0)
                                        <span class="bg-earth-800 text-white rounded-full h-8 w-8 flex items-center justify-center text-xs font-sans font-bold shadow-md">{{ count($cart) }}</span>
                                    @endif
                                </h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" @click="showDrawer = false" class="relative -m-2 p-3 text-earth-400 hover:text-earth-900 transition bg-white rounded-full border border-beige-200 shadow-sm">
                                        <span class="absolute -inset-0.5"></span>
                                        <span class="sr-only">Đóng</span>
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Progress Bar Card -->
                            <div class="bg-white rounded-[2rem] p-8 border border-beige-100 shadow-sm mb-10 text-center relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-beige-50/50 to-transparent"></div>
                                <div class="relative z-10">
                                    
                                    @if($bestDiscount > 0)
                                        <p class="text-sm font-bold text-sepia-600 mb-2">Bạn đã mở khoá <span class="font-black">{{ $bestDiscountLabel }}</span> 🎉</p>
                                    @elseif($hasFreeship)
                                        <p class="text-sm font-bold text-sepia-600 mb-2">Bạn đã mở khoá <span class="font-black">FREESHIP</span> 🎉</p>
                                    @endif

                                    @if($cartTotal == 0)
                                        <p class="text-[10px] uppercase font-bold text-earth-400 tracking-[0.2em] mb-6">Hãy mua sắm để nhận ưu đãi hấp dẫn!</p>
                                    @elseif($nextVoucher && $distance > 0)
                                        <p class="text-xs font-bold text-earth-400 tracking-wide uppercase mb-8 leading-relaxed">
                                            Chỉ cần thêm <span class="text-sepia-600 bg-sepia-50 px-2 py-1 rounded-md">{{ number_format($distance) }}đ</span>
                                            để nhận <span class="text-sepia-600 font-black">{{ isset($nextVoucher->type) && $nextVoucher->type == 'freeship' ? 'FREESHIP' : (isset($nextVoucher->type) && $nextVoucher->type == 'percent' ? 'Mã Giảm '.$nextVoucher->discount_value.'%' : (isset($nextVoucher->discount_value) ? 'Mã Giảm '.number_format($nextVoucher->discount_value).'đ' : 'FREESHIP')) }}</span>
                                        </p>
                                    @else
                                        <p class="text-[10px] uppercase font-bold text-sepia-600 tracking-[0.2em] mb-8">Xin chúc mừng! Đã mở khóa Mọi Ưu Đãi.</p>
                                    @endif
                                    
                                    <!-- Advanced Milestones Progress Bar -->
                                    <div class="relative w-full mb-12 mt-4 px-4">
                                        <!-- Background Track -->
                                        <div class="absolute top-2 left-4 right-4 h-2 bg-earth-100/50 rounded-full"></div>
                                        
                                        <!-- Filled Track -->
                                        <div class="absolute top-2 left-4 h-2 bg-sepia-500 rounded-full transition-all duration-1000 ease-out z-10" style="width: calc({{ $progress }}% - 2rem)"></div>
                                        
                                        <!-- Milestone Dots -->
                                        @foreach($vouchers as $v)
                                            @php
                                                $pos = ($v->min_order_value / $maxMilestone) * 100;
                                                $isUnlocked = $cartTotal >= $v->min_order_value;
                                                $label = $v->type == 'percent' ? $v->discount_value.'%' : ($v->type == 'freeship' ? 'Free' : '-'.number_format((int)$v->discount_value/1000).'k');
                                            @endphp
                                            <div class="absolute top-2 flex flex-col items-center z-20" style="left: calc({{ $pos }}% + {{ $pos < 50 ? '1rem' : ($pos > 50 ? '-1rem' : '0rem') }}); transform: translate(-50%, -50%);">
                                                <div class="w-8 h-8 rounded-full border-[3px] border-white flex items-center justify-center text-[9.5px] font-extrabold shadow-sm transition-all duration-500 {{ $isUnlocked ? 'bg-sepia-500 text-white scale-110' : 'bg-earth-100 text-earth-300' }}">
                                                    {{ $label }}
                                                </div>
                                                <span class="absolute top-10 text-[9px] font-bold text-earth-400 whitespace-nowrap">{{ number_format((int)$v->min_order_value/1000) }}k đ</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    @if($hasFreeship && $bestDiscount == 0)
                                        <p class="text-[10.5px] font-bold text-green-600 tracking-wide mt-4 flex items-center justify-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Bạn đã đạt mốc MIỄN PHÍ VẬN CHUYỂN 🎉
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-beige-100">
                                        @foreach($cart as $id => $details)
                                            <li class="flex py-8 group">
                                                <div class="h-28 w-28 flex-shrink-0 overflow-hidden rounded-[1.5rem] border border-beige-100 bg-white p-1.5 shadow-sm">
                                                    @if($details['image'])
                                                        <img src="{{ Str::startsWith($details['image'], 'http') ? $details['image'] : Storage::url($details['image']) }}" alt="{{ $details['name'] }}" class="h-full w-full object-cover object-center rounded-xl">
                                                    @else
                                                        <div class="h-full w-full bg-beige-50 rounded-xl flex items-center justify-center text-[8px] font-bold text-earth-200">IMG</div>
                                                    @endif
                                                </div>

                                                <div class="ml-5 flex flex-1 flex-col justify-center">
                                                    <div>
                                                        <div class="flex justify-between text-sm font-bold text-earth-900 uppercase tracking-tight leading-snug">
                                                            <h3><a href="#">{{ $details['name'] }}</a></h3>
                                                            <p class="ml-4 whitespace-nowrap">{{ number_format($details['price'] * $details['quantity']) }}đ</p>
                                                        </div>
                                                        <p class="text-[10px] text-earth-300 tracking-widest uppercase font-semibold mt-1">Sản phẩm chất lượng</p>
                                                    </div>
                                                    <div class="flex flex-1 items-end justify-between text-sm mt-4">
                                                        <div class="flex items-center space-x-4 bg-white border border-beige-200 rounded-full px-4 py-1.5 shadow-sm">
                                                            <form action="{{ route('cart.update') }}" method="POST" class="m-0">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="id" value="{{ $id }}">
                                                                <input type="hidden" name="quantity" value="{{ $details['quantity'] - 1 }}">
                                                                <button type="submit" class="text-earth-300 hover:text-earth-900 font-bold px-2" {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                                            </form>
                                                            <span class="text-earth-900 font-black text-[11px]">{{ $details['quantity'] }}</span>
                                                            <form action="{{ route('cart.update') }}" method="POST" class="m-0">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="id" value="{{ $id }}">
                                                                <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                                                <button type="submit" class="text-earth-300 hover:text-earth-900 font-bold px-2">+</button>
                                                            </form>
                                                        </div>

                                                        <form action="{{ route('cart.remove') }}" method="POST" class="m-0">
                                                            @csrf @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <button type="submit" class="font-bold text-[10px] uppercase tracking-widest text-earth-200 hover:text-red-500 transition-colors">Xóa</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        
                                        @if(empty($cart))
                                            <div class="py-16 text-center">
                                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-earth-200 shadow-sm">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                                </div>
                                                <p class="text-earth-400 font-serif italic text-xl pb-6">Tuyển chọn hiện đang trống</p>
                                                <button @click="showDrawer = false" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white bg-sepia-500 hover:bg-sepia-600 px-8 py-4 rounded-full shadow-lg transition">Tiếp tục khám phá</button>
                                            </div>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Upsell Section (Best Match) -->
                            @if($recommendation && !empty($cart))
                            <div class="mt-16 pt-10 border-t border-beige-200 relative">
                                <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-beige-50 px-4 text-[9px] font-bold uppercase tracking-[0.3em] text-earth-300">Gợi ý tác phẩm hoàn hảo</span>
                                
                                <div class="bg-white rounded-[2rem] p-5 shadow-[0_10px_30px_-15px_rgba(45,26,15,0.1)] border border-beige-100 flex items-center space-x-5 hover:border-sepia-200 transition duration-500 group">
                                    <div class="h-20 w-20 bg-beige-50 rounded-2xl overflow-hidden shrink-0 group-hover:scale-105 transition duration-700">
                                        @if($recommendation->image)
                                            <img src="{{ Str::startsWith($recommendation->image, 'http') ? $recommendation->image : Storage::url($recommendation->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <h4 class="text-xs font-bold text-earth-900 truncate uppercase tracking-wide">{{ $recommendation->name }}</h4>
                                        <p class="text-[9px] text-earth-400 mt-1 uppercase tracking-[0.2em]">BST Tuyệt tác</p>
                                        <p class="text-sm font-black text-sepia-600 mt-1">{{ number_format($recommendation->sale_price ?: $recommendation->price) }} đ</p>
                                    </div>
                                    <div>
                                        <form action="{{ route('cart.add', $recommendation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-beige-50 text-earth-900 hover:bg-earth-900 hover:text-white transition-all duration-300 font-black border border-beige-200 shadow-sm rounded-xl w-10 h-10 flex items-center justify-center">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Footer w/ Total -->
                        @if(!empty($cart))
                        <div class="bg-white px-6 py-8 sm:px-10 shadow-[0_-20px_40px_-20px_rgba(0,0,0,0.05)] z-10 relative">
                            <div class="flex justify-between items-end text-base font-medium text-earth-900 mb-6">
                                <p class="font-serif italic text-2xl text-earth-400">Total</p>
                                <div class="text-right">
                                    @if($bestDiscount > 0)
                                        <span class="text-sm text-earth-300 line-through mr-2">{{ number_format($cartTotal) }}đ</span>
                                        <span class="font-bold text-3xl tracking-tighter text-sepia-600">{{ number_format($finalTotal) }}đ</span>
                                    @else
                                        <span class="font-bold text-3xl tracking-tighter">{{ number_format($cartTotal) }}đ</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <a href="{{ route('cart.index') }}" class="flex flex-col items-center justify-center rounded-[2rem] border border-transparent bg-earth-900 px-6 py-4 text-xs font-bold tracking-[0.2em] uppercase text-white shadow-2xl hover:-translate-y-1 hover:shadow-earth-900/30 transition-all duration-500 text-center w-full">
                                    <span class="text-[13px] mb-1 tracking-[0.3em]">Thanh toán ngay</span>
                                    @if($bestDiscount > 0)
                                        <span class="text-[10px] text-earth-200 mt-1 font-sans tracking-wide">
                                            {{ number_format($finalTotal) }}đ <span class="line-through text-earth-400 ml-1">{{ number_format($cartTotal) }}đ</span>
                                        </span>
                                    @endif
                                </a>
                            </div>
                            
                            @if($bestDiscount > 0)
                                <div class="mt-4 flex justify-center text-center text-[10px] font-bold text-earth-600 tracking-[0.1em] gap-2">
                                    <p>🎉 Bạn đã tiết kiệm được <span class="text-sepia-600">{{ number_format($bestDiscount) }}đ</span></p>
                                </div>
                            @elseif($hasFreeship)
                                <div class="mt-4 flex justify-center text-center text-[10px] font-bold text-earth-600 tracking-[0.1em] gap-2">
                                    <p>🎉 Bạn đã được MIỄN PHÍ VẬN CHUYỂN</p>
                                </div>
                            @else
                                <div class="mt-6 flex justify-center text-center text-[9px] uppercase font-bold text-earth-300 tracking-[0.2em] gap-2">
                                    <p><span aria-hidden="true" class="text-sepia-400 text-base">✨</span> Mua thêm để nhận ưu đãi hấp dẫn</p>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
