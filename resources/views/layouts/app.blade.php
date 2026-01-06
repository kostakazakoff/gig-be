<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('admin.categories.index') }}" class="text-2xl font-bold text-blue-600">
                        Admin Panel
                    </a>
                </div>

                <!-- Menu -->
                <div class="flex items-center space-x-8">
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition"
                    >
                        Categories
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Services
                    </a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Settings
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center">
                    <button class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-md mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-600">
                &copy; {{ date('Y') }} Admin Dashboard. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
