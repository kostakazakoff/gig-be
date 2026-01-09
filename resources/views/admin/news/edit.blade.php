@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit News Article</h1>
            <p class="mt-2 text-gray-600">Update news article information</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Image Upload Field (Drag & Drop) -->
                <div>
                    @if ($news->image_src)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current image:</p>
                            <img src="{{ $news->image_src }}" alt="{{ $news->translation_key }}" class="max-w-xs rounded-lg" />
                        </div>
                    @endif
                    @include('partials.single-image-dropzone', ['label' => 'News Image'])
                </div>

                <!-- Display Key (read-only) -->
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Article Key
                    </label>
                    <div class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 font-medium">
                        {{ $news->translation_key }}
                    </div>
                    <p class="mt-1 text-xs text-gray-500">This key cannot be changed</p>
                </div>

                <!-- Title Fields Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Article Titles</h3>

                    <!-- Title EN -->
                    <div class="mb-4">
                        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Title (English)
                        </label>
                        <input
                            type="text"
                            id="title_en"
                            name="title_en"
                            placeholder="Enter news title in English"
                            value="{{ old('title_en', $news->title) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_en') border-red-500 @enderror"
                            required
                        >
                        @error('title_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title BG -->
                    <div>
                        <label for="title_bg" class="block text-sm font-medium text-gray-700 mb-2">
                            Title (Bulgarian)
                        </label>
                        <input
                            type="text"
                            id="title_bg"
                            name="title_bg"
                            placeholder="Въведете заглавие на български"
                            value="{{ old('title_bg', $news->getTranslation('title', 'bg')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_bg') border-red-500 @enderror"
                            required
                        >
                        @error('title_bg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Content Fields Section -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Article Content</h3>

                    <!-- Content EN -->
                    <div class="mb-4">
                        <label for="content_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Content (English)
                        </label>
                        <textarea
                            id="content_en"
                            name="content_en"
                            placeholder="Enter news content in English"
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content_en') border-red-500 @enderror"
                            required
                        >{{ old('content_en', $news->content) }}</textarea>
                        @error('content_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content BG -->
                    <div>
                        <label for="content_bg" class="block text-sm font-medium text-gray-700 mb-2">
                            Content (Bulgarian)
                        </label>
                        <textarea
                            id="content_bg"
                            name="content_bg"
                            placeholder="Въведете съдържание на български"
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content_bg') border-red-500 @enderror"
                            required
                        >{{ old('content_bg', $news->getTranslation('content', 'bg')) }}</textarea>
                        @error('content_bg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t pt-6 flex gap-4">
                    <button
                        type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200"
                    >
                        Update News
                    </button>
                    <a
                        href="{{ route('admin.news.index') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-200 text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Delete Button (Separate Form) -->
            <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="mt-6 pt-6 border-t border-gray-200"
                onsubmit="return confirm('Are you sure you want to delete this news article?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                    Delete News Article
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Drag & drop image script is now initialized globally via resources/js/app.js --}}
@endsection
