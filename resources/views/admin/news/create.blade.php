@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Създай новина</h1>
            <p class="mt-2 text-gray-600">Добави нова новина в системата</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Image Upload Field (Drag & Drop) -->
                @include('partials.single-image-dropzone', ['label' => 'Основна снимка'])

                <!-- Key Field -->
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Ключ на статия
                    </label>
                    <input
                        type="text"
                        id="key"
                        name="key"
                        placeholder="н.p., announcement-2024, press-release"
                        value="{{ old('key') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('key') border-red-500 @enderror"
                        required
                    >
                    @error('key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Уникален идентификатор за тази статия (малки букви, без прозърци)</p>
                </div>

                <!-- Title Fields Section -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Заглавие на статия</h3>

                    <!-- Title EN -->
                    <div class="mb-4">
                        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Заглавие (Английски)
                        </label>
                        <input
                            type="text"
                            id="title_en"
                            name="title_en"
                            placeholder="Въведете наслов на новината на английски"
                            value="{{ old('title_en') }}"
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
                            Заглавие (Български)
                        </label>
                        <input
                            type="text"
                            id="title_bg"
                            name="title_bg"
                            placeholder="Въведете наслов на български"
                            value="{{ old('title_bg') }}"
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Съдържание</h3>

                    <!-- Content EN -->
                    <div class="mb-4">
                        <label for="content_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Съдържание (Английски)
                        </label>
                        <textarea
                            id="content_en"
                            name="content_en"
                            placeholder="Въведете съдържание на новината на английски"
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content_en') border-red-500 @enderror"
                            required
                        >{{ old('content_en') }}</textarea>
                        @error('content_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content BG -->
                    <div>
                        <label for="content_bg" class="block text-sm font-medium text-gray-700 mb-2">
                            Съдържание (Български)
                        </label>
                        <textarea
                            id="content_bg"
                            name="content_bg"
                            placeholder="Въведете съдържание на български"
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content_bg') border-red-500 @enderror"
                            required
                        >{{ old('content_bg') }}</textarea>
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
                        Създай новина
                    </button>
                    <a
                        href="{{ route('admin.news.index') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-200 text-center"
                    >
                        Откажи
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Drag & drop image script is now initialized globally via resources/js/app.js --}}
@endsection
