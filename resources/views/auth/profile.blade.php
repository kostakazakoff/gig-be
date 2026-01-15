@extends('layouts.app')

@section('title', 'Настройки')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Профил на администратора</h1>
        <p class="mt-2 text-gray-600">Управление на вашия профил и пароли</p>
    </div>

    <!-- Update Profile Form -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Профилни данни</h2>

        <form action="{{ route('auth.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4 mb-6">
                    <div class="text-sm text-red-800">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('status') === 'profile-updated')
                <div class="rounded-md bg-green-50 p-4 mb-6">
                    <div class="text-sm text-green-800">
                        Профилът е успешно обновен.
                    </div>
                </div>
            @endif

            <div class="space-y-6">
                <!-- Username -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Потребителско име
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        required
                    >
                    {{-- @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror --}}
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Имейл адрес
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                        required
                    >
                    {{-- @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror --}}
                </div>
            </div>

            <div class="mt-8">
                <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Обнови профил
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Смяна на парола</h2>

        <form action="{{ route('auth.update-password') }}" method="POST">
            @csrf
            @method('POST')

            <!-- Password Validation Errors -->
            @if ($errors->has('current_password') || $errors->has('password'))
                <div class="rounded-md bg-red-50 p-4 mb-6">
                    <div class="text-sm text-red-800">
                        @if ($errors->has('current_password'))
                            <p>{{ $errors->first('current_password') }}</p>
                        @endif
                        @if ($errors->has('password'))
                            <p>{{ $errors->first('password') }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Password Success Message -->
            @if (session('status') === 'password-updated')
                <div class="rounded-md bg-green-50 p-4 mb-6">
                    <div class="text-sm text-green-800">
                        Паролата е успешно променена.
                    </div>
                </div>
            @endif

            <div class="space-y-6">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Текуща парола
                    </label>
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror"
                        required
                        autocomplete="current-password"
                    >
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Нова парола
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                        required
                        autocomplete="new-password"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Потвърди парола
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        required
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <div class="mt-8">
                <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Смени парола
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
