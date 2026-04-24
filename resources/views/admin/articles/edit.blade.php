<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.articles.index') }}" class="text-gray-500 hover:text-gray-700">← Quay lại</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chỉnh sửa Tin Tức') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tiêu đề bài viết</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="title" required value="{{ old('title', $article->title) }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nội dung</label>
                            <textarea name="content" id="editor" rows="15" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('content', $article->content) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Ảnh đại diện hiện tại</label>
                            @if($article->image)
                                <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : Storage::url($article->image) }}" class="w-48 h-32 object-cover rounded mb-2 border border-gray-200">
                            @else
                                <p class="text-sm text-gray-500 italic mb-2">Chưa có ảnh</p>
                            @endif
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="file" name="image">
                            <span class="text-xs text-gray-500">Tải lên ảnh mới để thay thế ảnh cũ</span>
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $article->is_published ? 'checked' : '' }}>
                            <label for="is_published" class="ml-2 block text-gray-700 text-sm font-bold">Công khai bài viết</label>
                        </div>

                        <div class="flex items-center justify-end">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Cập nhật bài viết
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
