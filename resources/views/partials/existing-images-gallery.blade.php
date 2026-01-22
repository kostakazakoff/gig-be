@php
    $model = $model ?? null;
    $media = $media ?? collect();
    $deleteRoute = $deleteRoute ?? null;
    $label = $label ?? 'Текущи снимки';
    $helpText = $helpText ?? 'Провлачвай снимките за смяна на реда. Първата става основна (миниатюра).';
    $deleteConfirm = $deleteConfirm ?? 'Сигурни ли сте, че искате да изтриете тази снимка?';
@endphp

@if($media->count() > 0)
<div class="border-b pb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $label }}</h3>
    <div class="text-xs text-gray-500 mb-2">{{ $helpText }}</div>
    <input type="hidden" name="media_order" id="media_order" value="">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="existing-images">
        @foreach($media as $item)
        <div class="relative group" data-media-id="{{ $item->id }}" draggable="true">
            <img src="{{ $item->getUrl() }}" alt="Image" class="w-full h-32 object-cover rounded-lg" />
            <button
                type="button"
                onclick="deleteExistingImage({{ $model->id }}, {{ $item->id }}, '{{ $deleteConfirm }}')"
                class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700"
                title="Изтрий снимка"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @endforeach
    </div>
</div>

<script>
(function() {
    // Delete image function
    window.deleteExistingImage = function(modelId, mediaId, confirmMessage) {
        const imageElement = document.querySelector('[data-media-id="' + mediaId + '"]');
        
        showConfirmModal(confirmMessage, function() {
            performImageDelete(modelId, mediaId, imageElement);
        });
    };
    
    function performImageDelete(modelId, mediaId, imageElement) {
        if (imageElement) {
            imageElement.style.opacity = '0.5';
            imageElement.style.pointerEvents = 'none';
        }

        fetch('{{ $deleteRoute }}/' + modelId + '/media/' + mediaId, {
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
                if (imageElement) {
                    imageElement.style.opacity = '0';
                    imageElement.style.transform = 'scale(0.8)';
                    imageElement.style.transition = 'all 0.3s ease';
                    
                    setTimeout(function() {
                        imageElement.remove();
                        
                        const container = document.getElementById('existing-images');
                        if (container && container.children.length === 0) {
                            container.parentElement.remove();
                        }
                        updateExistingMediaOrder();
                    }, 300);
                }
            } else {
                if (imageElement) {
                    imageElement.style.opacity = '1';
                    imageElement.style.pointerEvents = 'auto';
                }
                console.error('Error deleting image:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (imageElement) {
                imageElement.style.opacity = '1';
                imageElement.style.pointerEvents = 'auto';
            }
        });
    };

    // Drag & drop reordering for existing images
    const container = document.getElementById('existing-images');
    const orderInput = document.getElementById('media_order');

    function updateExistingMediaOrder() {
        if (!container || !orderInput) return;
        const ids = Array.from(container.children)
            .map(el => el.getAttribute('data-media-id'))
            .filter(Boolean);
        orderInput.value = ids.join(',');
    }

    // Initialize current order
    updateExistingMediaOrder();

    let dragEl = null;
    if (container) {
        container.addEventListener('dragstart', (e) => {
            const target = e.target.closest('[data-media-id]');
            if (!target) return;
            dragEl = target;
            target.classList.add('opacity-50');
            e.dataTransfer.effectAllowed = 'move';
        });

        container.addEventListener('dragend', (e) => {
            const target = e.target.closest('[data-media-id]');
            if (!target) return;
            target.classList.remove('opacity-50');
        });

        container.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const target = e.target.closest('[data-media-id]');
            if (!target || target === dragEl) return;
            const bounding = target.getBoundingClientRect();
            const offset = bounding.y + (bounding.height / 2);
            if (e.clientY - offset > 0) {
                target.after(dragEl);
            } else {
                target.before(dragEl);
            }
        });

        container.addEventListener('drop', (e) => {
            e.preventDefault();
            dragEl = null;
            updateExistingMediaOrder();
        });
    }
})();
</script>
@endif
