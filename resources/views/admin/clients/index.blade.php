@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between sticky top-16 z-40 bg-gray-50 py-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Clients</h1>
                <p class="mt-2 text-gray-600">Manage all clients</p>
            </div>
            <a href="{{ route('admin.clients.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ADD CLIENT
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                <tr class="bg-gray-100 border-b border-gray-200">
                    <th class="px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm font-semibold text-gray-700">Image</th>
                    <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Name</th>
                    <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Email</th>
                    <th class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Phone</th>
                    <th class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Company</th>
                    <th class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Address</th>
                    <th class="hidden sm:table-cell px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm font-semibold text-gray-700">Inquiries</th>
                    <th class="px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm font-semibold text-gray-700">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($clients ?? [] as $client)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-2 sm:py-4 text-center">
                            @if ($client->getFirstMedia('category_thumbs'))
                                <img src="{{ $client->getFirstMedia('category_thumbs')->getUrl() }}" alt="{{ $client->first_name }} {{ $client->last_name }}"
                                    class="w-12 h-12 rounded object-cover" />
                            @else
                                <div class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                    No
                                </div>
                            @endif
                        </td>
                        <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-900 font-medium">
                            {{ $client->first_name }} {{ $client->last_name }}
                        </td>
                        <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-700">{{ $client->email }}</td>
                        <td class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-700">{{ $client->phone ?? '—' }}</td>
                        <td class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-700">{{ $client->company ?? '—' }}</td>
                        <td class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-700 truncate max-w-xs">{{ $client->address ?? '—' }}</td>
                        <td class="hidden sm:table-cell px-4 sm:px-6 py-2 sm:py-4 text-center text-xs lg:text-sm text-gray-700">{{ $client->inquiries_count ?? 0 }}</td>
                        @include('partials.action-buttons', [
                            'editRoute' => 'admin.clients.edit',
                            'deleteRoute' => 'admin.clients.destroy',
                            'model' => $client,
                            'confirmMessage' => 'Are you sure you want to delete this client?'
                        ])
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 01-8 0M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <p class="font-medium">No clients found</p>
                                <p class="text-sm mt-1">Create your first client by clicking the ADD CLIENT button above</p>
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
