@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Create Service</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf

        <!-- Category Select -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Key Field -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Key</label>
            <input type="text" name="key" value="{{ old('key') }}" class="w-full border rounded px-3 py-2 @error('key') border-red-500 @enderror" required placeholder="service_key">
            @error('key')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Image Upload -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Image</label>
            <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded p-6 text-center cursor-pointer hover:border-blue-500 transition">
                <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
                <div id="dropText">
                    <p class="text-gray-500">Drag and drop an image here or click to select</p>
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
            <input type="text" name="name_en" value="{{ old('name_en') }}" class="w-full border rounded px-3 py-2 @error('name_en') border-red-500 @enderror" required>
            @error('name_en')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Bulgarian Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Name (Bulgarian)</label>
            <input type="text" name="name_bg" value="{{ old('name_bg') }}" class="w-full border rounded px-3 py-2 @error('name_bg') border-red-500 @enderror" required>
            @error('name_bg')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- English Description -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description (English)</label>
            <textarea name="description_en" class="w-full border rounded px-3 py-2 @error('description_en') border-red-500 @enderror" rows="4">{{ old('description_en') }}</textarea>
            @error('description_en')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Bulgarian Description -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Description (Bulgarian)</label>
            <textarea name="description_bg" class="w-full border rounded px-3 py-2 @error('description_bg') border-red-500 @enderror" rows="4">{{ old('description_bg') }}</textarea>
            @error('description_bg')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Create Service</button>
            <a href="{{ route('admin.services.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">Cancel</a>
        </div>
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
</script>
@endsection
