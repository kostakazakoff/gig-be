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

        <!-- Image Upload -->
        <div class="mb-4">
            @include('partials.single-image-dropzone', [
                'label' => 'Replace Image',
                'existingImage' => $service->image_src,
                'deleteUrl' => route('admin.services.deleteImage', $service),
            ])
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

@endsection
