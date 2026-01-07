@php
    $label = $label ?? 'Images';
    $name = $name ?? 'images[]';
    $id = $id ?? 'images';
@endphp

<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
    </label>
    <div id="{{ $id }}-dropzone" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $id }}"
            multiple
            accept="image/jpeg,image/png,image/jpg,image/webp"
            class="hidden"
        >
        <label for="{{ $id }}" class="cursor-pointer block">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <p class="mt-2 text-sm text-gray-600">
                Click to upload multiple images or drag and drop
            </p>
            <p class="text-xs text-gray-500 mt-1">
                PNG, JPG, WEBP up to 5MB each
            </p>
        </label>
    </div>
    <div id="{{ $id }}-preview" class="mt-4 grid grid-cols-3 gap-4"></div>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
    @error($name . '.*')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<script>
(function() {
    const input = document.getElementById('{{ $id }}');
    const dropzone = document.getElementById('{{ $id }}-dropzone');
    const preview = document.getElementById('{{ $id }}-preview');
    
    // Preview function
    function previewFiles(files) {
        preview.innerHTML = '';
        
        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${event.target.result}" class="w-full h-32 object-cover rounded-lg" />
                        <span class="absolute top-1 right-1 bg-blue-600 text-white text-xs px-2 py-1 rounded">${index + 1}</span>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // File input change
    input.addEventListener('change', function(e) {
        previewFiles(e.target.files);
    });
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    // Highlight drop zone when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
    }
    
    function unhighlight(e) {
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
    }
    
    // Handle dropped files
    dropzone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        // Set files to input
        input.files = files;
        
        // Preview files (change event will be triggered automatically)
        previewFiles(files);
    }
})();
</script>
