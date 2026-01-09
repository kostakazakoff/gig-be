@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-center justify-between sticky top-16 z-40 bg-gray-50 py-4">
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
            <div class="overflow-x-auto">
            <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm font-semibold text-gray-700">Image</th>
                            <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Title (EN/BG)</th>
                            <th class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Content (EN/BG)</th>
                            <th class="px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($news ?? [] as $article)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-4 sm:px-6 py-2 sm:py-4 text-center">
                                    @if ($article->image_src)
                                        <img src="{{ $article->image_src }}" alt="{{ $article->translation_key }}"
                                            class="w-12 h-12 rounded object-cover" />
                                    @else
                                        <div
                                            class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                            No</div>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm">
                                    <div class="text-xs lg:text-sm">
                                        <div class="text-blue-600">EN: {{ $article->getTranslation('title', 'en') }}</div>
                                        <div class="text-red-600">BG: {{ $article->getTranslation('title', 'bg') }}</div>
                                    </div>
                                </td>
                                <td class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm">
                                    <div class="text-xs lg:text-sm">
                                        <div class="text-blue-600">EN: {{ Str::limit($article->getTranslation('content', 'en'), 50) }}</div>
                                        <div class="text-red-600">BG: {{ Str::limit($article->getTranslation('content', 'bg'), 50) }}</div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-2 sm:py-4 text-center">
                                    @include('partials.action-buttons', [
                                        'editRoute' => 'admin.news.edit',
                                        'deleteRoute' => 'admin.news.destroy',
                                        'model' => $article,
                                        'confirmMessage' => 'Are you sure you want to delete this article?'
                                    ])
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
    </div>
@endsection
