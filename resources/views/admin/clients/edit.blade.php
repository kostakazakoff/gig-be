@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Редактирай клиент</h1>
            <p class="mt-2 text-gray-600">Актуализирай информацията на клиента</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.clients.update', $client->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Image Upload Field (Drag & Drop) -->
                <div>
                    @include('partials.single-image-dropzone', [
                        'label' => 'Изображение към клиент',
                        'existingImage' => $client->image_src,
                        'deleteUrl' => route('admin.clients.deleteImage', $client),
                    ])
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">Име <span class="text-red-600">*</span></label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $client->first_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror" required>
                        @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Фамилия</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $client->last_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-600">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" required>
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Телефон</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $client->phone) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Компания</label>
                    <input type="text" id="company" name="company" value="{{ old('company', $client->company) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('company') border-red-500 @enderror">
                    @error('company')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="site" class="block text-sm font-medium text-gray-700 mb-2">Сайт</label>
                    <input type="text" id="site" name="site" value="{{ old('site', $client->site) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('site') border-red-500 @enderror" placeholder="https://example.com">
                    @error('site')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Адрес</label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $client->address) }}</textarea>
                    @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t pt-6 flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 cursor-pointer">
                        Запази изменения
                    </button>
                    <a href="{{ route('admin.clients.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-200 text-center">
                        Откажи
                    </a>
                </div>
            </form>

            <!-- Delete Button (Separate Form) -->
            <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="mt-6 pt-6 border-t border-gray-200"
                onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този клиент?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium cursor-pointer">
                    Изтрий клиент
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
