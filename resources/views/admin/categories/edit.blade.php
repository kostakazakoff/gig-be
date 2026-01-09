@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Category</h1>
            <p class="mt-2 text-gray-600">Update category information</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Image Upload Field (Drag & Drop) -->
                <div>
                    @if ($category->image_src)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current image:</p>
                            <div class="relative group inline-block">
                                <img src="{{ $category->image_src }}" alt="{{ $category->translation_key }}" class="max-w-xs rounded-lg" />
                                <button
                                    type="button"
                                    onclick="deleteImage({{ $category->id }})"
                                    class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700"
                                    title="Delete image"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                    @include('partials.single-image-dropzone', ['label' => 'Category Image'])
                </div>

                <!-- Display Key (read-only) -->
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Key
                    </label>
                    <div class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 font-medium">
                        {{ $category->translation_key }}
                    </div>
                    <p class="mt-1 text-xs text-gray-500">This key cannot be changed</p>
                </div>

                <!-- Name Fields Section -->
                <div>
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
                            value="{{ old('name_en', $category->name) }}"
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
                            value="{{ old('name_bg', $category->getTranslation('name', 'bg')) }}"
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_en') border-red-500 @enderror"
                        >{{ old('description_en', $category->description) }}</textarea>
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
                        >{{ old('description_bg', $category->getTranslation('description', 'bg')) }}</textarea>
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
                        Update Category
                    </button>
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-200 text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Delete Button (Separate Form) -->
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="mt-6 pt-6 border-t border-gray-200"
                onsubmit="return confirm('Are you sure you want to delete this category?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium">
                    Delete Category
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Delete image function
    function deleteImage(categoryId) {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }

        // Show loading state
        const imageContainer = document.querySelector('.relative.group.inline-block');
        if (imageContainer) {
            imageContainer.style.opacity = '0.5';
            imageContainer.style.pointerEvents = 'none';
        }

        fetch('/admin/categories/' + categoryId + '/image', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Delete response:', data);
            if (data.success) {
                // Remove the image element from DOM with animation
                if (imageContainer) {
                    imageContainer.style.opacity = '0';
                    imageContainer.style.transform = 'scale(0.8)';
                    imageContainer.style.transition = 'all 0.3s ease';
                    
                    setTimeout(function() {
                        imageContainer.closest('.mb-4').remove();
                    }, 300);
                }
            } else {
                // Restore image on error
                if (imageContainer) {
                    imageContainer.style.opacity = '1';
                    imageContainer.style.pointerEvents = 'auto';
                }
                console.error('Error deleting image:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Restore image on error
            if (imageContainer) {
                imageContainer.style.opacity = '1';
                imageContainer.style.pointerEvents = 'auto';
            }
        });
    }
</script>
@endsection
