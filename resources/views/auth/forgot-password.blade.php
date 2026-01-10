<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Забравена парола - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Забравена парола
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Въведете вашия имейл адрес и ще ви изпратим линк за възстановяване на паролата.
                </p>
            </div>

            <!-- Form -->
            <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Session Status -->
                @if (session('status'))
                    <div class="rounded-md bg-green-50 p-4">
                        <p class="text-sm text-green-800">{{ session('status') }}</p>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="text-sm text-red-800">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Имейл адрес
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        value="{{ old('email') }}"
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="email@example.com"
                    >
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Изпрати линк за възстановяване
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        ← Назад към вход
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
