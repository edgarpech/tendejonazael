<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700" x-data="{ open: false, userMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img x-show="!darkMode" src="{{ asset('images/logos/logo_text.webp') }}" alt="Tendejón Azael" class="h-8 w-auto">
                        <img x-show="darkMode" x-cloak src="{{ asset('images/logos/logo_text_dark.webp') }}" alt="Tendejón Azael" class="h-8 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-primary-600 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }} text-sm font-medium">
                        Dashboard
                    </a>
                    
                    @can('products.view')
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.products.*') ? 'border-primary-600 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }} text-sm font-medium">
                        Productos
                    </a>
                    @endcan
                    
                    @can('categories.view')
                    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.categories.*') ? 'border-primary-600 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }} text-sm font-medium">
                        Categorías
                    </a>
                    @endcan
                    
                    @can('brands.view')
                    <a href="{{ route('admin.brands.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.brands.*') ? 'border-primary-600 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }} text-sm font-medium">
                        Marcas
                    </a>
                    @endcan
                    
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.users.*') ? 'border-primary-600 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }} text-sm font-medium">
                        Usuarios
                    </a>
                    @endif
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ml-6" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark', darkMode)" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 mr-2">
                    <!-- Moon icon - Mostrar cuando está en modo claro (darkMode = false) -->
                    <svg x-show="!darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <!-- Sun icon - Mostrar cuando está en modo oscuro (darkMode = true) -->
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div class="relative">
                    <button @click="userMenu = !userMenu" @mouseenter="userMenu = true" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="userMenu" 
                         x-cloak
                         @click.away="userMenu = false" 
                         @mouseleave="userMenu = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                        <span class="block px-4 py-2 text-xs text-gray-400">{{ auth()->user()->role->display_name ?? 'Sin rol' }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-primary-600 text-primary-700 bg-primary-50 dark:bg-gray-700' : 'border-transparent text-gray-600 hover:bg-gray-50 dark:text-gray-400' }} text-base font-medium">
                Dashboard
            </a>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>