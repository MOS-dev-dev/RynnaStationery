<x-app-layout>
    <div class="bg-beige-50 min-h-screen py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-serif text-earth-900 tracking-tighter">Chi tiết đơn hàng #{{ $order->id }}</h1>
                    <p class="text-earth-400 mt-1 text-sm">Đặt t?ng ngày {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <a href="{{ route('orders.index') }}" class="text-sm font-bold text-sepia-600 hover:text-sepia-800 uppercase tracking-widest">< Trở lại danh sách</a>
            </div>

            <!-- Cập nhật Hành trình Giao hàng (Shopee-style) -->
            
            <!-- Leaflet Map Tracker -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <div id="tracking-map" class="w-full h-80 bg-beige-50 rounded-[2rem] shadow-sm border border-beige-100 mb-8 z-0 relative overflow-hidden">
                <!-- Map will mount here -->
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-beige-100 p-8 mb-8">
                <h3 class="text-xs font-bold text-earth-300 uppercase tracking-widest mb-8 border-b border-beige-50 pb-4">Cập nhật Hành trình</h3>
                
                @if($order->status === 'Canceled')
                    <div class="bg-red-50 text-red-600 p-6 rounded-2xl text-center font-bold">
                        Đơn hàng này đã bị huỷ.
                    </div>
                @else
                    <div class="relative border-l-2 border-sepia-100 ml-4">
                        @forelse($order->timelines as $index => $timeline)
                            <div class="mb-8 ml-8 relative">
                                <!-- Điểm mốc -->
                                <span class="absolute -left-[41px] flex items-center justify-center w-5 h-5 rounded-full border-4 border-white transition-all {{ $index === 0 ? 'bg-sepia-500 scale-125 shadow-md shadow-sepia-500/30' : 'bg-earth-200' }}"></span>
                                <!-- Nội dung -->
                                <h4 class="font-bold {{ $index === 0 ? 'text-sepia-600 text-lg' : 'text-earth-600' }} tracking-tight mb-1">{{ $timeline->title }}</h4>
                                @if($timeline->description)
                                    <p class="text-sm {{ $index === 0 ? 'text-earth-600' : 'text-earth-400' }} mb-2">{{ $timeline->description }}</p>
                                @endif
                                <span class="text-xs font-bold text-earth-300">{{ $timeline->created_at->format('H:i - d/m/Y') }}</span>
                            </div>
                        @empty
                            <div class="ml-8 italic text-sm text-earth-400">Lịch trình bưu kiện chưa được cập nhật. Cảm phiền bạn chờ chút nhé.</div>
                        @endforelse
                    </div>
                @endif
            </div>

            <!-- Order Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Items -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2rem] shadow-sm border border-beige-100 p-8">
                        <h3 class="text-xs font-bold text-earth-300 uppercase tracking-widest mb-6">Sản phẩm đã đặt</h3>
                        <div class="space-y-6">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between border-b border-beige-50 pb-6 last:border-0 last:pb-0">
                                    <div class="flex items-center space-x-6">
                                        <div class="w-20 h-20 bg-beige-50 rounded-xl overflow-hidden">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : Storage::url($item->product->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[8px] text-earth-300">NO IMG</div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-earth-900">{{ $item->product ? $item->product->name : 'Sản phẩm đã xoá' }}</h4>
                                            <p class="text-xs text-earth-400 mt-1">Số lượng: x{{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <div class="font-bold text-earth-900">
                                        {{ number_format($item->price * $item->quantity) }}đ
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] shadow-sm border border-beige-100 p-8 flex flex-col md:flex-row gap-8">
                        <div class="flex-1">
                            <h3 class="text-xs font-bold text-earth-300 uppercase tracking-widest mb-4">Thông tin giao hàng</h3>
                            <p class="font-bold text-earth-900">{{ $order->customer_name }}</p>
                            <p class="text-sm text-earth-600 mt-1">{{ $order->customer_phone }}</p>
                            <p class="text-sm text-earth-600 mt-1">{{ $order->shipping_address }}</p>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xs font-bold text-earth-300 uppercase tracking-widest mb-4">Thanh toán</h3>
                            <p class="text-sm text-earth-600 mb-2">
                                Phương thức: <strong class="text-earth-900 capitalize">{{ $order->payment_method === 'qr_code' ? 'Chuyển khoản VietQR' : 'Tiền mặt (COD)' }}</strong>
                            </p>
                            
                            <p class="text-sm text-earth-600 mb-4">
                                Trạng thái: 
                                @if($order->payment_status === 'paid')
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 font-bold rounded-full text-xs">Đã Thanh Toán</span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 font-bold rounded-full text-xs">Chưa Thanh Toán</span>
                                @endif
                            </p>

                            @if($order->payment_method === 'qr_code' && $order->payment_status !== 'paid')
                                <a href="{{ route('orders.payment', $order->id) }}" class="inline-block bg-sepia-500 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-sepia-600 uppercase tracking-wider">Mở lại QR Code</a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-earth-900 rounded-[2rem] p-8 text-white sticky top-24">
                        <h3 class="text-xs font-bold text-sepia-400 uppercase tracking-widest mb-8">Tổng quan chi phí</h3>
                        
                        <div class="space-y-6 mb-8 text-sm">
                            <div class="flex justify-between items-center text-earth-300">
                                <span>Tạm tính</span>
                                <span class="text-white">{{ number_format($order->subtotal ?? ($order->total_price - $order->shipping_fee + $order->discount_amount)) }}đ</span>
                            </div>
                            <div class="flex justify-between items-center text-earth-300">
                                <span>Phí vận chuyển</span>
                                <span class="text-white">{{ number_format($order->shipping_fee ?? 30000) }}đ</span>
                            </div>
                            @if($order->discount_amount > 0)
                                <div class="flex justify-between items-center text-sepia-400">
                                    <span>Giảm giá @if($order->voucher_code) ({{ $order->voucher_code }}) @endif</span>
                                    <span>-{{ number_format($order->discount_amount) }}đ</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="pt-6 border-t border-earth-800 flex justify-between items-end">
                            <span class="text-xs font-bold text-sepia-400 uppercase tracking-widest">Tổng cộng</span>
                            <span class="text-3xl font-bold tracking-tighter">{{ number_format($order->total_price) }}đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!document.getElementById('tracking-map')) return;

        // Fixed Store Location (Hanoi)
        const storeLatLng = [21.0285, 105.8542]; 
        // Dummy Customer Location (Da Nang - representing shipping distance)
        const customerLatLng = [16.0544, 108.2022]; 
        
        // Init map
        const map = L.map('tracking-map', {
            zoomControl: false,
            dragging: false,
            scrollWheelZoom: false,
        }).setView([18.5, 107.0], 6);
        
        // Carto light theme map (premium looking)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Custom Icons
        const storeIcon = L.divIcon({ html: '<div class="w-8 h-8 bg-earth-900 text-white rounded-full flex items-center justify-center font-bold shadow-lg border-2 border-white text-xs">KHO</div>', className: '' });
        const customerIcon = L.divIcon({ html: '<div class="w-8 h-8 bg-sepia-200 text-earth-900 rounded-full flex items-center justify-center font-bold shadow-lg border-2 border-white text-xs">NHÀ</div>', className: '' });
        
        L.marker(storeLatLng, {icon: storeIcon}).addTo(map);
        L.marker(customerLatLng, {icon: customerIcon}).addTo(map);

        // Draw curved or straight dashed route line
        L.polyline([storeLatLng, customerLatLng], {color: '#d5b593', weight: 4, dashArray: '10, 15'}).addTo(map);
        
        // Calculate dynamic position based on status
        const status = '{{ $order->status }}'; 
        let progress = 0.05; // Pending - just left store
        
        if (status === 'Shipping') progress = 0.5; // Mid way
        if (status === 'Completed') progress = 1.0; // Arrived
        if (status === 'Canceled') progress = 0.0;
        
        const truckLat = storeLatLng[0] + (customerLatLng[0] - storeLatLng[0]) * progress;
        const truckLng = storeLatLng[1] + (customerLatLng[1] - storeLatLng[1]) * progress;
        
        const truckIcon = L.divIcon({ 
            html: `
            <div class="relative w-14 h-14 flex items-center justify-center -mt-6 -ml-6">
                <div class="absolute inset-0 bg-sepia-500 rounded-full animate-ping opacity-30"></div>
                <div class="relative w-10 h-10 bg-sepia-600 rounded-full text-white flex items-center justify-center shadow-2xl border-4 border-white z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
            </div>`, 
            className: ''
        });
        
        if (status !== 'Canceled') {
            L.marker([truckLat, truckLng], {icon: truckIcon}).addTo(map).bindPopup('Vị trí Bưu kiện', {closeButton: false}).openPopup();
        }

        // Auto zoom to fit nicely
        map.fitBounds([storeLatLng, customerLatLng], {padding: [50, 50]});
    });
    </script>
</x-app-layout>
