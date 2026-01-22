<td class="px-4 sm:px-6 py-2 sm:py-3 text-right">
    <div class="flex flex-col sm:flex-row items-center justify-end gap-2">
        <!-- Edit Button -->
        <a href="{{ route($editRoute, $model) }}"
            class="inline-flex items-center px-3 py-1 my-1 bg-yellow-50 text-yellow-700 border border-yellow-300 rounded hover:bg-yellow-100 transition text-sm font-medium">
            {{ $editLabel ?? 'Редактирай' }}
        </a>

        <!-- Delete Button -->
        <form method="POST" action="{{ route($deleteRoute, $model) }}" class="inline delete-form">
            @csrf
            @method('DELETE')
            <button type="button" 
                data-confirm-message="{{ $confirmMessage }}"
                class="delete-btn inline-flex items-center px-3 py-1 my-1 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium cursor-pointer">
                Изтрий
            </button>
        </form>
    </div>
</td>

