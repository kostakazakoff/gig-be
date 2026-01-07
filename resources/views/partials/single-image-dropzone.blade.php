@php($label = $label ?? 'Image')
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded p-6 text-center cursor-pointer hover:border-blue-500 transition">
        <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
        <div id="dropText">
            <p class="text-gray-500">Drag and drop an image here or click to select</p>
        </div>
        <img id="imagePreview" src="" alt="Preview" class="hidden mt-4 max-h-48 mx-auto">
    </div>
    @error('image')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
