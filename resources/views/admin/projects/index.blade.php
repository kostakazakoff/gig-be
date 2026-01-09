@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-center justify-between sticky top-16 z-40 bg-gray-50 py-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Projects</h1>
                <p class="mt-2 text-gray-600">Manage all projects in the system</p>
            </div>
            <a href="{{ route('admin.projects.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ADD PROJECT
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Projects Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm font-semibold text-gray-700">Image</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Key</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Title (EN)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Title (BG)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Price</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-semibold text-gray-700">Date</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-center text-xs lg:text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects ?? [] as $project)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-center">
                                @if ($project->image_src)
                                    <img src="{{ $project->image_src }}" alt="{{ $project->translation_key }}"
                                        class="w-12 h-12 rounded object-cover" />
                                @else
                                    <div
                                        class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                        No</div>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-900 font-medium">{{ $project->translation_key }}</td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-700">{{ $project->title }}</td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-700">
                                {{ $project->getTranslation('title', 'bg') ?? '—' }}
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-700">
                                {{ $project->price ? number_format($project->price, 2) . ' лв.' : '—' }}
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-xs lg:text-sm text-gray-700">
                                {{ $project->date ? \Carbon\Carbon::parse($project->date)->format('d.m.Y') : '—' }}
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.projects.edit', $project->id) }}"
                                        class="inline-flex items-center px-3 py-1 my-1 bg-yellow-50 text-yellow-700 border border-yellow-300 rounded hover:bg-yellow-100 transition text-sm font-medium">
                                        Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this project?')">
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
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No projects found. <a href="{{ route('admin.projects.create') }}"
                                    class="text-blue-600 hover:underline">Create your first project</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection
