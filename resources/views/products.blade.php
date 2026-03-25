<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Tendejón Azael | Abarrotes, Bebidas y más en Chabihau, Yucatán</title>
    <meta name="description" content="Explora nuestro catálogo completo de productos en Tendejón Azael, Chabihau, Yucatán. Abarrotes, bebidas, snacks, hielo y todo lo que necesitas para tus vacaciones en el puerto.">
    <meta name="keywords" content="productos abarrotes Chabihau, catálogo tienda Yucatán, bebidas playa, snacks vacaciones, compras Chabihau, precios abarrotes Yucatán, tienda cerca playa Chabihau">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/productos') }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/productos') }}">
    <meta property="og:title" content="Productos - Tendejón Azael | Chabihau, Yucatán">
    <meta property="og:description" content="Explora nuestro catálogo completo de abarrotes, bebidas, snacks y más en Tendejón Azael, Chabihau.">
    <meta property="og:image" content="{{ asset('images/logos/logo_general.jpg') }}">
    <meta property="og:locale" content="es_MX">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Productos - Tendejón Azael | Chabihau, Yucatán">
    <meta name="twitter:description" content="Catálogo completo de productos. Abarrotes, bebidas, snacks y más en Chabihau.">
    <meta name="twitter:image" content="{{ asset('images/logos/logo_general.jpg') }}">

    <link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}" />
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        .goog-te-banner-frame, .skiptranslate { display: none !important; }
        body { top: 0 !important; }
        .goog-te-gadget .goog-te-combo { display: none !important; }
        .goog-te-gadget { font-size: 0 !important; }
        .goog-te-gadget span { display: none; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
        .dark ::-webkit-scrollbar-thumb { background-color: #475569; }
        .dark ::-webkit-scrollbar-thumb:hover { background-color: #64748b; }

        /* Thin scrollbar for category bar */
        .scrollbar-thin::-webkit-scrollbar { height: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
        .dark .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #475569; }
    </style>
</head>
<body x-data="productCatalog()" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
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

    function goToContact() {
        sessionStorage.setItem('scrollTo', 'contacto');
        window.location.href = '/';
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
                    <li><a href="javascript:void(0)" onclick="goToContact()" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium cursor-pointer">Contacto</a></li>
                    
                    <!-- Dark Mode Toggle -->
                    <li>
                        <button @click="darkMode = toggleDarkMode()" 
                                class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i x-show="!darkMode" class="fas fa-moon"></i>
                            <i x-show="darkMode" x-cloak class="fas fa-sun"></i>
                        </button>
                    </li>

                    <!-- Translate -->
                    <li>
                        <div id="google_translate_element_desktop" class="hidden"></div>
                        <button @click="translatePage()" 
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition cursor-pointer"
                                :class="lang === 'en' ? 'bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'">
                            <i class="fas fa-globe"></i>
                            <span x-text="lang === 'en' ? 'EN' : 'ES'"></span>
                        </button>
                    </li>
                </ul>

                <!-- Mobile Controls -->
                <div class="flex lg:hidden items-center gap-2">
                    <button @click="translatePage()" 
                            class="w-10 h-10 flex items-center justify-center transition cursor-pointer"
                            :class="lang === 'en' ? 'text-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400'">
                        <i class="fas fa-globe text-xl"></i>
                    </button>
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
                        <a @click="mobileMenu = false" href="javascript:void(0)" onclick="goToContact()" 
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
            class="fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-r from-cyan-600 to-blue-700 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-all duration-300 z-40">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Main Content -->
    <div class="pt-20 md:pt-24 pb-8 md:pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-4 md:mb-8">
                <h1 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white mb-1 md:mb-2">Catálogo de Productos</h1>
                <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Explora todo nuestro catálogo de productos</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filtros - Desktop -->
                <aside class="hidden lg:block w-64 flex-shrink-0">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class="fas fa-filter text-cyan-600 dark:text-cyan-400"></i> Filtros
                        </h3>
                        
                        <!-- Búsqueda -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-search mr-1"></i> Buscar
                            </label>
                            <input type="text" x-model="search" placeholder="Nombre del producto..." 
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                        </div>

                        <!-- Categorías -->
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                <i class="fas fa-tags mr-1"></i> Categorías
                            </h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                <div class="flex items-center">
                                    <input type="radio" name="category" value="0" 
                                           x-model.number="categoryId"
                                           id="cat-all"
                                           class="rounded-full border-gray-300 text-cyan-600 focus:ring-cyan-500">
                                    <label for="cat-all" class="ml-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                        Todas las categorías
                                    </label>
                                </div>
                                @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input type="radio" name="category" value="{{ $category->id_category }}" 
                                           x-model.number="categoryId"
                                           id="cat-{{ $category->id_category }}"
                                           class="rounded-full border-gray-300 text-cyan-600 focus:ring-cyan-500">
                                    <label for="cat-{{ $category->id_category }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer flex-1">
                                        {{ $category->name }}
                                        <span class="text-xs text-gray-500 dark:text-gray-400">({{ $category->products_count }})</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Disponibilidad removed -->

                        <!-- Ordenar -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-sort mr-1"></i> Ordenar por
                            </label>
                            <select x-model="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                                <option value="name">Nombre A-Z</option>
                                <option value="price_asc">Menor precio</option>
                                <option value="price_desc">Mayor precio</option>
                                <option value="latest">Más recientes</option>
                            </select>
                        </div>

                        <button @click="search = ''; categoryId = 0; sort = 'name'; page = 1;" class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-times mr-2"></i> Limpiar Filtros
                        </button>
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
                        <div class="space-y-3 md:space-y-4">
                            <input type="text" x-model="search" placeholder="Buscar productos..." 
                                   class="w-full px-3 py-2 md:px-4 md:py-2 text-sm md:text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg">
                            
                            <select x-model.number="categoryId" class="w-full px-3 py-2 md:px-4 md:py-2 text-sm md:text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg">
                                <option value="0">Todas las categorías</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id_category }}">
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                                @endforeach
                            </select>
                            
                            <select x-model="sort" class="w-full px-3 py-2 md:px-4 md:py-2 text-sm md:text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg">
                                <option value="name">Nombre A-Z</option>
                                <option value="price_asc">Menor precio</option>
                                <option value="price_desc">Mayor precio</option>
                                <option value="latest">Más recientes</option>
                            </select>
                            
                            <button @click="search = ''; categoryId = 0; sort = 'name'; page = 1;" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold text-sm md:text-base py-2 px-3 md:px-4 rounded-lg">
                                Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="flex-1">
                    <!-- Horizontal Category Bar -->
                    <!-- Results count -->
                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        <span x-text="filtered().length"></span> producto(s) encontrado(s)
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 md:gap-3">
                        <template x-for="product in paginated()" :key="product.id">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col">
                                <div class="aspect-square relative w-full overflow-hidden flex-shrink-0 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800"
                                     :class="product.image && 'cursor-pointer'"
                                     @click="product.image ? (viewerImage = product.image, viewerName = product.name) : null">
                                    <template x-if="product.image">
                                        <img :src="product.image" :alt="product.name" 
                                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </template>
                                    <template x-if="!product.image">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <i class="fas fa-image text-3xl md:text-4xl text-gray-300 dark:text-gray-600"></i>
                                        </div>
                                    </template>
                                    <template x-if="product.image">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <i class="fas fa-search-plus text-white text-xl drop-shadow-lg"></i>
                                        </div>
                                    </template>
                                </div>
                                <div class="p-2 md:p-3 flex flex-col flex-1">
                                    <div class="hidden md:flex items-center justify-between mb-1 gap-1">
                                        <span class="inline-block px-2 py-0.5 bg-cyan-100 dark:bg-cyan-900 text-cyan-600 dark:text-cyan-300 text-xs font-semibold rounded-full truncate max-w-[60%]"
                                              x-text="product.category"></span>
                                        <template x-if="product.brand">
                                            <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[38%]" x-text="product.brand"></span>
                                        </template>
                                    </div>
                                    <h3 class="font-bold text-xs md:text-sm text-gray-900 dark:text-white mb-0.5 md:mb-1 line-clamp-2" x-text="product.name"></h3>
                                    <p class="hidden md:block text-gray-600 dark:text-gray-400 text-xs mb-1 line-clamp-2" x-text="product.description"></p>
                                    <div class="mt-auto pt-1.5 md:pt-2 border-t border-gray-200 dark:border-gray-700">
                                        <span class="text-sm md:text-lg font-bold text-cyan-600 dark:text-cyan-400" x-text="'$' + product.price.toFixed(2) + ' MXN'"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- No results -->
                    <div x-show="filtered().length === 0" x-cloak class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-12 text-center">
                        <i class="fas fa-search text-6xl text-gray-400 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No se encontraron productos</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Intenta con otros filtros de búsqueda</p>
                        <button @click="search = ''; categoryId = 0; sort = 'name'; page = 1;" class="inline-block bg-gradient-to-r from-cyan-600 to-blue-700 text-white font-bold py-3 px-8 rounded-lg hover:shadow-xl transition cursor-pointer">
                            Ver todos los productos
                        </button>
                    </div>

                    <!-- Pagination -->
                    <div x-show="totalPages() > 1" class="mt-12 flex flex-wrap justify-center items-center gap-1.5">
                        <!-- Prev -->
                        <button @click="page = Math.max(1, page - 1)" :disabled="page === 1"
                                class="px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition text-sm">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <template x-for="item in pageItems()" :key="item.key">
                            <template x-if="item.type === 'page'">
                                <button @click="page = item.value; $nextTick(() => window.scrollTo({top: 0, behavior: 'smooth'}))"
                                        :class="page === item.value
                                            ? 'bg-cyan-600 text-white border-cyan-600'
                                            : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                        class="w-9 h-9 rounded-lg font-semibold transition border text-sm"
                                        x-text="item.value"></button>
                            </template>
                            <template x-if="item.type === 'ellipsis'">
                                <span class="w-9 h-9 flex items-center justify-center text-gray-400 dark:text-gray-500 text-sm select-none">…</span>
                            </template>
                        </template>

                        <!-- Next -->
                        <button @click="page = Math.min(totalPages(), page + 1); $nextTick(() => window.scrollTo({top: 0, behavior: 'smooth'}))" :disabled="page === totalPages()"
                                class="px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition text-sm">
                            <i class="fas fa-chevron-right"></i>
                        </button>

                        <!-- Page summary -->
                        <span class="w-full text-center text-xs text-gray-400 dark:text-gray-500 mt-1">
                            Página <span x-text="page"></span> de <span x-text="totalPages()"></span>
                            &nbsp;(<span x-text="filtered().length"></span> productos)
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Viewer Modal -->
    <div x-show="viewerImage" x-cloak
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="viewerImage = ''" @keydown.escape.window="viewerImage = ''"
         class="fixed inset-0 z-[70] flex items-center justify-center bg-black/80 p-4 cursor-pointer">
        <button @click="viewerImage = ''" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 transition cursor-pointer">
            <i class="fas fa-times"></i>
        </button>
        <img :src="viewerImage" :alt="viewerName" @click.stop
             class="max-w-full max-h-[85vh] rounded-xl shadow-2xl object-contain cursor-default">
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
                        <li><a href="javascript:void(0)" onclick="goToContact()" class="text-gray-400 hover:text-cyan-400 transition cursor-pointer">Contacto</a></li>
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

<script>
function productCatalog() {
    var storageBase = '{{ asset("storage") }}/';
    var allProducts = [
        @foreach($products as $product)
        {
            id: {{ $product->id_product }},
            name: @js($product->name),
            description: @js(Str::limit($product->description, 100) ?? ''),
            image: @js($product->main_image_url ? asset('storage/' . $product->main_image_url) : ''),
            category: @js($product->category?->name ?? 'Sin categoría'),
            category_id: {{ $product->category_id ?? 0 }},
            brand: @js($product->brand ? $product->brand->name : ''),
            price: {{ $product->price ?? 0 }},
            weight: @js($product->weight ?? ''),
            created_at: @js($product->created_at->toISOString())
        },
        @endforeach
    ];

    return {
        mobileMenu: false,
        scrolled: false,
        showFilters: false,
        darkMode: localStorage.getItem('darkMode') === 'true',
        lang: document.cookie.match(/googtrans=\/es\/en/) ? 'en' : 'es',
        search: '',
        categoryId: 0,
        sort: 'name',
        page: 1,
        perPage: 24,
        viewerImage: '',
        viewerName: '',
        products: allProducts,

        filtered() {
            var self = this;
            var result = this.products.filter(function(p) {
                if (self.categoryId !== 0 && p.category_id !== self.categoryId) return false;
                if (self.search.trim() !== '') {
                    var s = self.search.toLowerCase();
                    if (p.name.toLowerCase().indexOf(s) === -1 && (p.description || '').toLowerCase().indexOf(s) === -1) return false;
                }
                return true;
            });

            result.sort(function(a, b) {
                switch (self.sort) {
                    case 'price_asc': return a.price - b.price;
                    case 'price_desc': return b.price - a.price;
                    case 'latest': return new Date(b.created_at) - new Date(a.created_at);
                    default: return a.name.localeCompare(b.name);
                }
            });

            return result;
        },

        totalPages() {
            return Math.max(1, Math.ceil(this.filtered().length / this.perPage));
        },

        // Returns an array of {type:'page'|'ellipsis', value, key} for the smart paginator
        pageItems() {
            var total = this.totalPages();
            var cur = this.page;
            var delta = 2; // pages on each side of current
            var items = [];
            var pages = new Set();

            // Always include first and last
            pages.add(1);
            pages.add(total);
            // Window around current page
            for (var i = Math.max(2, cur - delta); i <= Math.min(total - 1, cur + delta); i++) {
                pages.add(i);
            }

            var sorted = Array.from(pages).sort(function(a, b){ return a - b; });
            var prev = 0;
            sorted.forEach(function(p) {
                if (p - prev > 1) {
                    items.push({ type: 'ellipsis', key: 'e' + p, value: null });
                }
                items.push({ type: 'page', key: 'p' + p, value: p });
                prev = p;
            });
            return items;
        },

        paginated() {
            var f = this.filtered();
            var start = (this.page - 1) * this.perPage;
            return f.slice(start, start + this.perPage);
        },

        init() {
            var self = this;
            this.$watch('search', function() { self.page = 1; });
            this.$watch('categoryId', function() { self.page = 1; });
            this.$watch('sort', function() { self.page = 1; });
        },
        translatePage() {
            if (this.lang === 'es') {
                document.cookie = 'googtrans=/es/en; path=/';
                this.lang = 'en';
            } else {
                document.cookie = 'googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC';
                document.cookie = 'googtrans=; path=/; domain=.' + location.hostname + '; expires=Thu, 01 Jan 1970 00:00:00 UTC';
                this.lang = 'es';
            }
            location.reload();
        }
    };
}
</script>

<script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'es',
        includedLanguages: 'en',
        autoDisplay: false
    }, 'google_translate_element_desktop');
}
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>
