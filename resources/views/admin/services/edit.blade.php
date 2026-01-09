@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Service</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <!-- Category Select -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $service->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Key Display (Read-only) -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Key</label>
            <input type="text" value="{{ $service->translation_key }}" class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed" disabled>
        </div>

        <!-- Current Image -->
        @if($service->image_src)
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Current Image</label>
                <div class="relative group inline-block">
                    <img src="{{ $service->image_src }}" alt="{{ $service->name }}" class="h-32 w-32 object-cover rounded">
                    <button
                        type="button"
                        onclick="deleteImage({{ $service->id }})"
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

        <!-- Image Upload -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Replace Image</label>
            <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded p-6 text-center cursor-pointer hover:border-blue-500 transition">
                <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
                <div id="dropText">
                    <p class="text-gray-500">Drag and drop a new image here or click to select</p>
                </div>
                <img id="imagePreview" src="" alt="Preview" class="hidden mt-4 max-h-48 mx-auto">
            </div>
            @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- English Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Name (English)</label>
            <input type="text" name="name_en" value="{{ old('name_en', $service->getTranslation('name', 'en')) }}" class="w-full border rounded px-3 py-2 @error('name_en') border-red-500 @enderror" required>
            @error('name_en')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Bulgarian Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Name (Bulgarian)</label>
            <input type="text" name="name_bg" value="{{ old('name_bg', $service->getTranslation('name', 'bg'))}}" class="w-full border rounded px-3 py-2 @error('name_bg') border-red-500 @enderror" required>
            @error('name_bg')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- English Description -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description (English)</label>
            <textarea name="description_en" class="w-full border rounded px-3 py-2 @error('description_en') border-red-500 @enderror" rows="4">{{ old('description_en', $service->getTranslation('description', 'en')) }}</textarea>
            @error('description_en')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Bulgarian Description -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Description (Bulgarian)</label>
            <textarea name="description_bg" class="w-full border rounded px-3 py-2 @error('description_bg') border-red-500 @enderror" rows="4">{{ old('description_bg', $service->getTranslation('description', 'bg')) }}</textarea>
            @error('description_bg')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Price From -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Price From</label>
            <input type="number" name="price_from" value="{{ old('price_from', $service->price_from) }}" step="0.01" min="0" class="w-full border rounded px-3 py-2 @error('price_from') border-red-500 @enderror">
            @error('price_from')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Price To -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Price To</label>
            <input type="number" name="price_to" value="{{ old('price_to', $service->price_to) }}" step="0.01" min="0" class="w-full border rounded px-3 py-2 @error('price_to') border-red-500 @enderror">
            @error('price_to')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Unit Select -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Unit</label>
            <select name="unit_id" class="w-full border rounded px-3 py-2 @error('unit_id') border-red-500 @enderror">
                <option value="">Select a unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" @selected(old('unit_id', $service->unit_id) == $unit->id)>
                        {{ $unit->getTranslation('name', app()->getLocale()) ?? $unit->translation_key }}
                    </option>
                @endforeach
            </select>
            @error('unit_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Update Service</button>
            <a href="{{ route('admin.services.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">Cancel</a>
        </div>
    </form>

    <!-- Delete Button (Separate Form) -->
    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="mt-6 pt-6 border-t border-gray-200"
        onsubmit="return confirm('Are you sure you want to delete this service?');">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium">
            Delete Service
        </button>
    </form>
</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const dropText = document.getElementById('dropText');

    dropZone.addEventListener('click', () => imageInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-500');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500');
        imageInput.files = e.dataTransfer.files;
        handleImageSelect();
    });

    imageInput.addEventListener('change', handleImageSelect);

    function handleImageSelect() {
        if (imageInput.files.length > 0) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                dropText.classList.add('hidden');
            };
            reader.readAsDataURL(imageInput.files[0]);
        }
    }

    // Delete image function
    function deleteImage(serviceId) {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }

        // Show loading state
        const imageContainer = document.querySelector('.relative.group.inline-block');
        if (imageContainer) {
            imageContainer.style.opacity = '0.5';
            imageContainer.style.pointerEvents = 'none';
        }

        fetch('/admin/services/' + serviceId + '/image', {
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
