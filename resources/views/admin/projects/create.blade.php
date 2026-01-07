@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create Project</h1>
            <p class="mt-2 text-gray-600">Add a new project to the portfolio</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Multiple Image Upload Field -->
                @include('partials.images-dropzone', ['label' => 'Project Images (Gallery)'])

                <!-- Key Field -->
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Key
                    </label>
                    <input
                        type="text"
                        id="key"
                        name="key"
                        placeholder="e.g., modern-villa, office-renovation"
                        value="{{ old('key') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('key') border-red-500 @enderror"
                        required
                    >
                    @error('key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Unique identifier for this project (lowercase, use dashes)</p>
                </div>

                <!-- Title Fields Section -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Titles</h3>

                    <!-- Title EN -->
                    <div class="mb-4">
                        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Title (English)
                        </label>
                        <input
                            type="text"
                            id="title_en"
                            name="title_en"
                            placeholder="Enter project title in English"
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
                            Title (Bulgarian)
                        </label>
                        <input
                            type="text"
                            id="title_bg"
                            name="title_bg"
                            placeholder="Въведете заглавие на български"
                            value="{{ old('title_bg') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_bg') border-red-500 @enderror"
                            required
                        >
                        @error('title_bg')
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
                            placeholder="Enter project description in English"
                            rows="4"
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_bg') border-red-500 @enderror"
                        >{{ old('description_bg') }}</textarea>
                        @error('description_bg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Fields -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Price (optional)
                        </label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            step="0.01"
                            min="0"
                            placeholder="0.00"
                            value="{{ old('price') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror"
                        >
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Date (optional)
                        </label>
                        <input
                            type="date"
                            id="date"
                            name="date"
                            value="{{ old('date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date') border-red-500 @enderror"
                        >
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('admin.projects.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
