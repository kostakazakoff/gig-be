<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-md px-6 sticky top-0 z-60">
        <div class="xl:max-w-7xl mx-auto">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('admin.categories.index') }}" class="text-2xl font-bold text-blue-600">
                        Admin Panel
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition"
                    >
                        Categories
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Services
                    </a>
                    <a href="{{ route('admin.clients.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Clients
                    </a>
                    <a href="{{ route('admin.inquiries.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Inquiries
                    </a>
                    <a href="{{ route('admin.units.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Units
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Projects
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        News
                    </a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Settings
                    </a>
                </div>

                <!-- Desktop User Menu -->
                <div class="hidden lg:flex items-center">
                    <button class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Logout
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button id="mobile-menu-btn" type="button" class="text-gray-700 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded p-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="hidden lg:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded"
                    >
                        Categories
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Services
                    </a>
                    <a href="{{ route('admin.clients.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Clients
                    </a>
                    <a href="{{ route('admin.inquiries.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Inquiries
                    </a>
                    <a href="{{ route('admin.units.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Units
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Projects
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        News
                    </a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Settings
                    </a>
                    <button class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded text-left">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

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
