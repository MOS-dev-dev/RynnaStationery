<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-sepia-600 leading-tight">
                {{ __('Quản lý sản phẩm đang Flash Sale') }}
            </h2>
            <a href="{{ route('admin.flash_sale.index') }}" class="text-xs font-bold uppercase tracking-widest text-earth-400 hover:text-sepia-600 transition">
                ← Quay lại danh sách tổng
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Batch Update Tool -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-100 bg-gradient-to-r from-red-50/30 to-white">
                <div class="p-6">
                    <h3 class="text-sm font-bold text-red-600 uppercase tracking-[0.2em] mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Cập nhật thời gian đồng loạt
                    </h3>
                    <form action="{{ route('admin.flash_sale.batch_update') }}" method="POST" class="flex flex-col sm:flex-row items-end space-y-4 sm:space-y-0 sm:space-x-4">
                        @csrf
                        <div class="flex-1 w-full">
                            <label class="block text-[10px] font-bold text-earth-400 uppercase tracking-widest mb-2">Đặt thời gian kết thúc chung cho {{ count($products) }} sản phẩm</label>
                            <input type="datetime-local" name="flash_sale_end" required class="w-full border-beige-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition-all shadow-sm">
                        </div>
                        <button type="submit" class="bg-red-500 text-white px-8 py-3 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-red-600 transition-all shadow-lg shadow-red-500/20 whitespace-nowrap">
                            Cập nhật toàn bộ
                        </button>
                    </form>
                    <p class="mt-4 text-[10px] text-earth-300 italic">* Hành động này sẽ ghi đè thời gian kết thúc của tất cả sản phẩm đang trong danh sách dưới đây.</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-beige-200">
                <div class="p-6 text-earth-500">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-600 rounded-xl border border-green-100 font-medium text-sm flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(count($products) > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-beige-50/50">
                                <th class="border-b border-beige-200 py-5 px-4 text-sepia-600 font-bold uppercase text-[10px] tracking-widest">Sản phẩm</th>
                                <th class="border-b border-beige-200 py-5 px-4 text-sepia-600 font-bold uppercase text-[10px] tracking-widest">Giá KM hiện tại</th>
                                <th class="border-b border-beige-200 py-5 px-4 text-sepia-600 font-bold uppercase text-[10px] tracking-widest">Ngày kết thúc</th>
                                <th class="border-b border-beige-200 py-5 px-4 text-sepia-600 font-bold uppercase text-[10px] tracking-widest">Tiến độ</th>
                                <th class="border-b border-beige-200 py-5 px-4 text-sepia-600 font-bold uppercase text-[10px] tracking-widest text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="group hover:bg-beige-50/30 transition" x-data="{ editing: false }">
                                <td class="border-b border-beige-100 py-5 px-4">
                                    <div class="flex items-center space-x-4">
                                        @if($product->image)
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : Storage::url($product->image) }}" class="w-14 h-14 object-cover rounded-xl shadow-sm border border-beige-100">
                                        @else
                                            <div class="w-14 h-14 bg-beige-50 rounded-xl flex items-center justify-center text-earth-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-earth-700 group-hover:text-sepia-600 transition">{{ $product->name }}</div>
                                            <div class="text-[9px] text-earth-300 uppercase tracking-widest mt-1">{{ $product->category->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-beige-100 py-5 px-4">
                                    <div x-show="!editing" class="flex flex-col">
                                        <span class="text-red-600 font-bold text-base">{{ number_format($product->sale_price) }}đ</span>
                                        <span class="text-[10px] text-earth-200 line-through">{{ number_format($product->price) }}đ</span>
                                    </div>
                                    <div x-show="editing" x-cloak>
                                        <input type="number" form="update-form-{{ $product->id }}" name="sale_price" value="{{ $product->sale_price }}" class="w-32 text-sm border-beige-200 rounded-lg focus:ring-sepia-500 focus:border-sepia-500 p-2">
                                    </div>
                                </td>
                                <td class="border-b border-beige-100 py-5 px-4">
                                    <div x-show="!editing">
                                        @if($product->flash_sale_end)
                                            <div class="flex items-center text-sm {{ \Carbon\Carbon::parse($product->flash_sale_end)->isPast() ? 'text-red-400' : 'text-earth-600' }}">
                                                <svg class="w-4 h-4 mr-1.5 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ \Carbon\Carbon::parse($product->flash_sale_end)->format('H:i d/m/Y') }}
                                            </div>
                                        @else
                                            <span class="text-earth-200 italic text-sm">Chưa đặt thời hạn</span>
                                        @endif
                                    </div>
                                    <div x-show="editing" x-cloak>
                                        <input type="datetime-local" form="update-form-{{ $product->id }}" name="flash_sale_end" value="{{ $product->flash_sale_end ? \Carbon\Carbon::parse($product->flash_sale_end)->format('Y-m-d\TH:i') : '' }}" class="w-full text-xs border-beige-200 rounded-lg focus:ring-sepia-500 focus:border-sepia-500 p-2">
                                    </div>
                                </td>
                                <td class="border-b border-beige-100 py-5 px-4">
                                    @php
                                        $total = $product->stock + $product->sold_count;
                                        $percent = $total > 0 ? ($product->sold_count / $total) * 100 : 0;
                                    @endphp
                                    <div class="w-32 space-y-2">
                                        <div class="h-1.5 w-full bg-beige-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-red-400 rounded-full" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <div class="text-[9px] uppercase font-bold text-earth-300">Đã bán {{ $product->sold_count }} / {{ $total }}</div>
                                    </div>
                                </td>
                                <td class="border-b border-beige-100 py-5 px-4 text-right">
                                    <div class="flex items-center justify-end space-x-3">
                                        <form id="update-form-{{ $product->id }}" action="{{ route('admin.flash_sale.update', $product->id) }}" method="POST">
                                            @csrf
                                        </form>

                                        <button x-show="!editing" @click="editing = true" class="p-2.5 text-earth-400 hover:text-sepia-600 hover:bg-sepia-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        <div x-show="editing" x-cloak class="flex space-x-2">
                                            <button form="update-form-{{ $product->id }}" type="submit" class="bg-earth-800 text-white p-2 rounded-lg hover:bg-earth-900 transition-shadow shadow-md">
                                                Lưu
                                            </button>
                                            <button @click="editing = false" class="bg-beige-100 text-earth-400 p-2 rounded-lg hover:bg-beige-200">
                                                Hủy
                                            </button>
                                        </div>

                                        <form action="{{ route('admin.flash_sale.toggle', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn ngưng chạy Flash Sale cho sản phẩm này?')">
                                            @csrf
                                            <button type="submit" class="p-2.5 text-red-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Ngưng Flash Sale">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="py-20 text-center">
                        <div class="bg-beige-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-earth-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-earth-900 font-bold">Chưa có sản phẩm nào chạy Flash Sale</h3>
                        <p class="text-earth-300 mt-2 text-sm italic">Quay lại danh sách tổng để bắt đầu kích hoạt.</p>
                        <a href="{{ route('admin.flash_sale.index') }}" class="inline-block mt-8 bg-earth-900 text-white px-10 py-4 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-sepia-600 transition-all shadow-xl shadow-earth-900/10">Bắt đầu ngay</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
