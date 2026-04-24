<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Tồn Kho (Inventory)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Lập phiếu nhập hàng</h3>
                    <form action="{{ route('admin.inventory.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mặt hàng cần nhập</label>
                            <select name="product_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">-- Chọn Sản Phẩm --</option>
                                @foreach($products as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Số lượng</label>
                            <input type="number" name="quantity" min="1" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="VD: 50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Giá nhập (Optional)</label>
                            <input type="number" name="import_price" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="VD: 15000">
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                                + Nhập Hàng
                            </button>
                        </div>
                        <div class="md:col-span-5 mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú nguồn hàng</label>
                            <input type="text" name="note" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ví dụ: Lô hàng nhà cung cấp A ngày 15/05">
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Danh sách Mức Tồn Kho</h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Sản phẩm</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase text-center">Tồn kho hiện tại</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase text-center">Tổng đã nhập</th>
                                <th class="py-3 px-4 font-bold text-sm text-gray-600 uppercase">Tình trạng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="border-b">
                                    <td class="py-3 px-4 flex items-center">
                                        @if($product->image)
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : Storage::url($product->image) }}" class="w-10 h-10 rounded object-cover mr-3 pr-0">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded mr-3"></div>
                                        @endif
                                        <span class="font-medium">{{ $product->name }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-center font-bold text-lg {{ $product->stock < 10 ? 'text-red-500' : 'text-green-600' }}">
                                        {{ $product->stock }}
                                    </td>
                                    <td class="py-3 px-4 text-center text-gray-500">
                                        {{ $product->product_imports_sum_quantity ?? 0 }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($product->stock < 1)
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full font-bold">Hết hàng</span>
                                        @elseif($product->stock < 10)
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full font-bold">Sắp hết</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full font-bold">Đủ hàng</span>
                                        @endif
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
