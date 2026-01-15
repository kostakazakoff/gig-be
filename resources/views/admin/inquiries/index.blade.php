@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between sticky top-16 z-40 bg-gray-50 py-4 mx-auto xl:max-w-7xl">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Запитвания</h1>
                <p class="mt-2 text-gray-600">Управляйте всички запитвания</p>
                <form method="GET" action="{{ route('admin.inquiries.index') }}" class="mt-4">
                    <label for="client_filter" class="text-sm font-medium text-gray-700">
                        <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </label>
                    <select id="client" name="client"
                        class="mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        onchange="this.form.submit()">
                        <option value="">Kлиенти</option>
                        @foreach ($clients ?? [] as $client)
                            <option value="{{ $client->id }}">
                                {{ $client->first_name }} {{ $client->last_name }}
                                @selected(request('client') === $client->id)
                            </option>
                        @endforeach
                        <option value="">
                            Всички
                        </option>
                    </select>
                </form>
            </div>
            {{-- <a href="{{ route('admin.inquiries.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ДОБАВИ ЗАПИТВАНЕ
            </a> --}}
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
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Клиент</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Услуга</th>
                        <th class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Съобщение
                        </th>
                        <th class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Създадено
                        </th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries ?? [] as $inquiry)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                {{ optional($inquiry->client)->first_name }} {{ optional($inquiry->client)->last_name }}
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                {{ optional($inquiry->category)->getTranslation('name', 'bg') ?? '—' }}
                            </td>
                            <td class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                {{ Str::limit($inquiry->message, 80) }}</td>
                            <td class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                {{ $inquiry->created_at->format('Y-m-d H:i') }}</td>
                            @include('partials.action-buttons', [
                                'editRoute' => 'admin.inquiries.show',
                                'editLabel' => 'Преглед',
                                'deleteRoute' => 'admin.inquiries.destroy',
                                'model' => $inquiry,
                                'confirmMessage' => 'Сигурни ли сте, че искате да изтриете това запитване?',
                            ])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="font-medium">Няма намерени запитвания</p>
                                    <p class="text-sm mt-1">Запитванията се създават автоматично от клиентите чрез уебсайта
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
