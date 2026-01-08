@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-center justify-between sticky top-18 z-50 bg-gray-50 py-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">News</h1>
                <p class="mt-2 text-gray-600">Manage all news articles in the system</p>
            </div>
            <a href="{{ route('admin.news.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ADD NEWS
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- News Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Key</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title (EN)</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title (BG)</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Content (EN)</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Content (BG)</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($news ?? [] as $article)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center">
                                    @if ($article->image_src)
                                        <img src="{{ $article->image_src }}" alt="{{ $article->translation_key }}"
                                            class="w-12 h-12 rounded object-cover" />
                                    @else
                                        <div
                                            class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                            No</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $article->translation_key }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $article->getTranslation('title', 'en') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $article->getTranslation('title', 'bg') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ Str::limit($article->getTranslation('content', 'en'), 50) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ Str::limit($article->getTranslation('content', 'bg'), 50) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.news.edit', $article->id) }}"
                                        class="text-blue-600 hover:text-blue-900 font-medium transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $article->id) }}" method="POST"
                                        class="inline ml-4"
                                        onsubmit="return confirm('Are you sure you want to delete this news article?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-600">
                                    No news articles found. <a href="{{ route('admin.news.create') }}"
                                        class="text-blue-600 hover:text-blue-900 font-medium">Create one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>
    </div>
@endsection
