<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-sepia-600 leading-tight">
            {{ __('Quản lý Flash Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-beige-200">
                <div class="p-6 text-earth-500">
                    <p class="mb-6 text-sm text-earth-300 italic">* Bật Flash Sale để sản phẩm hiển thị nổi bật tại trang chủ với đồng hồ đếm ngược.</p>
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 text-green-600 rounded-lg border border-green-100 font-medium">{{ session('success') }}</div>
                    @endif

                    <div class="mb-8 flex justify-between items-center p-4 bg-beige-50/50 rounded-2xl border border-beige-100">
                        <div>
                            <h3 class="text-xs font-bold text-earth-800 uppercase tracking-widest uppercase tracking-widest">Quản lý nâng cao</h3>
                            <p class="text-[10px] text-earth-300 italic mt-1">Quản lý và cập nhật thời gian hàng loạt cho các hàng hóa đang chạy Flash Sale.</p>
                        </div>
                        <a href="{{ route('admin.flash_sale.active') }}" class="bg-earth-900 text-white px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-sepia-600 transition-all shadow-lg shadow-earth-900/10">
                            Cập nhật hàng hóa đang Flash Sale →
                        </a>
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-beige-50">
                                <th class="border-b border-beige-200 py-4 px-4 text-sepia-600 font-bold uppercase text-xs tracking-widest">Sản phẩm</th>
                                <th class="border-b border-beige-200 py-4 px-4 text-sepia-600 font-bold uppercase text-xs tracking-widest">Giá gốc</th>
                                <th class="border-b border-beige-200 py-4 px-4 text-sepia-600 font-bold uppercase text-xs tracking-widest">Giá KM (Flash Sale)</th>
                                <th class="border-b border-beige-200 py-4 px-4 text-sepia-600 font-bold uppercase text-xs tracking-widest">Ngày kết thúc</th>
                                <th class="border-b border-beige-200 py-4 px-4 text-sepia-600 font-bold uppercase text-xs tracking-widest">Trạng thái</th>
                                <th class="border-b border-beige-200 py-4 px-4 text-sepia-600 font-bold uppercase text-xs tracking-widest text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="hover:bg-beige-50/50 transition" x-data="{ editing: false }">
                                <td class="border-b border-beige-100 py-4 px-4">
                                    <div class="flex items-center space-x-4">
                                        @if($product->image)
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : Storage::url($product->image) }}" class="w-12 h-12 object-cover rounded-lg shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-beige-100 rounded-lg"></div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-earth-600">{{ $product->name }}</div>
                                            <div class="text-[10px] text-earth-300 uppercase">{{ $product->category->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-beige-100 py-4 px-4 text-sm font-medium">
                                    {{ number_format($product->price) }}đ
                                </td>
                                <td class="border-b border-beige-100 py-4 px-4 text-sm">
                                    <div x-show="!editing">
                                        @if($product->sale_price)
                                            <span class="text-red-500 font-bold">{{ number_format($product->sale_price) }}đ</span>
                                        @else
                                            <span class="text-earth-200 italic">Chưa đặt</span>
                                        @endif
                                    </div>
                                    <div x-show="editing" x-cloak>
                                        <input type="number" form="update-form-{{ $product->id }}" name="sale_price" value="{{ $product->sale_price }}" class="w-full text-xs border-beige-200 rounded-md focus:ring-sepia-500 focus:border-sepia-500 p-1">
                                    </div>
                                </td>
                                <td class="border-b border-beige-100 py-4 px-4 text-xs font-medium">
                                    <div x-show="!editing">
                                        @if($product->flash_sale_end)
                                            <span class="{{ \Carbon\Carbon::parse($product->flash_sale_end)->isPast() ? 'text-red-400' : 'text-earth-500' }}">
                                                {{ \Carbon\Carbon::parse($product->flash_sale_end)->format('H:i d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-earth-200 italic">Chưa đặt</span>
                                        @endif
                                    </div>
                                    <div x-show="editing" x-cloak>
                                        <input type="datetime-local" form="update-form-{{ $product->id }}" name="flash_sale_end" value="{{ $product->flash_sale_end ? \Carbon\Carbon::parse($product->flash_sale_end)->format('Y-m-d\TH:i') : '' }}" class="w-full text-[10px] border-beige-200 rounded-md focus:ring-sepia-500 focus:border-sepia-500 p-1">
                                    </div>
                                </td>
                                <td class="border-b border-beige-100 py-4 px-4">
                                    @if($product->is_flash_sale)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 {{ \Carbon\Carbon::parse($product->flash_sale_end)->isFuture() ? 'animate-pulse' : '' }}">
                                            ⚡ {{ \Carbon\Carbon::parse($product->flash_sale_end)->isPast() ? 'HẾT HẠN' : 'FLASH SALE' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-beige-200 text-earth-400">
                                            THƯỜNG
                                        </span>
                                    @endif
                                </td>
                                <td class="border-b border-beige-100 py-4 px-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <form id="update-form-{{ $product->id }}" action="{{ route('admin.flash_sale.update', $product->id) }}" method="POST">
                                            @csrf
                                        </form>
                                        
                                        <button x-show="!editing" @click="editing = true" class="p-2 text-earth-400 hover:text-sepia-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        <div x-show="editing" x-cloak class="flex space-x-2">
                                            <button form="update-form-{{ $product->id }}" type="submit" class="bg-green-500 text-white p-1 rounded-md hover:bg-green-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                            <button @click="editing = false" class="bg-gray-400 text-white p-1 rounded-md hover:bg-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>

                                        <form action="{{ route('admin.flash_sale.toggle', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider transition {{ $product->is_flash_sale ? 'bg-earth-100 text-earth-400 hover:bg-earth-200' : 'bg-red-500 text-white hover:bg-red-600 shadow-sm' }}">
                                                {{ $product->is_flash_sale ? 'Hủy' : 'Bật' }}
                                            </button>
                                        </form>
                                    </div>
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
