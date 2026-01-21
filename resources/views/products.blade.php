<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Tendejón Azael</title>
    <meta name="description" content="Explora nuestro catálogo completo de productos en Tendejón Azael.">
    <link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body x-data="{ mobileMenu: false, scrolled: false, showFilters: false, darkMode: localStorage.getItem('darkMode') === 'true' }" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
<script>
    function toggleDarkMode() {
        const body = document.body;
        const html = document.documentElement;
        const isDark = html.classList.toggle('dark');
        localStorage.setItem('darkMode', isDark);
        if (window.Alpine) {
            Alpine.store('darkMode', isDark);
        }
        return isDark;
    }
</script>

    <!-- Header / Nav -->
    <header :class="scrolled ? 'bg-white dark:bg-gray-800 shadow-lg' : 'bg-white/95 dark:bg-gray-800/95'" class="fixed w-full top-0 z-[60] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center">
                    <img x-show="!darkMode" src="{{ asset('images/logos/logo_text_dark.webp') }}" alt="Tendejón Azael" class="h-10 md:h-12 w-auto">
                    <img x-show="darkMode" x-cloak src="{{ asset('images/logos/logo_text.webp') }}" alt="Tendejón Azael" class="h-10 md:h-12 w-auto">
                </a>

                <!-- Desktop Menu -->
                <ul class="hidden lg:flex items-center gap-8">
                    <li><a href="/" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium">Inicio</a></li>
                    <li><a href="{{ route('products') }}" class="text-cyan-600 dark:text-cyan-400 font-semibold">Productos</a></li>
                    <li><a href="/#contacto" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium">Contacto</a></li>
                    
                    <!-- Dark Mode Toggle -->
                    <li>
                        <button @click="darkMode = toggleDarkMode()" 
                                class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i x-show="!darkMode" class="fas fa-moon"></i>
                            <i x-show="darkMode" x-cloak class="fas fa-sun"></i>
                        </button>
                    </li>
                </ul>

                <!-- Mobile Controls -->
                <div class="flex lg:hidden items-center gap-3">
                    <button @click="darkMode = toggleDarkMode()" 
                            class="w-10 h-10 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition cursor-pointer">
                        <i x-show="!darkMode" class="fas fa-moon text-xl"></i>
                        <i x-show="darkMode" x-cloak class="fas fa-sun text-xl"></i>
                    </button>
                    <button @click="mobileMenu = !mobileMenu" 
                            class="w-10 h-10 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition-all duration-300">
                        <i :class="mobileMenu ? 'fas fa-times' : 'fas fa-bars'" class="text-xl"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenu" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenu = false"
         class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40">
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" 
         x-clok
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform translate-x-full"
         x-transition:enter-end="transform translate-x-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform translate-x-0"
         x-transition:leave-end="transform translate-x-full"
         class="lg:hidden fixed right-0 top-16 w-72 bg-white dark:bg-gray-800 shadow-2xl z-50 overflow-y-auto" style="height: calc(100vh - 4rem);">
        <div class="p-6">
            <nav>
                <ul class="space-y-1">
                    <li>
                        <a @click="mobileMenu = false" href="/" 
                           class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-all font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 group">
                            <i class="fas fa-home w-5 text-gray-400 group-hover:text-cyan-500"></i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a @click="mobileMenu = false" href="{{ route('products') }}" 
                           class="flex items-center gap-3 py-3 px-4 bg-cyan-50 dark:bg-gray-700 rounded-lg font-semibold text-cyan-600 dark:text-cyan-400 group">
                            <i class="fas fa-shopping-bag w-5 text-cyan-500"></i>
                            <span>Productos</span>
                        </a>
                    </li>
                    <li>
                        <a @click="mobileMenu = false" href="/#contacto" 
                           class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-all font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 group">
                            <i class="fas fa-phone w-5 text-gray-400 group-hover:text-cyan-500"></i>
                            <span>Contacto</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
            x-show="scrolled"
            x-cloak
            x-transition
            class="fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-all duration-300 z-40">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Main Content -->
    <div class="pt-20 md:pt-24 pb-8 md:pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-4 md:mb-8">
                <h1 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white mb-1 md:mb-2">Catálogo de Productos</h1>
                <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Descubre todos nuestros productos disponibles</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filtros - Desktop -->
                <aside class="hidden lg:block w-64 flex-shrink-0">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class="fas fa-filter text-cyan-600 dark:text-cyan-400"></i> Filtros
                        </h3>
                        
                        <form method="GET" action="{{ route('products') }}">
                            <!-- Búsqueda -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-search mr-1"></i> Buscar
                                </label>
                                <input type="text" name="search" placeholder="Nombre del producto..." 
                                       value="{{ request('search') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                            </div>

                            <!-- Categorías -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    <i class="fas fa-tags mr-1"></i> Categorías
                                </h4>
                                <div class="space-y-2 max-h-64 overflow-y-auto">
                                    <div class="flex items-center">
                                        <input type="radio" name="category" value="" 
                                               {{ !request('category') ? 'checked' : '' }}
                                               id="cat-all"
                                               class="rounded-full border-gray-300 text-cyan-600 focus:ring-cyan-500">
                                        <label for="cat-all" class="ml-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                            Todas las categorías
                                        </label>
                                    </div>
                                    @foreach($categories as $category)
                                    <div class="flex items-center">
                                        <input type="radio" name="category" value="{{ $category->slug }}" 
                                               {{ request('category') == $category->slug ? 'checked' : '' }}
                                               id="cat-{{ $category->id }}"
                                               class="rounded-full border-gray-300 text-cyan-600 focus:ring-cyan-500">
                                        <label for="cat-{{ $category->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer flex-1">
                                            {{ $category->name }}
                                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $category->products_count }})</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Ordenar -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-sort mr-1"></i> Ordenar por
                                </label>
                                <select name="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Más recientes</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Menor precio</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Mayor precio</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre A-Z</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                    <i class="fas fa-check mr-2"></i> Aplicar Filtros
                                </button>
                                <a href="{{ route('products') }}" class="block w-full text-center bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-lg transition">
                                    <i class="fas fa-times mr-2"></i> Limpiar
                                </a>
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- Mobile Filters Button -->
                <div class="lg:hidden mb-3 md:mb-4">
                    <button @click="showFilters = !showFilters" class="w-full bg-white dark:bg-gray-800 rounded-lg md:rounded-xl shadow-lg p-3 md:p-4 flex items-center justify-between text-gray-900 dark:text-white font-semibold text-sm md:text-base">
                        <span><i class="fas fa-filter mr-2 text-cyan-600 dark:text-cyan-400"></i> Filtros</span>
                        <i :class="showFilters ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                    </button>
                    
                    <!-- Mobile Filters Panel -->
                    <div x-show="showFilters" x-cloak x-transition class="mt-3 md:mt-4 bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6">
                        <form method="GET" action="{{ route('products') }}">
                            <div class="space-y-3 md:space-y-4">
                                <input type="text" name="search" placeholder="Buscar productos..." 
                                       value="{{ request('search') }}"
                                       class="w-full px-3 py-2 md:px-4 md:py-2 text-sm md:text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg">
                                
                                <select name="category" class="w-full px-3 py-2 md:px-4 md:py-2 text-sm md:text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg">
                                    <option value="">Todas las categorías</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->products_count }})
                                    </option>
                                    @endforeach
                                </select>
                                
                                <select name="sort" class="w-full px-3 py-2 md:px-4 md:py-2 text-sm md:text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg">
                                    <option value="latest">Más recientes</option>
                                    <option value="price_asc">Menor precio</option>
                                    <option value="price_desc">Mayor precio</option>
                                    <option value="name">Nombre A-Z</option>
                                </select>
                                
                                <div class="flex gap-2">
                                    <button type="submit" class="flex-1 bg-cyan-500 text-white font-bold text-sm md:text-base py-2 px-3 md:px-4 rounded-lg">
                                        Aplicar
                                    </button>
                                    <a href="{{ route('products') }}" class="flex-1 text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold text-sm md:text-base py-2 px-3 md:px-4 rounded-lg">
                                        Limpiar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="flex-1">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
                            @foreach($products as $product)
                            <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                                <div class="h-32 md:h-56 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center overflow-hidden">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                    <i class="fas fa-box-open text-4xl md:text-7xl text-gray-400 dark:text-gray-600"></i>
                                    @endif
                                </div>
                                <div class="p-2 md:p-5">
                                    <div class="hidden md:flex items-center justify-between mb-2">
                                        <span class="inline-block px-3 py-1 bg-cyan-100 dark:bg-cyan-900 text-cyan-600 dark:text-cyan-300 text-xs font-semibold rounded-full">
                                            {{ $product->category->name }}
                                        </span>
                                        @if($product->brand)
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $product->brand->name }}</span>
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-xs md:text-xl text-gray-900 dark:text-white mb-1 md:mb-2 line-clamp-2">{{ $product->name }}</h3>
                                    <p class="hidden md:block text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
                                    @if($product->weight)
                                    <p class="hidden md:block text-gray-500 dark:text-gray-500 text-xs mb-3"><i class="fas fa-weight mr-1"></i>{{ $product->weight }}</p>
                                    @endif
                                    <div class="flex flex-col md:flex-row justify-between md:items-center pt-2 md:pt-3 border-t border-gray-200 dark:border-gray-700 gap-1 md:gap-0">
                                        <div>
                                            <span class="text-base md:text-3xl font-bold text-cyan-600 dark:text-cyan-400">${{ number_format($product->price, 2) }}</span>
                                            @if($product->sale_price && $product->sale_price < $product->price)
                                            <span class="block text-xs md:text-sm line-through text-gray-400 dark:text-gray-500">${{ number_format($product->sale_price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="text-left md:text-right">
                                            @if($product->stock > 0)
                                            <span class="inline-block px-1.5 py-0.5 md:px-2 md:py-1 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 text-xs font-semibold rounded">
                                                <i class="fas fa-check-circle"></i> <span class="hidden md:inline">Disponible</span>
                                            </span>
                                            @else
                                            <span class="inline-block px-1.5 py-0.5 md:px-2 md:py-1 bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 text-xs font-semibold rounded">
                                                <i class="fas fa-times-circle"></i> <span class="hidden md:inline">Agotado</span>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-12 text-center">
                            <i class="fas fa-search text-6xl text-gray-400 dark:text-gray-600 mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No se encontraron productos</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Intenta con otros filtros de búsqueda</p>
                            <a href="{{ route('products') }}" class="inline-block bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:shadow-xl transition">
                                Ver todos los productos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 md:py-12 mt-6 md:mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 mb-4 md:mb-8">
                <div>
                    <h3 class="text-lg md:text-2xl font-bold mb-2 md:mb-4 bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Tendejón Azael</h3>
                    <p class="text-sm md:text-base text-gray-400">Tu tienda de abarrotes de confianza desde 2007.</p>
                </div>
                <div>
                    <h3 class="text-base md:text-xl font-bold mb-2 md:mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-1 md:space-y-2 text-sm md:text-base">
                        <li><a href="/" class="text-gray-400 hover:text-cyan-400 transition">Inicio</a></li>
                        <li><a href="{{ route('products') }}" class="text-gray-400 hover:text-cyan-400 transition">Productos</a></li>
                        <li><a href="/#contacto" class="text-gray-400 hover:text-cyan-400 transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-base md:text-xl font-bold mb-2 md:mb-4">Síguenos</h3>
                    <div class="flex gap-3 md:gap-4 text-xl md:text-2xl">
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.me/9991161668" target="_blank" class="text-gray-400 hover:text-cyan-400 transition"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-4 md:pt-8 text-center text-xs md:text-base text-gray-400">
                <p>&copy; 2007-{{ date('Y') }} Tendejón Azael. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>
