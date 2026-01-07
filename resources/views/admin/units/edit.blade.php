@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Unit</h1>
                <p class="mt-2 text-gray-600">Update unit information</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('admin.units.update', $unit) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Translation Key -->
                    <div class="mb-6">
                        <label for="translation_key" class="block text-sm font-medium text-gray-700 mb-2">
                            Translation Key <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="translation_key" id="translation_key"
                            value="{{ old('translation_key', $unit->translation_key) }}"
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
                        <input type="text" name="name_en" id="name_en"
                            value="{{ old('name_en', $unit->getTranslation('name', 'en')) }}"
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
                        <input type="text" name="name_bg" id="name_bg"
                            value="{{ old('name_bg', $unit->getTranslation('name', 'bg')) }}"
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
                            Update Unit
                        </button>
                        <a href="{{ route('admin.units.index') }}"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg text-center transition duration-200">
                            Cancel
                        </a>
                    </div>
                </form>

                <!-- Delete Button (Separate Form) -->
                <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" class="mt-6 pt-6 border-t border-gray-200"
                    onsubmit="return confirm('Are you sure you want to delete this unit?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                        Delete Unit
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
