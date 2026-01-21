<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tendejón Azael - Tu tienda de confianza</title>
    <meta name="description" content="Tendejón Azael, tu tienda de abarrotes con los mejores precios y atención personalizada desde 2007.">
    <link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body x-data="{ mobileMenu: false, scrolled: false, catActiva: 0, search: '', darkMode: localStorage.getItem('darkMode') === 'true' }" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
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
    
    function scrollToSection(sectionId) {
        const element = document.getElementById(sectionId);
        if (element) {
            const headerOffset = 64;
            const elementPosition = element.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
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
                    <li><a href="javascript:void(0)" @click="scrollToSection('hero')" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium cursor-pointer">Inicio</a></li>
                    <li><a href="javascript:void(0)" @click="scrollToSection('sobre-nosotros')" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium cursor-pointer">Sobre Nosotros</a></li>
                    <li><a href="javascript:void(0)" @click="scrollToSection('catalogo')" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium cursor-pointer">Nuestros Productos</a></li>
                    <li><a href="javascript:void(0)" @click="scrollToSection('marcas')" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium cursor-pointer">Marcas</a></li>
                    <li><a href="javascript:void(0)" @click="scrollToSection('contacto')" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium cursor-pointer">Contacto</a></li>
                    
                    <!-- Dark Mode Toggle -->
                    <li>
                        <button @click="darkMode = toggleDarkMode()" 
                                class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer">
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
         x-cloak
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
                        <a href="javascript:void(0)" @click="mobileMenu = false; scrollToSection('hero')" 
                           class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-all font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 cursor-pointer group">
                            <i class="fas fa-home w-5 text-gray-400 group-hover:text-cyan-500"></i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" @click="mobileMenu = false; scrollToSection('sobre-nosotros')" 
                           class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-all font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 cursor-pointer group">
                            <i class="fas fa-info-circle w-5 text-gray-400 group-hover:text-cyan-500"></i>
                            <span>Sobre Nosotros</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" @click="mobileMenu = false; scrollToSection('catalogo')" 
                           class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-all font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 cursor-pointer group">
                            <i class="fas fa-shopping-bag w-5 text-gray-400 group-hover:text-cyan-500"></i>
                            <span>Nuestros Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" @click="mobileMenu = false; scrollToSection('marcas')" 
                           class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-all font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 cursor-pointer group">
                            <i class="fas fa-star w-5 text-gray-400 group-hover:text-cyan-500"></i>
                            <span>Marcas</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" @click="mobileMenu = false; scrollToSection('contacto')" 
                           class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-all font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 cursor-pointer group">
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
            class="fixed bottom-6 right-6 w-10 h-10 md:w-14 md:h-14 bg-gradient-to-r from-cyan-600 to-blue-700 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-all duration-300 z-40">
        <i class="fas fa-arrow-up text-sm md:text-base"></i>
    </button>

    <!-- Hero Section -->
    <section id="hero" class="pt-16 bg-gradient-to-br from-cyan-600 via-blue-700 to-blue-800 text-white min-h-[400px] md:min-h-[600px] flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 text-center">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6">
                Calidad y confianza en cada compra
            </h1>
            <p class="text-base md:text-xl lg:text-2xl mb-6 md:mb-8 text-white/90">
                Tu tendejón familiar desde 2007. Los mejores productos al alcance de tu mano.
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 md:p-4 text-center hover:bg-white/20 transition">
                    <i class="fas fa-calendar-check text-2xl md:text-3xl mb-2"></i>
                    <p class="text-xs md:text-sm font-semibold">Desde 2007</p>
                    <p class="text-xs text-white/80 hidden md:block">18 años de experiencia</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 md:p-4 text-center hover:bg-white/20 transition">
                    <i class="fas fa-box-open text-2xl md:text-3xl mb-2"></i>
                    <p class="text-xs md:text-sm font-semibold">+1000 Productos</p>
                    <p class="text-xs text-white/80 hidden md:block">Gran variedad</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 md:p-4 text-center hover:bg-white/20 transition">
                    <i class="fas fa-tags text-2xl md:text-3xl mb-2"></i>
                    <p class="text-xs md:text-sm font-semibold">Mejores Precios</p>
                    <p class="text-xs text-white/80 hidden md:block">Siempre competitivos</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 md:p-4 text-center hover:bg-white/20 transition">
                    <i class="fas fa-heart text-2xl md:text-3xl mb-2"></i>
                    <p class="text-xs md:text-sm font-semibold">Atención Familiar</p>
                    <p class="text-xs text-white/80 hidden md:block">Servicio personalizado</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sobre Nosotros -->
    <section id="sobre-nosotros" class="py-10 md:py-20 bg-white dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12 text-gray-900 dark:text-white">Sobre Nosotros</h2>
            <div class="grid md:grid-cols-2 gap-4 md:gap-8">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-lg p-4 md:p-8 hover:shadow-xl transition">
                    <h3 class="text-lg md:text-2xl font-bold text-cyan-600 dark:text-cyan-400 mb-2 md:mb-4">Nuestra Historia</h3>
                    <p class="text-sm md:text-base text-gray-700 dark:text-gray-300 mb-2 md:mb-4">
                        En el corazón de Chabihau, <strong>Tendejón Azael</strong> nació como un emprendimiento familiar con un propósito claro: ofrecer a nuestra comunidad una tienda donde la calidad, la variedad y el trato amable fueran lo primordial.
                    </p>
                    <p class="text-sm md:text-base text-gray-700 dark:text-gray-300">
                        Desde 2007, nos hemos esforzado en transformar cada visita de nuestros clientes en una experiencia satisfactoria, adaptándonos constantemente a sus necesidades.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl md:rounded-2xl shadow-lg p-4 md:p-8 text-white hover:shadow-xl transition">
                    <h3 class="text-lg md:text-2xl font-bold mb-3 md:mb-4">¿Por qué elegirnos?</h3>
                    <ul class="space-y-2 md:space-y-3 text-sm md:text-base">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-sm md:text-base"></i> Productos frescos y seleccionados
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-sm md:text-base"></i> Precios justos y competitivos
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-sm md:text-base"></i> Atención personalizada
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-sm md:text-base"></i> Amplio catálogo de marcas
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Catálogo de Productos -->
    <section id="catalogo" class="py-10 md:py-20 bg-gray-100 dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12 text-gray-900 dark:text-white">Nuestros Productos</h2>

            <!-- Buscador y Filtros -->
            <div class="bg-white dark:bg-gray-900 rounded-xl md:rounded-2xl shadow-lg p-3 md:p-6 mb-4 md:mb-8">
                <div class="flex flex-col gap-3 md:gap-4">
                    <input type="text" x-model="search" placeholder="Buscar productos..." 
                           class="w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">

                    <div class="flex gap-1.5 md:gap-2 flex-wrap justify-center">
                        <button @click="catActiva = 0; search = ''" 
                                :class="catActiva === 0 ? 'bg-cyan-500 text-white shadow-lg scale-105' : 'bg-white dark:bg-gray-800 text-cyan-600 dark:text-cyan-400 border border-cyan-500 dark:border-cyan-400'"
                                class="px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm rounded-lg font-medium transition-all hover:shadow-lg hover:scale-105 cursor-pointer">
                            Todos
                        </button>
                        @foreach($categories as $category)
                        <button @click="catActiva = {{ $category->id }}; search = ''" 
                                :class="catActiva === {{ $category->id }} ? 'bg-cyan-500 text-white shadow-lg scale-105' : 'bg-white dark:bg-gray-800 text-cyan-600 dark:text-cyan-400 border border-cyan-500 dark:border-cyan-400'"
                                class="px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm rounded-lg font-medium transition-all hover:shadow-lg hover:scale-105 cursor-pointer">
                            {{ $category->name }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Grid de Productos -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
                @foreach($featuredProducts as $product)
                <div x-show="(catActiva === 0 || catActiva === {{ $product->category_id }}) && 
                            ('{{ strtolower($product->name) }}'.includes(search.toLowerCase()) || search === '')"
                     x-transition
                     class="bg-white dark:bg-gray-900 rounded-lg md:rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="h-32 md:h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center overflow-hidden">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                        <i class="fas fa-box-open text-4xl md:text-6xl text-gray-400 dark:text-gray-600"></i>
                        @endif
                    </div>
                    <div class="p-2 md:p-4">
                        <span class="hidden md:inline-block px-2 py-1 bg-cyan-100 dark:bg-cyan-900 text-cyan-600 dark:text-cyan-300 text-xs font-semibold rounded mb-2">
                            {{ $product->category->name }}
                        </span>
                        <h3 class="font-bold text-xs md:text-lg text-gray-900 dark:text-white mb-1 md:mb-2 line-clamp-2">{{ $product->name }}</h3>
                        <p class="hidden md:block text-gray-600 dark:text-gray-400 text-sm mb-2 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                        @if($product->weight)
                        <p class="hidden md:block text-gray-500 dark:text-gray-500 text-xs mb-2">{{ $product->weight }}</p>
                        @endif
                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-1 md:gap-0">
                            <span class="text-base md:text-2xl font-bold text-cyan-600 dark:text-cyan-400">${{ number_format($product->price, 2) }}</span>
                            @if($product->stock > 0)
                            <span class="text-green-600 dark:text-green-400 text-xs md:text-sm"><i class="fas fa-check-circle"></i> <span class="hidden md:inline">Disponible</span></span>
                            @else
                            <span class="text-red-500 dark:text-red-400 text-xs md:text-sm"><i class="fas fa-times-circle"></i> <span class="hidden md:inline">Agotado</span></span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-6 md:mt-12">
                <a href="{{ route('products') }}" class="inline-block bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-bold text-sm md:text-base py-3 px-6 md:py-4 md:px-10 rounded-lg shadow-lg hover:shadow-2xl transition-all hover:scale-105 cursor-pointer">
                    <i class="fas fa-box-open mr-1 md:mr-2"></i> Ver Todos los Productos <i class="fas fa-arrow-right ml-1 md:ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Marcas -->
    <section id="marcas" class="py-10 md:py-20 bg-white dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12 text-gray-900 dark:text-white">Marcas que manejamos</h2>
            <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-6">
                @foreach($brands as $brand)
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg md:rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-3 md:p-6 flex items-center justify-center">
                    @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="max-h-12 md:max-h-20 w-auto object-contain">
                    @else
                    <span class="text-xs md:text-lg font-bold text-gray-700 dark:text-gray-300">{{ $brand->name }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-10 md:py-20 bg-gray-100 dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12 text-gray-900 dark:text-white">Contacto</h2>
            <div class="grid md:grid-cols-2 gap-4 md:gap-8">
                <div class="space-y-3 md:space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-lg md:rounded-xl shadow-lg p-3 md:p-6 flex gap-3 md:gap-4 hover:shadow-xl transition">
                        <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center text-white text-base md:text-xl">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white mb-0.5 md:mb-1">Dirección</h4>
                            <p class="text-xs md:text-base text-gray-600 dark:text-gray-400 leading-relaxed">
                                <span class="block font-semibold text-gray-800 dark:text-gray-200">Calle 21 #88E entre 14 y 16</span>
                                <span class="block">Camino rumbo a Santa Clara</span>
                                <span class="block">Chabihau, Yobaín, Yucatán</span>
                                <span class="block text-cyan-600 dark:text-cyan-400 font-medium">C.P. 97426</span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-lg md:rounded-xl shadow-lg p-3 md:p-6 flex gap-3 md:gap-4 hover:shadow-xl transition">
                        <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center text-white text-base md:text-xl">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white mb-0.5 md:mb-1">Teléfonos</h4>
                            <p class="text-xs md:text-base text-gray-600 dark:text-gray-400">991-116-1668<br>991-107-8633</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-lg md:rounded-xl shadow-lg p-3 md:p-6 flex gap-3 md:gap-4 hover:shadow-xl transition">
                        <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center text-white text-base md:text-xl">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white mb-0.5 md:mb-1">Horario de Atención</h4>
                            <p class="text-xs md:text-base text-gray-600 dark:text-gray-400">Lunes a Domingo<br>7:00 AM - 09:00 PM</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-lg md:rounded-xl shadow-lg overflow-hidden h-[250px] md:h-[400px]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3715.844260194039!2d-89.115341!3d21.3566374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f543dc1aaa96f11%3A0xdc907f06f3d65fb3!2sTendej%C3%B3n%20Azael!5e0!3m2!1ses-419!2smx!4v1768965529551!5m2!1ses-419!2smx"
                            class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 mb-4 md:mb-8">
                <div>
                    <h3 class="text-lg md:text-2xl font-bold mb-2 md:mb-4 bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Tendejón Azael</h3>
                    <p class="text-sm md:text-base text-gray-400">Tu tienda de abarrotes de confianza desde 2007.</p>
                </div>
                <div>
                    <h3 class="text-base md:text-xl font-bold mb-2 md:mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-1 md:space-y-2 text-sm md:text-base">
                        <li><a href="#hero" class="text-gray-400 hover:text-cyan-400 transition">Inicio</a></li>
                        <li><a href="#catalogo" class="text-gray-400 hover:text-cyan-400 transition">Productos</a></li>
                        <li><a href="#contacto" class="text-gray-400 hover:text-cyan-400 transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-base md:text-xl font-bold mb-2 md:mb-4">Síguenos</h3>
                    <div class="flex gap-3 md:gap-4 text-xl md:text-2xl">
                        <a href="https://www.facebook.com/TendejonAzael" class="text-gray-400 hover:text-cyan-400 transition"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com/tendejonazael" class="text-gray-400 hover:text-cyan-400 transition"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.me/9911161668" target="_blank" class="text-gray-400 hover:text-cyan-400 transition"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-4 md:pt-8 text-center text-xs md:text-base text-gray-400">
                <p>&copy; {{ date('Y') }} Tendejón Azael. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>
