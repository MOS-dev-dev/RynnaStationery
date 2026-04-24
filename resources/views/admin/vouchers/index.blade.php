<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Mã Giảm Giá') }}
            </h2>
            <a href="{{ route('admin.vouchers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Tạo Mã Mới
            </a>
        </div>
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
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Mã Khuyến Mãi</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Loại</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Chiết khấu</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Đơn tối thiểu</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Sử dụng</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Hạn dùng</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vouchers as $voucher)
                                <tr class="border-b">
                                    <td class="py-3 px-4 font-mono font-bold text-indigo-600">
                                        {{ $voucher->code }}
                                        @if($voucher->is_for_new_user)
                                            <span class="inline-block relative -top-1 ml-1 px-2 py-[2px] bg-red-100 text-red-600 border border-red-200 text-[10px] rounded-full">NEW</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-sm font-medium">
                                        @if($voucher->type == 'percent')
                                            <span class="text-blue-500 bg-blue-50 px-2 py-1 rounded">Percent</span>
                                        @elseif($voucher->type == 'amount')
                                            <span class="text-emerald-500 bg-emerald-50 px-2 py-1 rounded">Amount</span>
                                        @else
                                            <span class="text-amber-600 bg-amber-50 px-2 py-1 rounded">Freeship</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-semibold">
                                        @if($voucher->type == 'percent')
                                            {{ round($voucher->discount_value) }}%
                                            @if($voucher->max_discount) <br><span class="text-xs text-gray-500 font-normal">Tối đa {{ number_format($voucher->max_discount) }} đ</span> @endif
                                        @elseif($voucher->type == 'amount')
                                            {{ number_format($voucher->discount_value) }} đ
                                        @elseif($voucher->type == 'freeship')
                                            -{{ number_format($voucher->discount_value) }} đ <br><span class="text-xs text-gray-500 font-normal">vào Phí vận chuyển</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ number_format($voucher->min_order_value) }} đ</td>
                                    <td class="py-3 px-4">
                                        {{ $voucher->used_count }} / {{ $voucher->usage_limit ?: '∞' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $voucher->expires_at ? \Carbon\Carbon::parse($voucher->expires_at)->format('d/m/Y') : 'Không giới hạn' }}
                                    </td>
                                    <td class="py-3 px-4 flex items-center space-x-2">
                                        <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="text-blue-500 hover:text-blue-700 font-medium">Sửa</a>
                                        <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium" onclick="return confirm('Xóa mã này vĩnh viễn?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if($vouchers->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">Chưa có mã giảm giá nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
