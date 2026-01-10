@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between sticky top-16 z-40 bg-gray-50 py-4 mx-auto xl:max-w-7xl">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Inquiries</h1>
                <p class="mt-2 text-gray-600">Manage all inquiries</p>
            </div>
            <a href="{{ route('admin.inquiries.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ADD INQUIRY
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow mx-auto xl:max-w-7xl">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Client</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Service</th>
                        <th class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Message</th>
                        <th class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Created</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($inquiries ?? [] as $inquiry)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                            {{ optional($inquiry->client)->first_name }} {{ optional($inquiry->client)->last_name }}
                        </td>
                        <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                            {{ optional($inquiry->service)->name ?? '—' }}
                        </td>
                        <td class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ Str::limit($inquiry->message, 80) }}</td>
                        <td class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ $inquiry->created_at->format('Y-m-d H:i') }}</td>
                        @include('partials.action-buttons', [
                            'editRoute' => 'admin.inquiries.edit',
                            'deleteRoute' => 'admin.inquiries.destroy',
                            'model' => $inquiry,
                            'confirmMessage' => 'Are you sure you want to delete this inquiry?'
                        ])
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="font-medium">No inquiries found</p>
                                <p class="text-sm mt-1">Create your first inquiry by clicking the ADD INQUIRY button above</p>
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
