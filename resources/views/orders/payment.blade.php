<x-app-layout>
    <div class="bg-beige-50 min-h-screen py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-beige-100 p-8 text-center">
                <span class="text-sepia-500 font-bold text-[10px] tracking-[0.5em] uppercase mb-4 block">Thanh toán đơn hàng</span>
                <h1 class="text-3xl font-serif text-earth-900 tracking-tighter mb-2">Chuyển khoản QR Code</h1>
                <p class="text-earth-400 text-sm mb-8">Vui lòng sử dụng ứng dụng Ngân hàng của bạn để quét mã QR bên dưới.</p>
                
                <div class="bg-beige-50 rounded-[2rem] p-8 inline-block mb-8">
                    @php
                        // Cấu hình ngân hàng mặc định (bạn có thể thay đổi sau)
                        $bank_id = 'vcb'; // Vietcombank
                        $account_no = '111111'; // Số tài khoản
                        $account_name = 'CTY TNHH STATIONERY'; // Tên chủ tài khoản
                        $amount = $order->total_price;
                        $description = 'DH' . $order->id;
                        $qr_url = "https://img.vietqr.io/image/{$bank_id}-{$account_no}-compact2.png?amount={$amount}&addInfo={$description}&accountName=" . urlencode($account_name);
                    @endphp
                    
                    <img src="{{ $qr_url }}" alt="QR Code Payment" class="w-64 h-64 object-contain mx-auto rounded-xl shadow-sm bg-white p-2">
                </div>

                <div class="text-left bg-earth-900 rounded-[1.5rem] p-6 mb-8 text-white">
                    <h3 class="text-xs font-bold text-sepia-400 uppercase tracking-widest mb-4">Chi tiết thanh toán</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-earth-300 text-sm">Mã đơn hàng:</span>
                            <span class="font-bold">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-earth-300 text-sm">Số tiền cần thanh toán:</span>
                            <span class="font-bold text-xl">{{ number_format($order->total_price) }}đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-earth-300 text-sm">Nội dung chuyển khoản:</span>
                            <span class="font-bold text-sepia-400">{{ $description }}</span>
                        </div>
                    </div>
                </div>

                <p class="text-sm text-earth-500 mb-8 max-w-sm mx-auto">
                    Hệ thống sẽ tự động xác nhận đơn hàng sau khi nhận được khoản thanh toán. Bạn cũng có thể xem trạng thái tại trang Theo dõi đơn hàng.
                </p>

                <div class="flex space-x-4 justify-center">
                    <a href="{{ route('orders.show', $order->id) }}" class="bg-sepia-500 hover:bg-sepia-600 text-white px-8 py-4 rounded-full text-xs font-bold uppercase tracking-widest transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                        Tôi đã thanh toán
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
