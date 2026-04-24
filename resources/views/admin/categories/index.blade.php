<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Danh mục') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-4 inline-block">Thêm Danh mục</a>
                    
                    @if(session('success'))
                        <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
                    @endif

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm">ID</th>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm">Tên Danh mục</th>
                                <th class="border-b py-2 text-gray-600 font-bold uppercase text-sm text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td class="border-b py-2">{{ $category->id }}</td>
                                <td class="border-b py-2">{{ $category->name }}</td>
                                <td class="border-b py-2 text-right">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">Sửa</a> |
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
