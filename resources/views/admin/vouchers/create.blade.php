<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo Mã Giảm Giá') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.vouchers.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Mã Khuyến Mãi</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline uppercase" type="text" name="code" value="{{ old('code') }}" required placeholder="VD: TET2024">
                            @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4 flex flex-wrap -mx-2" x-data="{ type: 'percent' }">
                            <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Loại mã</label>
                                <select name="type" x-model="type" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="percent">Giảm theo %</option>
                                    <option value="amount">Giảm tiền cố định</option>
                                    <option value="freeship">Miễn phí giao hàng</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Giá trị giảm <span x-text="type == 'percent' ? '(%)' : '(VNĐ)'"></span></label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="discount_value" value="{{ old('discount_value', 0) }}" required min="0">
                                @error('discount_value')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="w-full md:w-1/3 px-2" x-show="type != 'amount'">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Giảm tối đa (VNĐ)</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="max_discount" value="{{ old('max_discount') }}" min="0" placeholder="Bỏ trống = Ko giới hạn">
                            </div>
                        </div>

                        <div class="mb-4 flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Đơn hàng tối thiểu (VNĐ)</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="min_order_value" value="{{ old('min_order_value', 0) }}" required min="0">
                                @error('min_order_value')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="w-full md:w-1/2 px-2 flex items-center pt-6">
                                <label class="flex items-center text-gray-700 text-sm font-bold cursor-pointer">
                                    <input type="checkbox" name="is_for_new_user" value="1" class="transform scale-150 mr-3 text-blue-500" {{ old('is_for_new_user') ? 'checked' : '' }}>
                                    <span class="text-blue-600 bg-blue-50 px-2 py-1 rounded">Dành riêng KHÁCH MỚI</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4 flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Giới hạn số lần dùng (Tùy chọn)</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1">
                            </div>
                            <div class="w-full md:w-1/2 px-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Ngày hết hạn (Tùy chọn)</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date" name="expires_at" value="{{ old('expires_at') }}">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Tạo Mã
                            </button>
                            <a class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800" href="{{ route('admin.vouchers.index') }}">
                                Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
