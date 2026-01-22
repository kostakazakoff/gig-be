<!-- Confirm Modal -->
<div id="confirmModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-5" id="confirmModalTitle">Потвърдете действието</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="confirmModalMessage">
                    Сигурни ли сте, че искате да изтриете този запис?
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmModalCancel"
                    class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Откажи
                </button>
                <button id="confirmModalConfirm"
                    class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-24 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Изтрий
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Confirm Modal Handler
    let confirmCallback = null;

    function showConfirmModal(message, callback) {
        const modal = document.getElementById('confirmModal');
        const messageEl = document.getElementById('confirmModalMessage');
        
        messageEl.textContent = message;
        modal.classList.remove('hidden');
        confirmCallback = callback;
    }

    function hideConfirmModal() {
        const modal = document.getElementById('confirmModal');
        modal.classList.add('hidden');
        confirmCallback = null;
    }

    // Cancel button
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('confirmModalCancel').addEventListener('click', function() {
            hideConfirmModal();
        });

        // Confirm button
        document.getElementById('confirmModalConfirm').addEventListener('click', function() {
            if (confirmCallback) {
                confirmCallback();
            }
            hideConfirmModal();
        });

        // Close on outside click
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideConfirmModal();
            }
        });
    });
</script>
