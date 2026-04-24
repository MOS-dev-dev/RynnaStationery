<x-app-layout>
    <div class="bg-beige-50 min-h-screen">
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="mb-24 text-center">
                <span class="text-sepia-500 font-bold text-[10px] tracking-[0.5em] uppercase mb-4 block">Votre Panier</span>
                <h1 class="text-5xl font-serif text-earth-900 tracking-tighter">Giỏ hàng & Thanh toán</h1>
                <div class="h-px w-24 bg-sepia-500/30 mx-auto mt-8"></div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-100 text-green-600 px-8 py-5 rounded-3xl mb-16 text-sm font-bold tracking-tight animate-fade-in flex items-center">
                    <span class="mr-3">✓</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-100 text-red-600 px-8 py-5 rounded-3xl mb-16 text-sm font-bold tracking-tight animate-fade-in flex items-center">
                    <span class="mr-3">✕</span> {{ session('error') }}
                </div>
            @endif

            @if(count($cart) > 0)
                @php
                    $total = 0;
                    foreach($cart as $item) { $total += $item['price'] * $item['quantity']; }
                    
                    $shippingFee = 30000; // Fixed standard shipping
                    $discount = 0;
                    $shippingDiscount = 0;
                    $voucherLabel = '';

                    if(session()->has('voucher')) {
                        $v = session('voucher');
                        if ($v['type'] == 'percent') {
                            $d = ($total * $v['discount_value']) / 100;
                            if ($v['max_discount'] > 0 && $d > $v['max_discount']) {
                                $d = $v['max_discount'];
                            }
                            $discount = $d;
                            $voucherLabel = 'Giảm ' . round($v['discount_value']) . '%';
                        } elseif ($v['type'] == 'amount') {
                            $discount = $v['discount_value'];
                            $voucherLabel = 'Giảm ' . number_format($v['discount_value']) . 'đ';
                        } elseif ($v['type'] == 'freeship') {
                            $d = $v['discount_value'];
                            if ($v['max_discount'] > 0 && $d > $v['max_discount']) {
                                $d = $v['max_discount'];
                            }
                            $shippingDiscount = min($shippingFee, $d);
                            $voucherLabel = 'Freeship -' . number_format($shippingDiscount) . 'đ';
                        }
                    }
                    
                    $finalTotal = $total + $shippingFee - $discount - $shippingDiscount;
                    if ($finalTotal < 0) $finalTotal = 0;
                @endphp
                <div class="flex flex-col lg:flex-row gap-24 items-start">
                    <!-- Left Column: Checkout Form & Items -->
                    <div class="w-full lg:w-2/3 space-y-20">
                        
                        <!-- 1. Customer Information -->
                        <div class="bg-white rounded-[3rem] p-12 shadow-2xl shadow-earth-900/5 border border-beige-100 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-2 h-full bg-sepia-500"></div>
                            <div class="flex items-center space-x-6 mb-12">
                                <span class="text-4xl font-serif italic text-sepia-200">01</span>
                                <h2 class="text-2xl font-bold text-earth-900 tracking-tight uppercase tracking-widest">Thông tin giao nhận</h2>
                            </div>
                            
                            <form id="checkout-form" action="{{ route('checkout') }}" method="POST" class="space-y-10"
                                  x-data="{ 
                                      name: localStorage.getItem('checkout_name') || '',
                                      phone: localStorage.getItem('checkout_phone') || '',
                                      address: localStorage.getItem('checkout_address') || ''
                                  }">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                    <div class="space-y-3">
                                        <label class="text-[9px] font-bold text-earth-300 uppercase tracking-widest ml-1">Danh tính người nhận</label>
                                        <input type="text" name="customer_name" required placeholder="Họ và tên của bạn" 
                                               x-model="name" @input="localStorage.setItem('checkout_name', name)"
                                               class="w-full bg-beige-50 border-transparent rounded-2xl px-6 py-5 text-sm font-medium focus:ring-sepia-500 focus:bg-white transition duration-500 placeholder-earth-100">
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[9px] font-bold text-earth-300 uppercase tracking-widest ml-1">Số điện thoại liên lạc</label>
                                        <input type="tel" name="customer_phone" required placeholder="Số điện thoại chính chủ" 
                                               x-model="phone" @input="localStorage.setItem('checkout_phone', phone)"
                                               class="w-full bg-beige-50 border-transparent rounded-2xl px-6 py-5 text-sm font-medium focus:ring-sepia-500 focus:bg-white transition duration-500 placeholder-earth-100">
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[9px] font-bold text-earth-300 uppercase tracking-widest ml-1">Địa chỉ nhận hàng chi tiết</label>
                                    <textarea name="shipping_address" required rows="3" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..." 
                                              x-model="address" @input="localStorage.setItem('checkout_address', address)"
                                              class="w-full bg-beige-50 border-transparent rounded-2xl px-6 py-5 text-sm font-medium focus:ring-sepia-500 focus:bg-white transition duration-500 placeholder-earth-100"></textarea>
                                </div>
                                
                                <div class="space-y-4 pt-4 border-t border-beige-100">
                                    <label class="text-[9px] font-bold text-earth-300 uppercase tracking-widest ml-1">Phương thức thanh toán</label>
                                    <div class="flex flex-col space-y-4">
                                        <label class="flex items-center space-x-4 cursor-pointer group">
                                            <div class="relative flex items-center justify-center">
                                                <input type="radio" name="payment_method" value="cod" checked class="peer sr-only">
                                                <div class="w-5 h-5 rounded-full border-2 border-beige-200 peer-checked:border-sepia-500 peer-checked:bg-sepia-500 transition-all"></div>
                                                <div class="absolute w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-all"></div>
                                            </div>
                                            <span class="text-sm font-bold text-earth-900 group-hover:text-sepia-600 transition-colors">Thanh toán khi nhận hàng (COD)</span>
                                        </label>
                                        <label class="flex items-center space-x-4 cursor-pointer group">
                                            <div class="relative flex items-center justify-center">
                                                <input type="radio" name="payment_method" value="qr_code" class="peer sr-only">
                                                <div class="w-5 h-5 rounded-full border-2 border-beige-200 peer-checked:border-sepia-500 peer-checked:bg-sepia-500 transition-all"></div>
                                                <div class="absolute w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-all"></div>
                                            </div>
                                            <span class="text-sm font-bold text-earth-900 group-hover:text-sepia-600 transition-colors">Chuyển khoản QR Code (VietQR)</span>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- 2. Cart Content Table -->
                        <div class="space-y-12">
                            <div class="flex items-center space-x-6 mb-10 pl-4">
                                <span class="text-4xl font-serif italic text-sepia-200">02</span>
                                <h2 class="text-2xl font-bold text-earth-900 tracking-tight uppercase tracking-widest">Tuyển chọn của bạn</h2>
                            </div>
                            
                            <div class="space-y-8">
                                @foreach($cart as $id => $details)
                                    <div class="bg-white rounded-[2.5rem] p-8 flex items-center justify-between group hover:shadow-xl transition duration-700 border border-beige-50">
                                        <div class="flex items-center space-x-10">
                                            <div class="w-32 h-32 bg-beige-50 rounded-3xl overflow-hidden relative">
                                                @if($details['image'])
                                                    <img src="{{ Str::startsWith($details['image'], 'http') ? $details['image'] : Storage::url($details['image']) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-[8px] font-bold uppercase tracking-widest text-earth-100 italic">Atelier Piece</div>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-bold text-earth-900 mb-3 tracking-tight">{{ $details['name'] }}</h3>
                                                <div class="flex items-center space-x-8">
                                                    <div class="flex items-center bg-beige-50 rounded-full px-4 py-2 space-x-6 border border-beige-100">
                                                        <form action="{{ route('cart.update') }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] - 1 }}">
                                                            <button type="submit" class="text-earth-300 hover:text-earth-900 transition font-bold" {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                                        </form>
                                                        <span class="text-xs font-bold text-earth-900 min-w-[1rem] text-center">{{ $details['quantity'] }}</span>
                                                        <form action="{{ route('cart.update') }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                                            <button type="submit" class="text-earth-300 hover:text-earth-900 transition font-bold">+</button>
                                                        </form>
                                                    </div>
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        <button type="submit" class="text-[9px] font-bold text-red-300 hover:text-red-500 uppercase tracking-widest transition-all">Gỡ bỏ</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right pr-6">
                                            <p class="text-2xl font-bold text-earth-900 tracking-tighter">{{ number_format($details['price'] * $details['quantity']) }}đ</p>
                                            <p class="text-[9px] text-earth-200 font-bold uppercase tracking-widest mt-1">{{ number_format($details['price']) }}đ / sản phẩm</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Summary -->
                    <div class="w-full lg:w-1/3 sticky top-32">
                        <!-- Voucher Card -->
                        <div class="bg-white rounded-[3rem] p-10 shadow-2xl shadow-earth-900/5 border border-beige-100 mb-10">
                            <h3 class="text-[10px] font-bold text-earth-300 uppercase tracking-[0.4em] mb-10">Mã giảm giá</h3>
                            @if(session()->has('voucher'))
                                <div class="bg-sepia-50 p-6 rounded-3xl flex items-center justify-between border border-sepia-100">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-sepia-500 rounded-2xl flex items-center justify-center text-white font-bold italic serif">V</div>
                                        <div>
                                            <p class="text-sm font-bold text-sepia-600 uppercase tracking-widest">{{ session('voucher')['code'] }}</p>
                                            <p class="text-[9px] font-medium text-earth-300">{{ $voucherLabel }} Exclusive</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.voucher.remove') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-300 hover:text-red-500 transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('cart.voucher.apply') }}" method="POST" class="relative group">
                                    @csrf
                                    <input type="text" name="code" placeholder="ENTER CODE" 
                                           class="w-full bg-beige-50 border-transparent rounded-2xl px-6 py-6 text-sm font-bold tracking-[0.2em] placeholder-earth-100 focus:ring-sepia-500 focus:bg-white transition-all uppercase">
                                    <button type="submit" class="absolute right-3 top-3 bottom-3 bg-earth-900 text-white px-8 rounded-xl text-[9px] font-bold uppercase tracking-widest hover:bg-sepia-500 transition-all duration-500 shadow-xl shadow-earth-900/20">Áp dụng</button>
                                </form>
                            @endif
                        </div>

                        <!-- Summary Card -->
                        <div class="bg-earth-900 rounded-[3rem] p-12 text-white shadow-[0_40px_80px_-15px_rgba(45,26,15,0.4)] relative overflow-hidden">
                            <div class="absolute -top-20 -right-20 w-64 h-64 bg-sepia-500/10 rounded-full blur-3xl"></div>
                            
                            <h3 class="text-[10px] font-bold text-sepia-400 uppercase tracking-[0.5em] mb-16">Bill Finalisé</h3>

                            <div class="space-y-8 mb-16 relative z-10">
                                <div class="flex justify-between items-center text-xs font-bold uppercase tracking-widest text-earth-400">
                                    <span>Tạm tính</span>
                                    <span class="text-white">{{ number_format($total) }}đ</span>
                                </div>
                                <div class="flex justify-between items-center text-xs font-bold uppercase tracking-widest text-earth-400">
                                    <span>Phí giao hàng</span>
                                    <span class="text-white">{{ number_format($shippingFee) }}đ</span>
                                </div>
                                @if($discount > 0)
                                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-widest text-sepia-400">
                                        <span>Ưu đãi ({{ session('voucher')['code'] }})</span>
                                        <span>-{{ number_format($discount) }}đ</span>
                                    </div>
                                @endif
                                @if($shippingDiscount > 0)
                                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-widest text-green-400">
                                        <span>Freeship</span>
                                        <span>-{{ number_format($shippingDiscount) }}đ</span>
                                    </div>
                                @endif
                                <div class="pt-10 border-t border-earth-800 flex justify-between items-end">
                                    <span class="text-[9px] font-bold text-sepia-400 uppercase tracking-[0.3em] mb-1">Tổng cộng</span>
                                    <span class="text-5xl font-bold tracking-tighter text-white">{{ number_format($finalTotal) }}đ</span>
                                </div>
                            </div>

                            <button type="button" onclick="document.getElementById('checkout-form').submit()" 
                                    class="w-full bg-sepia-500 hover:bg-sepia-600 text-white py-8 rounded-[2rem] text-[11px] font-bold uppercase tracking-[0.5em] transition-all duration-700 shadow-2xl shadow-sepia-500/30 hover:-translate-y-2 active:scale-95">
                                Thanh toán
                            </button>
                            
                            <p class="mt-10 text-center text-[8px] font-bold text-earth-600 uppercase tracking-[0.3em]">Secure Checkout by Rynna Atelier</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="py-48 text-center bg-white rounded-[4rem] border border-beige-100 shadow-sm relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-beige-50/50 via-transparent to-transparent"></div>
                    <div class="relative z-10 max-w-sm mx-auto">
                        <div class="w-24 h-24 bg-beige-50 rounded-full flex items-center justify-center mx-auto mb-10 text-sepia-200 italic font-serif text-4xl">!</div>
                        <h2 class="text-3xl font-serif text-earth-900 mb-6 tracking-tight">Giỏ hàng chưa có tác phẩm nào</h2>
                        <a href="{{ route('home') }}" class="btn-sepia px-12 py-5 inline-block mt-4">Trở về cửa hàng</a>
                    </div>
                </div>
            @endif
        </main>
    </div>
</x-app-layout>
