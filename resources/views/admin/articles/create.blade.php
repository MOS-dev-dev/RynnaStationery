<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.articles.index') }}" class="text-gray-500 hover:text-gray-700">← Quay lại</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Viết bài Tin Tức mới') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tiêu đề bài viết</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="title" required value="{{ old('title') }}">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nội dung (Hỗ trợ HTML cơ bản)</label>
                            <textarea name="content" id="editor" rows="15" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('content') }}</textarea>
                            @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Ảnh đại diện (Thumbnail)</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="file" name="image">
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                            <label for="is_published" class="ml-2 block text-gray-700 text-sm font-bold">Công khai bài viết ngay lập tức</label>
                        </div>

                        <div class="flex items-center justify-end">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Đăng bài
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
