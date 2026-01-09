@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-center justify-between sticky top-16 z-40 bg-gray-50 py-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Units</h1>
                <p class="mt-2 text-gray-600">Manage all units in the system</p>
            </div>
            <a href="{{ route('admin.units.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ADD UNIT
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Units Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Name (EN/BG)</th>
                        <th class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Services</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($units ?? [] as $unit)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 sm:px-6 py-2 sm:py-3">
                                <div class="text-xs lg:text-sm">
                                    <div class="text-blue-600">EN: {{ $unit->getTranslation('name', 'en') }}</div>
                                    <div class="text-red-600">BG: {{ $unit->getTranslation('name', 'bg') }}</div>
                                </div>
                            </td>
                            <td class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                @php
                                    $serviceNames = $unit->services->map(fn($s) => $s->name)->filter()->values();
                                @endphp
                                {{ $serviceNames->isNotEmpty() ? $serviceNames->implode(', ') : 'N/A' }}
                            </td>
                            @include('partials.action-buttons', [
                                'editRoute' => 'admin.units.edit',
                                'deleteRoute' => 'admin.units.destroy',
                                'model' => $unit,
                                'confirmMessage' => 'Are you sure you want to delete this unit?'
                            ])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                No units found. <a href="{{ route('admin.units.create') }}"
                                    class="text-blue-600 hover:underline">Create one now</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection
