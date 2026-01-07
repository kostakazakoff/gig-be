@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Project</h1>
            <p class="mt-2 text-gray-600">Update project information and gallery</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Existing Images Gallery -->
                @if($project->getMedia('project_images')->count() > 0)
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Images</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="existing-images">
                        @foreach($project->getMedia('project_images') as $media)
                        <div class="relative group" data-media-id="{{ $media->id }}">
                            <img src="{{ $media->getUrl() }}" alt="Project image" class="w-full h-32 object-cover rounded-lg" />
                            <button
                                type="button"
                                onclick="deleteImage({{ $project->id }}, {{ $media->id }})"
                                class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700"
                                title="Delete image"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Add New Images -->
                @include('partials.images-dropzone', ['label' => 'Add New Images'])

                <!-- Display Key (read-only) -->
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Key
                    </label>
                    <div class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 font-medium">
                        {{ $project->translation_key }}
                    </div>
                    <p class="mt-1 text-xs text-gray-500">This key cannot be changed</p>
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
                            value="{{ old('title_en', $project->title) }}"
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
                            value="{{ old('title_bg', $project->getTranslation('title', 'bg')) }}"
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
                        >{{ old('description_en', $project->description) }}</textarea>
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
                        >{{ old('description_bg', $project->getTranslation('description', 'bg')) }}</textarea>
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
                            value="{{ old('price', $project->price) }}"
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
                            value="{{ old('date', $project->date ? \Carbon\Carbon::parse($project->date)->format('Y-m-d') : '') }}"
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
                        Update Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Delete image function
    function deleteImage(projectId, mediaId) {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }

        fetch(`/admin/projects/${projectId}/media/${mediaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the image element from DOM
                const imageElement = document.querySelector(`[data-media-id="${mediaId}"]`);
                if (imageElement) {
                    imageElement.remove();
                }
                
                // Show success message
                alert('Image deleted successfully');
            } else {
                alert('Error deleting image: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting image');
        });
    }
</script>
@endsection
