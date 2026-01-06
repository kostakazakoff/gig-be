@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create Category</h1>
            <p class="mt-2 text-gray-600">Add a new category to the system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Key Field -->
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Key
                    </label>
                    <input
                        type="text"
                        id="key"
                        name="key"
                        placeholder="e.g., tech, furniture, clothing"
                        value="{{ old('key') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('key') border-red-500 @enderror"
                        required
                    >
                    @error('key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Unique identifier for this category (lowercase, no spaces)</p>
                </div>

                <!-- Name Fields Section -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Names</h3>

                    <!-- Name EN -->
                    <div class="mb-4">
                        <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Name (English)
                        </label>
                        <input
                            type="text"
                            id="name_en"
                            name="name_en"
                            placeholder="Enter category name in English"
                            value="{{ old('name_en') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_en') border-red-500 @enderror"
                            required
                        >
                        @error('name_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name BG -->
                    <div>
                        <label for="name_bg" class="block text-sm font-medium text-gray-700 mb-2">
                            Name (Bulgarian)
                        </label>
                        <input
                            type="text"
                            id="name_bg"
                            name="name_bg"
                            placeholder="Въведете категория на български"
                            value="{{ old('name_bg') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_bg') border-red-500 @enderror"
                            required
                        >
                        @error('name_bg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description Fields Section -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Descriptions</h3>

                    <!-- Description EN -->
                    <div class="mb-4">
                        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Description (English)
                        </label>
                        <textarea
                            id="description_en"
                            name="description_en"
                            placeholder="Enter category description in English"
                            rows="4"
                            value="{{ old('description_en') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_en') border-red-500 @enderror"
                        >{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description BG -->
                    <div>
                        <label for="description_bg" class="block text-sm font-medium text-gray-700 mb-2">
                            Description (Bulgarian)
                        </label>
                        <textarea
                            id="description_bg"
                            name="description_bg"
                            placeholder="Въведете описание на български"
                            rows="4"
                            value="{{ old('description_bg') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_bg') border-red-500 @enderror"
                        >{{ old('description_bg') }}</textarea>
                        @error('description_bg')
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
                        Create Category
                    </button>
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-200 text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
