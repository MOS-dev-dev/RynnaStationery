<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Đơn hàng') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4 uppercase text-sm font-bold text-gray-600">ID</th>
                                <th class="border-b py-2 px-4 uppercase text-sm font-bold text-gray-600">Khách hàng</th>
                                <th class="border-b py-2 px-4 uppercase text-sm font-bold text-gray-600">Tổng tiền</th>
                                <th class="border-b py-2 px-4 uppercase text-sm font-bold text-gray-600">Ngày đặt</th>
                                <th class="border-b py-2 px-4 uppercase text-sm font-bold text-gray-600">Trạng thái</th>
                                <th class="border-b py-2 px-4 uppercase text-sm font-bold text-gray-600">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="border-b py-2 px-4">#{{ $order->id }}</td>
                                    <td class="border-b py-2 px-4">{{ $order->user->name }}</td>
                                    <td class="border-b py-2 px-4">{{ number_format($order->total_price) }} đ</td>
                                    <td class="border-b py-2 px-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="border-b py-2 px-4">
                                        @if($order->status === 'Pending')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">Chờ xử lý</span>
                                        @elseif($order->status === 'Shipping')
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">Đang giao</span>
                                        @elseif($order->status === 'Completed')
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded">Hoàn thành</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td class="border-b py-2 px-4">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-500 hover:underline">Chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
