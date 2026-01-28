@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Създай услуга</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow">
            @csrf

            <!-- Category Select -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Категория</label>
                <select name="category_id"
                    class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror" required>
                    <option value="">Изберете категория</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Key Field -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Ключ</label>
                <input type="text" name="key" value="{{ old('key') }}"
                    class="w-full border rounded px-3 py-2 @error('key') border-red-500 @enderror" required
                    placeholder="service_key">
                @error('key')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                @include('partials.single-image-dropzone', ['label' => 'Изображение'])
            </div>

            <!-- Bulgarian Name -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Име (Български)</label>
                <input type="text" name="name_bg" id="name_bg" value="{{ old('name_bg') }}"
                    class="w-full border rounded px-3 py-2 @error('name_bg') border-red-500 @enderror" required>
                @error('name_bg')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- English Name -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Име (Английски)</label>
                <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}"
                    class="w-full border rounded px-3 py-2 @error('name_en') border-red-500 @enderror" required>
                @error('name_en')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="button" id="translate-name-btn"
                class="h-10 px-3 bg-blue-200 hover:bg-blue-300 text-gray-800 font-medium rounded-lg transition duration-200 w-full cursor-pointer">
                Преведи
            </button>

            <!-- Bulgarian Description -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Описание (Български)</label>
                <textarea name="description_bg" id="description_bg"
                    class="w-full border rounded px-3 py-2 @error('description_bg') border-red-500 @enderror" rows="4">{{ old('description_bg') }}</textarea>
                @error('description_bg')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- English Description -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Описание (Английски)</label>
                <textarea name="description_en" id="description_en"
                    class="w-full border rounded px-3 py-2 @error('description_en') border-red-500 @enderror" rows="4">{{ old('description_en') }}</textarea>
                @error('description_en')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="button" id="translate-desc-btn"
                class="h-10 px-3 bg-blue-200 hover:bg-blue-300 text-gray-800 font-medium rounded-lg transition duration-200 w-full cursor-pointer">
                Преведи
            </button>

            <!-- Price From -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Цена от</label>
                <input type="number" name="price_from" value="{{ old('price_from') }}" step="0.01" min="0"
                    class="w-full border rounded px-3 py-2 @error('price_from') border-red-500 @enderror">
                @error('price_from')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Price To -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Цена до</label>
                <input type="number" name="price_to" value="{{ old('price_to') }}" step="0.01" min="0"
                    class="w-full border rounded px-3 py-2 @error('price_to') border-red-500 @enderror">
                @error('price_to')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Unit Select -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Единица</label>
                <select name="unit_id" class="w-full border rounded px-3 py-2 @error('unit_id') border-red-500 @enderror">
                    <option value="">Изберете единица</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                            {{ $unit->getTranslation('name', app()->getLocale()) ?? $unit->translation_key }}
                        </option>
                    @endforeach
                </select>
                @error('unit_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Създай
                    услуга</button>
                <a href="{{ route('admin.services.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">Откажи</a>
            </div>
        </form>
    </div>

    {{-- Drag & drop image script is now initialized globally via resources/js/app.js --}}
@endsection

{{-- Translation Script --}}

@include('partials.translation-script', [
    'btnSelector' => '#translate-name-btn',
    'bgFieldSelector' => '#name_bg',
    'enFieldSelector' => '#name_en',
]);

@include('partials.translation-script', [
    'btnSelector' => '#translate-desc-btn',
    'bgFieldSelector' => '#description_bg',
    'enFieldSelector' => '#description_en',
]);
