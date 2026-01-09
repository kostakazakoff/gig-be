@php($label = $label ?? 'Image')
@php($imageSrc = $imageSrc ?? null)
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded p-6 text-center cursor-pointer hover:border-blue-500 transition">
        <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
        <div id="dropText" @if($imageSrc) class="hidden" @endif>
            <p class="text-gray-500">Drag and drop an image here or click to select</p>
        </div>
        <img id="imagePreview" src="{{ $imageSrc }}" alt="Preview" @if(!$imageSrc) class="hidden" @endif style="max-height: 12rem; margin: 1rem auto;">
    @error('image')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
