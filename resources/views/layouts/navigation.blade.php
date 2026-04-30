<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm" x-data="{ open: false, userMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex flex-1 min-w-0">
                <a href="{{ route('dashboard') }}" class="flex items-center flex-shrink-0">
                    <img src="{{ asset('images/logos/logo.webp') }}" class="h-8 w-8 rounded" alt="Logo">
                    <span class="ml-2 text-lg font-bold text-gray-900 dark:text-white hidden sm:block">Tendejón Azael</span>
                </a>

                <div class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-0.5 lg:overflow-x-auto lg:scrollbar-hide">
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center whitespace-nowrap px-2 pt-1 border-b-2 text-sm font-medium transition-colors">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}"
                       class="{{ request()->routeIs('admin.products.*') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center whitespace-nowrap px-2 pt-1 border-b-2 text-sm font-medium transition-colors">
                        Productos
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                       class="{{ request()->routeIs('admin.categories.*') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center whitespace-nowrap px-2 pt-1 border-b-2 text-sm font-medium transition-colors">
                        Categorías
                    </a>
                    <a href="{{ route('admin.brands.index') }}"
                       class="{{ request()->routeIs('admin.brands.*') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center whitespace-nowrap px-2 pt-1 border-b-2 text-sm font-medium transition-colors">
                        Marcas
                    </a>
                    @can('articles.view')
                    <a href="{{ route('admin.articles.index') }}"
                       class="{{ request()->routeIs('admin.articles.*') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center whitespace-nowrap px-2 pt-1 border-b-2 text-sm font-medium transition-colors">
                        Artículos
                    </a>
                    @endcan
                    @can('reviews.view')
                    <a href="{{ route('admin.reviews.index') }}"
                       class="{{ request()->routeIs('admin.reviews.*') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center whitespace-nowrap px-2 pt-1 border-b-2 text-sm font-medium transition-colors">
                        Reseñas
                    </a>
                    @endcan
                    @can('users.view')
                    <a href="{{ route('admin.users.index') }}"
                       class="{{ request()->routeIs('admin.users.*') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center whitespace-nowrap px-2 pt-1 border-b-2 text-sm font-medium transition-colors">
                        Usuarios
                    </a>
                    @endcan
                    @can('roles.view')
                    <a href="{{ route('admin.roles.index') }}"
                       class="{{ request()->routeIs('admin.roles.*') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center whitespace-nowrap px-2 pt-1 border-b-2 text-sm font-medium transition-colors">
                        Roles
                    </a>
                    @endcan
                </div>
            </div>

            <div class="flex items-center space-x-3 flex-shrink-0">
                <!-- Dark mode toggle -->
                <button @click="toggleDark()" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Cambiar tema">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>

                <!-- User dropdown -->
                <div class="relative hidden lg:block">
                    <button @click="userMenu = !userMenu" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="userMenu" @click.away="userMenu = false" x-transition
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-600">
                        <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-600">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role->display_name ?? 'Sin rol' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Mi Perfil</a>
                        <a href="{{ route('home') }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Ver Tienda</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>

                <!-- Mobile hamburger -->
                <button @click="open = !open" class="lg:hidden p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="hamburger" :class="open && 'open'">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu overlay -->
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="open = false"
         class="lg:hidden fixed inset-0 bg-black/50 z-40">
    </div>

    <!-- Mobile menu slide-in -->
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform translate-x-full" x-transition:enter-end="transform translate-x-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform translate-x-0" x-transition:leave-end="transform translate-x-full"
         class="lg:hidden fixed right-0 top-16 w-72 bg-white dark:bg-gray-800 shadow-2xl z-50 overflow-y-auto border-l border-gray-200 dark:border-gray-700" style="height: calc(100vh - 4rem);">
        <div class="p-4">
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Productos
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Categorías
                </a>
                <a href="{{ route('admin.brands.index') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.brands.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Marcas
                </a>
                @can('articles.view')
                <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.articles.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Artículos
                </a>
                @endcan
                @can('reviews.view')
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.reviews.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Reseñas
                </a>
                @endcan
                @can('users.view')
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Usuarios
                </a>
                @endcan
                @can('roles.view')
                <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.roles.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Roles
                </a>
                @endcan
            </nav>
            <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                <div class="flex items-center gap-3 px-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role->display_name ?? 'Sin rol' }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Mi Perfil
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Ver Tienda
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 py-2.5 px-3 rounded-lg text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition w-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
