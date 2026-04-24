<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Sản phẩm') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-4 inline-block">Thêm Sản phẩm</a>
                    
                    @if(session('success'))
                        <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
                    @endif

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm">ID</th>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm">Hình ảnh</th>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm">Tên</th>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm">Giá</th>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm">Danh mục</th>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm">Tồn kho</th>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="border-b py-2">{{ $product->id }}</td>
                                <td class="border-b py-2">
                                    @if($product->image)
                                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : Storage::url($product->image) }}" class="w-16 h-16 object-cover rounded">
                                    @else
                                        <span class="text-gray-400">Không có</span>
                                    @endif
                                </td>
                                <td class="border-b py-2">{{ $product->name }}</td>
                                <td class="border-b py-2">{{ number_format($product->price) }} đ</td>
                                <td class="border-b py-2">{{ $product->category->name }}</td>
                                <td class="border-b py-2">{{ $product->stock }}</td>
                                <td class="border-b py-2 text-right">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Sửa</a> |
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                    </form>
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
