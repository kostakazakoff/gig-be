@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Services</h1>
        <a href="{{ route('admin.services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Add Service
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left">Image</th>
                    <th class="px-6 py-3 text-left">Key</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Name (EN/BG)</th>
                    <th class="px-6 py-3 text-left">Price</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-3">
                            @if($service->image_src)
                                <img src="{{ $service->image_src }}" alt="{{ $service->name }}" class="h-12 w-12 object-cover rounded">
                            @else
                                <span class="text-gray-400">No</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 font-mono text-sm">{{ $service->translation_key }}</td>
                        <td class="px-6 py-3">{{ $service->category->name ?? 'N/A' }}</td>
                        <td class="px-6 py-3">
                            <div class="text-sm">
                                <div class="text-blue-600">EN: {{ $service->getTranslation('name', 'en') }}</div>
                                <div class="text-red-600">BG: {{ $service->getTranslation('name', 'bg') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-sm">
                            @if($service->price_from || $service->price_to)
                                <div>{{ $service->price_from ? '$' . number_format($service->price_from, 2) : '-' }} - {{ $service->price_to ? '$' . number_format($service->price_to, 2) : '-' }}</div>
                                @if($service->unit)
                                    <div class="text-gray-500">{{ $service->unit }}</div>
                                @endif
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-sm">
                            {{ Str::limit($service->getTranslation('description', 'en'), 50) }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No services found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
