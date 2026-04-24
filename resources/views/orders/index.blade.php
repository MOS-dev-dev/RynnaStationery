<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Đơn hàng của bạn') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Lịch sử Đơn hàng</h3>
                    
                    @if($orders->count() > 0)
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                                        <div>
                                            <a href="{{ route('orders.show', $order->id) }}" class="font-bold text-earth-900 hover:text-sepia-600 transition-colors">Mã đơn (#{{ $order->id }})</a>
                                            <span class="text-sm text-gray-500 ml-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <div>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                @if($order->status == 'Pending') bg-yellow-200 text-yellow-800 
                                                @elseif($order->status == 'Shipping') bg-blue-200 text-blue-800
                                                @else bg-green-200 text-green-800 @endif
                                            ">
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <ul class="space-y-2 mb-4">
                                        @foreach($order->orderItems as $item)
                                            <li class="flex justify-between text-sm">
                                                <span>{{ $item->product ? $item->product->name : 'Sản phẩm đã xóa' }} x {{ $item->quantity }}</span>
                                                <span class="font-semibold">{{ number_format($item->price * $item->quantity) }} đ</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    
                                    <div class="border-t pt-4 space-y-2 text-sm">
                                        <div class="flex justify-between text-gray-600 uppercase tracking-widest text-[10px] font-bold">
                                            <span>Tạm tính</span>
                                            <span>{{ number_format($order->subtotal ?? ($order->total_price - $order->shipping_fee + $order->discount_amount)) }} đ</span>
                                        </div>
                                        <div class="flex justify-between text-gray-600 uppercase tracking-widest text-[10px] font-bold">
                                            <span>Phí vận chuyển</span>
                                            <span>+{{ number_format($order->shipping_fee ?? 30000) }} đ</span>
                                        </div>
                                        @if($order->discount_amount > 0)
                                            <div class="flex justify-between text-sepia-600 uppercase tracking-widest text-[10px] font-bold">
                                                <span>Giảm giá @if($order->voucher_code) ({{ $order->voucher_code }}) @endif</span>
                                                <span>-{{ number_format($order->discount_amount) }} đ</span>
                                            </div>
                                        @endif
                                        <div class="flex justify-between items-end border-t border-gray-100 pt-2">
                                            <span class="text-xs font-bold text-gray-900 uppercase tracking-widest">Tổng thanh toán</span>
                                            <span class="text-xl font-bold text-earth-900 tracking-tighter">{{ number_format($order->total_price) }} đ</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Bạn chưa có đơn hàng nào.</p>
                        <a href="{{ route('home') }}" class="text-blue-500 hover:underline mt-2 inline-block">Tiếp tục mua sắm</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
