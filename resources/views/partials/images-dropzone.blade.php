@php
    $label = $label ?? 'Снимки';
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
                Кликнете, за да качите снимки или ги плъзнете тук
            </p>
            <p class="text-xs text-gray-500 mt-1">
                PNG, JPG, WEBP до 5MB всяка
            </p>
        </label>
    </div>
    <div class="mt-2 text-xs text-gray-500">Провлачвай снимките за смяна на реда. Първата става основна (миниатюра).</div>
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
    
    // Store selected files
    let selectedFiles = [];
    
    // Preview function
    function previewFiles(files) {
        preview.innerHTML = '';
        selectedFiles = Array.from(files);
        
        selectedFiles.forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.setAttribute('draggable', 'true');
                    div.setAttribute('data-file-index', index);
                    div.innerHTML = 
                        '<img src="' + event.target.result + '" class="w-full h-32 object-cover rounded-lg" />' +
                        '<span class="absolute top-1 left-1 bg-blue-600 text-white text-xs px-2 py-1 rounded">' + (index + 1) + '</span>' +
                        '<button type="button" onclick="removeFile(' + index + ')" ' +
                        'class="absolute top-1 right-1 bg-red-600 text-white p-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700" ' +
                        'title="Премахни снимка">' +
                        '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />' +
                        '</svg>' +
                        '</button>';
                    attachDragHandlers(div);
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
        
        updateInputFiles();
    }
    
    // Add new files to existing selection
    function addFiles(newFiles) {
        const filesArray = Array.from(newFiles);
        filesArray.forEach(file => {
            if (file.type.startsWith('image/')) {
                selectedFiles.push(file);
            }
        });
        previewFiles(selectedFiles);
    }
    
    // Update input files
    function updateInputFiles() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => {
            dt.items.add(file);
        });
        input.files = dt.files;
    }
    
    // Remove file function (make it global for this instance)
    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        previewFiles(selectedFiles);
    };
    
    // File input change
    input.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            addFiles(e.target.files);
        }
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
        // Add files to existing selection
        if (files.length > 0) {
            addFiles(files);
        }
    }

    // Drag & drop reordering within preview
    let dragSrcIndex = null;

    function attachDragHandlers(el) {
        el.addEventListener('dragstart', function(e) {
            el.classList.add('opacity-50');
            dragSrcIndex = parseInt(el.getAttribute('data-file-index'));
            e.dataTransfer.effectAllowed = 'move';
        });

        el.addEventListener('dragend', function() {
            el.classList.remove('opacity-50');
        });

        el.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        });

        el.addEventListener('drop', function(e) {
            e.preventDefault();
            const targetIndex = parseInt(el.getAttribute('data-file-index'));
            if (dragSrcIndex === null || dragSrcIndex === targetIndex) return;

            // Reorder selectedFiles array
            const moved = selectedFiles.splice(dragSrcIndex, 1)[0];
            selectedFiles.splice(targetIndex, 0, moved);

            // Re-render preview with new ordering
            previewFiles(selectedFiles);
            dragSrcIndex = null;
        });
    }
})();
</script>
