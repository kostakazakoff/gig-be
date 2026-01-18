@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-start justify-between sticky top-16 z-40 bg-gray-50 py-4 mx-auto xl:max-w-7xl">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Клиенти</h1>
                <p class="mt-2 text-gray-600">Управлявайте всички клиенти</p>
            </div>
            <div class="flex gap-3">
                <button id="send-message-btn" 
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                    ✉ НАПИШИ СЪОБЩЕНИЕ
                </button>
                <a href="{{ route('admin.clients.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                    + ДОБАВИ КЛИЕНТ
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg xl:max-w-7xl mx-auto">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow mx-auto xl:max-w-7xl">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm w-12">
                            <input type="checkbox" id="select-all" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Изображение</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Име</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Email</th>
                        <th class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Телефон</th>
                        <th class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Компания</th>
                        <th class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Адрес</th>
                        <th class="hidden sm:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Език</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($clients ?? [] as $client)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 sm:px-6 py-2 sm:py-3 text-center">
                            <input type="checkbox" class="client-checkbox w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                   value="{{ $client->id }}" 
                                   data-email="{{ $client->email }}"
                                   data-name="{{ $client->first_name }} {{ $client->last_name }}"
                                   data-language="{{ $client->language ?? 'bg' }}">
                        </td>
                        <td class="px-6 py-3">
                            @if ($client->getFirstMedia('client_avatars'))
                                <img src="{{ $client->getFirstMedia('client_avatars')->getUrl() }}" alt="{{ $client->first_name }} {{ $client->last_name }}"
                                    class="h-12 w-12 object-cover rounded">
                            @else
                                <span class="text-gray-400">Няма</span>
                            @endif
                        </td>
                        <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ $client->first_name }} {{ $client->last_name }}</td>
                        <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ $client->email }}</td>
                        <td class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ $client->phone ?? '—' }}</td>
                        <td class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ $client->company ?? '—' }}</td>
                        <td class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ $client->address ?? '—' }}</td>
                        <td class="hidden sm:table-cell px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm">{{ $client->language ?? '—' }}</td>
                        @include('partials.action-buttons', [
                            'editRoute' => 'admin.clients.edit',
                            'deleteRoute' => 'admin.clients.destroy',
                            'model' => $client,
                            'confirmMessage' => 'Сигурни ли сте, че искате да изтриете този клиент?'
                        ])
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 01-8 0M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <p class="font-medium">Няма намерени клиенти</p>
                                <p class="text-sm mt-1">Създайте първия клиент чрез бутона ДОБАВИ КЛИЕНТ по-горе</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Message Modal -->
    <div id="message-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Изпрати съобщение до клиенти</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Избрани клиенти: <span id="selected-count" class="font-semibold"></span></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="message-bg" class="block text-sm font-medium text-gray-700 mb-2">Съобщение (Български)</label>
                    <textarea id="message-bg" 
                              rows="6" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Въведете съобщението на български..."></textarea>
                </div>
                <div>
                    <label for="message-en" class="block text-sm font-medium text-gray-700 mb-2">Message (English)</label>
                    <textarea id="message-en" 
                              rows="6" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Enter the message in English..."></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button id="cancel-btn" 
                        class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition duration-200">
                    Откажи
                </button>
                <button id="send-btn" 
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-200">
                    Изпрати
                </button>
            </div>
        </div>
    </div>

    <script>
        // Get selected clients with language info
        function getSelectedClientsWithLanguage() {
            const selected = [];
            document.querySelectorAll('.client-checkbox:checked').forEach(checkbox => {
                selected.push({
                    id: checkbox.value,
                    email: checkbox.dataset.email,
                    name: checkbox.dataset.name,
                    language: checkbox.dataset.language || 'bg'
                });
            });
            return selected;
        }

        // Get selected clients without language info
        function getSelectedClients() {
            const selected = [];
            document.querySelectorAll('.client-checkbox:checked').forEach(checkbox => {
                selected.push({
                    id: checkbox.value,
                    email: checkbox.dataset.email,
                    name: checkbox.dataset.name
                });
            });
            return selected;
        }

        // Save selected clients to sessionStorage
        function saveSelectedClients() {
            const selected = getSelectedClientsWithLanguage();
            sessionStorage.setItem('selectedClients', JSON.stringify(selected));
            console.log('Selected clients saved:', selected);
        }

        // Load selected clients from sessionStorage
        function loadSelectedClients() {
            const saved = sessionStorage.getItem('selectedClients');
            if (saved) {
                const selectedClients = JSON.parse(saved);
                selectedClients.forEach(client => {
                    const checkbox = document.querySelector(`.client-checkbox[value="${client.id}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }
        }

        // Enable/disable message button based on selection
        function updateMessageButton() {
            const checkedCheckboxes = document.querySelectorAll('.client-checkbox:checked');
            const messageBtn = document.getElementById('send-message-btn');
            messageBtn.disabled = checkedCheckboxes.length === 0;
            console.log('Message button disabled:', messageBtn.disabled, 'Checked:', checkedCheckboxes.length);
        }

        // Select/Deselect all checkboxes
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.client-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateMessageButton();
            saveSelectedClients();
        });

        // Update select-all checkbox state when individual checkboxes change
        document.querySelectorAll('.client-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allCheckboxes = document.querySelectorAll('.client-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.client-checkbox:checked');
                document.getElementById('select-all').checked = allCheckboxes.length === checkedCheckboxes.length;
                updateMessageButton();
                saveSelectedClients();
            });
        });

        // Modal elements
        const modal = document.getElementById('message-modal');
        const messageBg = document.getElementById('message-bg');
        const messageEn = document.getElementById('message-en');
        const selectedCount = document.getElementById('selected-count');

        // Open modal
        document.getElementById('send-message-btn').addEventListener('click', function() {
            const selected = getSelectedClients();
            if (selected.length === 0) {
                alert('Моля, изберете поне един клиент');
                return;
            }
            
            selectedCount.textContent = selected.length;
            modal.classList.remove('hidden');
            messageBg.value = '';
            messageEn.value = '';
            messageBg.focus();
        });

        // Close modal
        function closeModal() {
            modal.classList.add('hidden');
            messageBg.value = '';
            messageEn.value = '';
        }

        document.getElementById('close-modal').addEventListener('click', closeModal);
        document.getElementById('cancel-btn').addEventListener('click', closeModal);

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Send message
        document.getElementById('send-btn').addEventListener('click', function() {
            const messageBgText = messageBg.value.trim();
            const messageEnText = messageEn.value.trim();
            const selected = getSelectedClientsWithLanguage();

            if (!messageBgText || !messageEnText) {
                alert('Моля, въведете съобщения на двата езика');
                return;
            }

            if (selected.length === 0) {
                alert('Няма избрани клиенти');
                return;
            }

            // Organize messages by language
            const clientsByLanguage = {
                bg: [],
                en: []
            };

            selected.forEach(client => {
                const language = client.language || 'bg';
                if (language === 'en') {
                    clientsByLanguage.en.push(client);
                } else {
                    clientsByLanguage.bg.push(client);
                }
            });

            // Send to backend
            fetch('{{ route('admin.clients.broadcast') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    messages: {
                        bg: messageBgText,
                        en: messageEnText
                    },
                    clientsByLanguage: clientsByLanguage,
                    clients: selected
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeModal();
                    // Clear selections
                    document.querySelectorAll('.client-checkbox:checked').forEach(cb => cb.checked = false);
                    document.getElementById('select-all').checked = false;
                    updateMessageButton();
                    saveSelectedClients();
                } else {
                    alert('Грешка: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Възникна грешка при изпращането');
            });
        });

        // Initialize on page load
        window.addEventListener('DOMContentLoaded', function() {
            loadSelectedClients();
            updateMessageButton();
        });
    </script>
@endsection
