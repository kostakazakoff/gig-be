@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-center justify-between sticky top-18 z-50 bg-gray-50 py-4">
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
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-semibold text-gray-700">Key</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-semibold text-gray-700">Name (EN)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-semibold text-gray-700">Name (BG)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs sm:text-sm font-semibold text-gray-700">Services</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-center text-xs sm:text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($units ?? [] as $unit)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-4 sm:px-6 py-2 sm:py-4 font-mono text-xs sm:text-sm text-gray-600">{{ $unit->translation_key }}</td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs sm:text-sm text-gray-900">
                                {{ $unit->getTranslation('name', 'en') }}
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs sm:text-sm text-gray-900">
                                {{ $unit->getTranslation('name', 'bg') }}
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs sm:text-sm text-gray-600">
                                @php
                                    $serviceNames = $unit->services->map(fn($s) => $s->name)->filter()->values();
                                @endphp
                                {{ $serviceNames->isNotEmpty() ? $serviceNames->implode(', ') : 'N/A' }}
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.units.edit', $unit) }}"
                                        class="inline-flex items-center px-3 py-1 my-1 bg-yellow-50 text-yellow-700 border border-yellow-300 rounded hover:bg-yellow-100 transition text-sm font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.units.destroy', $unit) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this unit?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 my-1 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
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
