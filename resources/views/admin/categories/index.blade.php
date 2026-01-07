@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="min-h-screen max-w-6xl mx-auto">
            <!-- Header with Add Button -->
            <div class="mb-8 flex items-center justify-between sticky top-18 z-50 bg-gray-50 py-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
                    <p class="mt-2 text-gray-600">Manage all categories in the system</p>
                </div>
                <a href="{{ route('admin.categories.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                    + ADD CATEGORY
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Categories Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Key</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name (EN)</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name (BG)</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories ?? [] as $category)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center">
                                    @if ($category->image_src)
                                        <img src="{{ $category->image_src }}" alt="{{ $category->translation_key }}"
                                            class="w-12 h-12 rounded object-cover" />
                                    @else
                                        <div
                                            class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                            No</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $category->translation_key }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $category->getTranslation('name', 'bg') ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 truncate max-w-xs">
                                    {{ substr($category->description ?? '—', 0, 50) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="inline-flex items-center px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-300 rounded hover:bg-yellow-100 transition text-sm font-medium">
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p class="font-medium">No categories found</p>
                                        <p class="text-sm mt-1">Create your first category by clicking the ADD CATEGORY
                                            button above</p>
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
