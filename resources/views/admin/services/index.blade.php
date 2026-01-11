@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6 sticky top-16 z-40 bg-gray-50 py-4 mx-auto xl:max-w-7xl">
            <h1 class="text-3xl font-bold">Услуги</h1>
            <a href="{{ route('admin.services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + ДОБАВИ УСЛУГА
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded xl:max-w-7xl mx-auto">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow mx-auto xl:max-w-7xl">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Изображение</th>
                        <th class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Категория</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Име (EN/BG)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Цена</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-3">
                                @if ($service->image_src)
                                    <img src="{{ $service->image_src }}" alt="{{ $service->name }}"
                                        class="h-12 w-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400">Няма</span>
                                @endif
                            </td>
                            <td class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ $service->category->name ?? 'Няма' }}</td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3">
                                <div class="text-xs lg:text-sm">
                                    <div class="text-blue-600">EN: {{ $service->getTranslation('name', 'en') }}</div>
                                    <div class="text-red-600">BG: {{ $service->getTranslation('name', 'bg') }}</div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                @if ($service->price_from || $service->price_to)
                                    <div>{{ $service->price_from ? '$' . number_format($service->price_from, 2) : '-' }} -
                                        {{ $service->price_to ? '$' . number_format($service->price_to, 2) : '-' }}</div>
                                    @if ($service->unit)
                                        <div class="text-gray-500 text-xs lg:text-sm">{{ $service->unit }}</div>
                                    @endif
                                @else
                                    <span class="text-gray-400">Няма</span>
                                @endif
                            </td>
                            @include('partials.action-buttons', [
                                'editRoute' => 'admin.services.edit',
                                'deleteRoute' => 'admin.services.destroy',
                                'model' => $service,
                                'confirmMessage' => 'Сигурни ли сте, че искате да изтриете тази услуга?'
                            ])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <p class="font-medium">Няма намерени услуги</p>
                                    <p class="text-sm mt-1">Създайте първата услуга чрез бутона ДОБАВИ УСЛУГА по-горе</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
