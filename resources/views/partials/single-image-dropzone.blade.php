@php($label = $label ?? 'Image')
@php($name = $name ?? 'image')
@php($existingImage = $existingImage ?? null)
@php($deleteUrl = $deleteUrl ?? null)
@php($uid = $uid ?? uniqid('img_'))
@php($dropZoneId = 'dropZone_' . $uid)
@php($inputId = 'imageInput_' . $uid)
@php($previewId = 'imagePreview_' . $uid)
@php($dropTextId = 'dropText_' . $uid)
@php($wrapperId = 'imageWrapper_' . $uid)

<div class="space-y-2">
    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>

    @if($existingImage)
        <div id="{{ $wrapperId }}" class="mb-2">
            <div class="relative group inline-block">
                <img src="{{ $existingImage }}" alt="{{ $label }}" class="max-w-xs rounded-lg">
                @if($deleteUrl)
                    <button
                        type="button"
                        id="deleteBtn_{{ $uid }}"
                        class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700"
                        title="Delete image"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    @endif

    <div id="{{ $dropZoneId }}" class="border-2 border-dashed border-gray-300 rounded p-6 text-center cursor-pointer hover:border-blue-500 transition">
        <input type="file" name="{{ $name }}" id="{{ $inputId }}" class="hidden" accept="image/*">
        <label for="{{ $inputId }}" id="{{ $dropTextId }}" class="cursor-pointer block">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <p class="mt-2 text-sm text-gray-600">
                Click to upload an image or drag and drop
            </p>
            <p class="text-xs text-gray-500 mt-1">
                PNG, JPG, WEBP
            </p>
        </label>
        <img id="{{ $previewId }}" src="" alt="Preview" class="hidden mt-4 max-h-48 mx-auto rounded-lg">
    </div>

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<script>
(() => {
    const dropZone = document.getElementById('{{ $dropZoneId }}');
    const imageInput = document.getElementById('{{ $inputId }}');
    const imagePreview = document.getElementById('{{ $previewId }}');
    const dropText = document.getElementById('{{ $dropTextId }}');
    const imageWrapper = document.getElementById('{{ $wrapperId }}');
    const deleteBtn = document.getElementById('deleteBtn_{{ $uid }}');

    if (!dropZone || !imageInput) {
        return;
    }

    const handleImageSelect = () => {
        if (imageInput.files.length === 0) {
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('hidden');
            dropText.classList.add('hidden');
        };
        reader.readAsDataURL(imageInput.files[0]);
    };

    imageInput.addEventListener('change', handleImageSelect);

    dropZone.addEventListener('click', (e) => {
        // Prevent triggering if clicking on the label (which already has for attribute)
        // but allow click on the dropZone background
        if (e.target === dropZone || e.target.closest('#{{ $dropZoneId }}')) {
            imageInput.click();
        }
    });

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        imageInput.files = e.dataTransfer.files;
        imageInput.dispatchEvent(new Event('change', { bubbles: true }));
    });

    if (deleteBtn) {
        deleteBtn.addEventListener('click', () => {
            if (!confirm('Are you sure you want to delete this image?')) {
                return;
            }

            if (imageWrapper) {
                imageWrapper.style.opacity = '0.5';
                imageWrapper.style.pointerEvents = 'none';
            }

            fetch('{{ $deleteUrl }}', {
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
                if (data.success) {
                    if (imageWrapper) {
                        imageWrapper.style.opacity = '0';
                        imageWrapper.style.transform = 'scale(0.95)';
                        imageWrapper.style.transition = 'all 0.2s ease';
                        setTimeout(() => imageWrapper.remove(), 200);
                    }
                } else {
                    if (imageWrapper) {
                        imageWrapper.style.opacity = '1';
                        imageWrapper.style.pointerEvents = 'auto';
                    }
                    console.error('Error deleting image:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (imageWrapper) {
                    imageWrapper.style.opacity = '1';
                    imageWrapper.style.pointerEvents = 'auto';
                }
            });
        });
    }
})();
</script>
