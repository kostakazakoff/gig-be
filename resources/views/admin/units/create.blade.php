@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Create New Unit</h1>
                <p class="mt-2 text-gray-600">Add a new unit to the system</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('admin.units.store') }}" method="POST">
                    @csrf

                    <!-- Translation Key -->
                    <div class="mb-6">
                        <label for="translation_key" class="block text-sm font-medium text-gray-700 mb-2">
                            Translation Key <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="translation_key" id="translation_key"
                            value="{{ old('translation_key') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('translation_key') border-red-500 @enderror"
                            placeholder="e.g., per_hour, per_meter" required>
                        @error('translation_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Unique identifier for this unit (lowercase, underscores only)</p>
                    </div>

                    <!-- No service selection here; Services choose Unit -->

                    <!-- Name (EN) -->
                    <div class="mb-6">
                        <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Name (English) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name_en') border-red-500 @enderror"
                            placeholder="e.g., Per Hour" required>
                        @error('name_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name (BG) -->
                    <div class="mb-6">
                        <label for="name_bg" class="block text-sm font-medium text-gray-700 mb-2">
                            Name (Bulgarian) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name_bg" id="name_bg" value="{{ old('name_bg') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name_bg') border-red-500 @enderror"
                            placeholder="e.g., На час" required>
                        @error('name_bg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                            Create Unit
                        </button>
                        <a href="{{ route('admin.units.index') }}"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg text-center transition duration-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
