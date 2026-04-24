<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Tin tức / Blog') }}
            </h2>
            <a href="{{ route('admin.articles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Thêm bài viết mới
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
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hình Ảnh</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tiêu Đề</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tác Giả</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Trạng Thái</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    @if($article->image)
                                        <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : Storage::url($article->image) }}" class="w-16 h-12 object-cover rounded">
                                    @else
                                        <span class="text-gray-400 text-xs">No image</span>
                                    @endif
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 font-bold max-w-xs truncate" title="{{ $article->title }}">{{ $article->title }}</p>
                                    <p class="text-gray-400 text-xs mt-1">{{ $article->created_at->format('d/m/Y H:i') }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $article->author->name }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <span class="relative inline-block px-3 py-1 font-semibold {{ $article->is_published ? 'text-green-900' : 'text-gray-900' }} leading-tight">
                                        <span aria-hidden class="absolute inset-0 {{ $article->is_published ? 'bg-green-200' : 'bg-gray-200' }} opacity-50 rounded-full"></span>
                                        <span class="relative text-xs uppercase">{{ $article->is_published ? 'Công khai' : 'Bản nháp' }}</span>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Sửa</a>
                                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Xóa</button>
                                        </form>
                                        <a href="{{ route('blog.show', $article->id) }}" target="_blank" class="text-gray-600 hover:text-gray-900 font-bold">Xem</a>
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
