<!DOCTYPE html>
<html lang="bg" class="scroll-smooth" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админ Панел')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Детектиране и приложение на темата
        (function() {
            const htmlElement = document.documentElement;
            const stored = localStorage.getItem('theme');
            const isDark = stored 
                ? stored === 'dark' 
                : window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (isDark) {
                htmlElement.classList.add('dark');
            } else {
                htmlElement.classList.remove('dark');
            }
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        })();
    </script>
</head>

<body class="bg-white dark:bg-slate-950 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-slate-900 shadow-md dark:shadow-slate-900 px-6 sticky top-0 z-60 transition-colors duration-300">
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
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">
                        Категории
                    </a>
                    <a href="{{ route('admin.services.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">
                        Услуги
                    </a>
                    <a href="{{ route('admin.clients.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">
                        Клиенти
                    </a>
                    <a href="{{ route('admin.inquiries.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">
                        Запитвания
                    </a>
                    <a href="{{ route('admin.units.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">
                        Единици
                    </a>
                    <a href="{{ route('admin.projects.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">
                        Проекти
                    </a>
                    <a href="{{ route('admin.news.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">
                        Новини
                    </a>
                </div>

                <!-- Desktop User Menu -->
                <div class="hidden lg:flex items-center gap-4 relative">
                    <!-- Theme Toggle Button -->
                    <button type="button" id="theme-toggle"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-700 transition"
                        title="Превключи темата">
                        <!-- Sun icon -->
                        <svg id="light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l-2.12-2.12a.5.5 0 00-.707 0l-.707.707.707.707 2.12 2.121.707-.707-.707-.707zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM9 4a1 1 0 100-2 1 1 0 000 2zm0 16a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                        </svg>
                        <!-- Moon icon -->
                        <svg id="dark-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                        </svg>
                    </button>

                    <div class="hidden lg:flex items-center relative" id="user-menu">
                        <button type="button"
                            class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition focus:outline-none cursor-pointer"
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
                            class="hidden absolute right-0 mt-30 w-48 bg-white dark:bg-slate-900 rounded-md shadow-lg dark:shadow-slate-900 py-2 border border-gray-100 dark:border-slate-700 cursor-pointer transition">
                            <a href="{{ route('auth.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                Профил
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400 cursor-pointer transition">
                                    Изход
                                </button>
                            </form>
                        </div>
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
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-slate-800 font-medium transition px-4 py-2 rounded">
                        Категории
                    </a>
                    <a href="{{ route('admin.services.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-slate-800 font-medium transition px-4 py-2 rounded">
                        Услуги
                    </a>
                    <a href="{{ route('admin.clients.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-slate-800 font-medium transition px-4 py-2 rounded">
                        Клиенти
                    </a>
                    <a href="{{ route('admin.inquiries.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-slate-800 font-medium transition px-4 py-2 rounded">
                        Запитвания
                    </a>
                    <a href="{{ route('admin.units.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-slate-800 font-medium transition px-4 py-2 rounded">
                        Единици
                    </a>
                    <a href="{{ route('admin.projects.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-slate-800 font-medium transition px-4 py-2 rounded">
                        Проекти
                    </a>
                    <a href="{{ route('admin.news.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-slate-800 font-medium transition px-4 py-2 rounded">
                        Новини
                    </a>
                    <br>
                    <hr class="dark:border-slate-700">

                    <div class="px-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                        </svg>
                        <span>{{ auth()->user()->name }}</span>
                    </div>

                    <button type="button" id="theme-toggle-mobile"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400 cursor-pointer transition flex items-center justify-between">
                        <span>Тема</span>
                        <span id="theme-label">☀️</span>
                    </button>

                    <a href="{{ route('auth.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400 transition">
                        Профил
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400 transition">
                            Изход
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Theme toggle functionality
        function initTheme() {
            const htmlElement = document.documentElement;
            const themeToggle = document.getElementById('theme-toggle');
            const themeToggleMobile = document.getElementById('theme-toggle-mobile');
            const lightIcon = document.getElementById('light-icon');
            const darkIcon = document.getElementById('dark-icon');
            const themeLabel = document.getElementById('theme-label');

            function updateThemeUI() {
                const isDark = htmlElement.classList.contains('dark');
                if (isDark) {
                    lightIcon?.classList.remove('hidden');
                    darkIcon?.classList.add('hidden');
                    themeLabel && (themeLabel.textContent = '🌙');
                } else {
                    lightIcon?.classList.add('hidden');
                    darkIcon?.classList.remove('hidden');
                    themeLabel && (themeLabel.textContent = '☀️');
                }
            }

            function toggleTheme() {
                const isDark = htmlElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateThemeUI();
            }

            themeToggle?.addEventListener('click', toggleTheme);
            themeToggleMobile?.addEventListener('click', toggleTheme);
            
            updateThemeUI();
        }

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
            if (menu && !menu.contains(event.target)) {
                dropdown?.classList.add('hidden');
            }
        });

        // Initialize theme on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTheme);
        } else {
            initTheme();
        }

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                const htmlElement = document.documentElement;
                if (e.matches) {
                    htmlElement.classList.add('dark');
                } else {
                    htmlElement.classList.remove('dark');
                }
            }
        });
    </script>

    <!-- Main Content -->
    <main class="dark:bg-slate-900 shadow-md dark:shadow-slate-900 mt-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @yield('content')
        </div>
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
