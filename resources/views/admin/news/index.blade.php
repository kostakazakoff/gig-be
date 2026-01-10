@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-center justify-between sticky top-16 z-40 bg-gray-50 py-4 mx-auto" style="max-width: 65%;">
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
        <div class="overflow-x-auto bg-white rounded shadow mx-auto" style="max-width: 65%;">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs lg:text-sm">Image</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Title (EN/BG)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($news ?? [] as $article)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-3">
                                @if ($article->image_src)
                                    <img src="{{ $article->image_src }}" alt="{{ $article->translation_key }}"
                                        class="h-12 w-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400">No</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3">
                                <div class="text-xs lg:text-sm">
                                    <div class="text-blue-600">EN: {{ $article->getTranslation('title', 'en') }}</div>
                                    <div class="text-red-600">BG: {{ $article->getTranslation('title', 'bg') }}</div>
                                </div>
                            </td>
                            @include('partials.action-buttons', [
                                'editRoute' => 'admin.news.edit',
                                'deleteRoute' => 'admin.news.destroy',
                                'model' => $article,
                                'confirmMessage' => 'Are you sure you want to delete this article?',
                            ])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-left text-gray-500">
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
