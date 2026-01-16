<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админ Панел')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-md px-6 sticky top-0 z-60">
        <div class="xl:max-w-7xl mx-auto">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center overflow-hidden">
                    {{-- <a href="{{ route('admin.categories.index') }}" class="text-2xl font-bold text-blue-600">
                        Админ Панел
                    </a> --}}
                    <img src="{{ asset('GIG_960x480.jpg') }}" class="mx-auto h-24 object-contain" alt="GIG Logo">
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('admin.categories.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Категории
                    </a>
                    <a href="{{ route('admin.services.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Услуги
                    </a>
                    <a href="{{ route('admin.clients.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Клиенти
                    </a>
                    <a href="{{ route('admin.inquiries.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Запитвания
                    </a>
                    <a href="{{ route('admin.units.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Единици
                    </a>
                    <a href="{{ route('admin.projects.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Проекти
                    </a>
                    <a href="{{ route('admin.news.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Новини
                    </a>
                </div>

                <!-- Desktop User Menu -->
                <div class="hidden lg:flex items-center relative" id="user-menu">
                    <button type="button"
                        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium transition focus:outline-none cursor-pointer"
                        onclick="toggleUserMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                        </svg>
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- User Dropdown Menu --}}
                    <div id="user-menu-dropdown"
                        class="hidden absolute right-0 mt-30 w-48 bg-white rounded-md shadow-lg py-2 border border-gray-100 cursor-pointer">
                        <a href="{{ route('auth.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                            Профил
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 cursor-pointer">
                                Изход
                            </button>
                        </form>
                    </div>

                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button id="mobile-menu-btn" type="button"
                        class="text-gray-700 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded p-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="hidden lg:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('admin.categories.index') }}"
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Категории
                    </a>
                    <a href="{{ route('admin.services.index') }}"
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Услуги
                    </a>
                    <a href="{{ route('admin.clients.index') }}"
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Клиенти
                    </a>
                    <a href="{{ route('admin.inquiries.index') }}"
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Запитвания
                    </a>
                    <a href="{{ route('admin.units.index') }}"
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Единици
                    </a>
                    <a href="{{ route('admin.projects.index') }}"
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Проекти
                    </a>
                    <a href="{{ route('admin.news.index') }}"
                        class="text-gray-700 hover:text-blue-600 hover:bg-gray-50 font-medium transition px-4 py-2 rounded">
                        Новини
                    </a>
                    <br>
                    <hr>

                    <div class="px-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                    </svg>
                    <span>{{ auth()->user()->name }}</span>
                    </div>

                    <a href="{{ route('auth.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                        Профил
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                            Изход
                        </button>
                    </form>
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

        // User dropdown toggle
        function toggleUserMenu() {
            document.getElementById('user-menu-dropdown').classList.toggle('hidden');
        }

        // Close user menu on outside click
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('user-menu');
            const dropdown = document.getElementById('user-menu-dropdown');
            if (!menu.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
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
                &copy; {{ date('Y') }} Админ панел. Всички права запазени.
            </p>
        </div>
    </footer>
</body>

</html>
