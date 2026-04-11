<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
	<!-- Google Analytics + Tag Manager -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-6130FGQMRE"></script>
	<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-6130FGQMRE');</script>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TF6JZMCQ');</script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Productos - Tendejón Azael | Chabihau, Yucatán</title>
	<meta name="description" content="Explora nuestro catálogo completo de productos en Tendejón Azael, Chabihau, Yucatán. Abarrotes, bebidas, snacks, hielo y todo lo que necesitas para tus vacaciones en el puerto.">
	<meta name="keywords" content="productos abarrotes Chabihau, catálogo tienda Yucatán, bebidas playa Yucatán, snacks vacaciones Chabihau, compras Chabihau, precios abarrotes Yucatán, tienda cerca playa Chabihau, refrescos Chabihau, hielo playa Yucatán, agua purificada Yucatán, despensa vacaciones Yucatán, dulces snacks Chabihau, lácteos Yucatán, limpieza hogar playa, todo para vacaciones Chabihau">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="{{ url('/productos') }}">

	<!-- Meta para redes sociales (Open Graph) -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ url('/productos') }}">
	<meta property="og:title" content="Productos - Tendejón Azael | Chabihau, Yucatán">
	<meta property="og:description" content="Explora nuestro catálogo completo de abarrotes, bebidas, snacks y más en Tendejón Azael, Chabihau.">
	<meta property="og:image" content="{{ asset('images/logos/logo_general.jpg') }}">
	<meta property="og:locale" content="es_MX">

	<!-- Meta Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="Productos - Tendejón Azael | Chabihau, Yucatán">
	<meta name="twitter:description" content="Catálogo completo de productos. Abarrotes, bebidas, snacks y más en Chabihau.">
	<meta name="twitter:image" content="{{ asset('images/logos/logo_general.jpg') }}">

	<link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
	<link rel="preload" href="{{ asset('vendor/font-awesome/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
	<link rel="preconnect" href="https://translate.googleapis.com" crossorigin>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}" />
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4900355905448266" crossorigin="anonymous"></script>
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
		.scrollbar-hide::-webkit-scrollbar { display: none; }
		.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
	</style>
</head>
<body x-data="productCatalog()" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
	<!-- GTM (noscript) - respaldo para usuarios sin JavaScript -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF6JZMCQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
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

	<!-- Encabezado y navegación principal -->
	<header :class="scrolled ? 'bg-white dark:bg-gray-800 shadow-lg' : 'bg-white/95 dark:bg-gray-800/95'" class="fixed w-full top-0 z-[60] transition-all duration-300">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<nav class="flex justify-between items-center h-16">
				<a href="/" class="flex items-center">
					<img x-show="!darkMode" src="{{ asset('images/logos/logo_text_dark.webp') }}" alt="Tendejón Azael" class="h-10 md:h-12 w-auto" width="99" height="48">
					<img x-show="darkMode" x-cloak src="{{ asset('images/logos/logo_text.webp') }}" alt="Tendejón Azael" class="h-10 md:h-12 w-auto" width="99" height="48">
				</a>

				<!-- Menú escritorio -->
				<ul class="hidden lg:flex items-center gap-8">
					<li><a href="/" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium">Inicio</a></li>
					<li><a href="{{ route('products') }}" class="text-cyan-700 dark:text-cyan-400 font-semibold">Productos</a></li>
					<li><a href="/#contacto" onclick="goToContact(); return false;" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium cursor-pointer">Contacto</a></li>
					
					<!-- Modo oscuro -->
					<li>
						<button @click="darkMode = toggleDarkMode()" 
								class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
								aria-label="Cambiar modo oscuro">
							<svg x-show="!darkMode" class="icon-theme" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
							</svg>
							<svg x-show="darkMode" x-cloak class="icon-theme" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<circle cx="12" cy="12" r="5"/>
								<line x1="12" y1="1" x2="12" y2="3"/>
								<line x1="12" y1="21" x2="12" y2="23"/>
								<line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
								<line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
								<line x1="1" y1="12" x2="3" y2="12"/>
								<line x1="21" y1="12" x2="23" y2="12"/>
								<line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
								<line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
							</svg>
						</button>
					</li>

					<!-- Traducción ES/EN -->
					<li>
						<div id="google_translate_element_desktop" class="hidden"></div>
						<button @click="translatePage()" 
								class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition cursor-pointer"
								:class="lang === 'en' ? 'bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'">
							<svg class="icon-globe" :class="lang === 'en' && 'active'" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<circle cx="12" cy="12" r="10"/>
								<path d="M2 12h20"/>
								<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
							</svg>
							<span x-text="lang === 'en' ? 'EN' : 'ES'"></span>
						</button>
					</li>
				</ul>

				<!-- Controles móvil -->
				<div class="flex lg:hidden items-center gap-1">
					<button @click="translatePage()" 
							class="w-9 h-9 flex items-center justify-center transition cursor-pointer"
							:class="lang === 'en' ? 'text-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400'"
							aria-label="Traducir página">
						<svg class="icon-globe" :class="lang === 'en' && 'active'" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="10"/>
							<path d="M2 12h20"/>
							<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
						</svg>
					</button>
					<button @click="darkMode = toggleDarkMode()" 
							class="w-9 h-9 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition cursor-pointer"
							aria-label="Cambiar modo oscuro">
						<svg x-show="!darkMode" class="icon-theme" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
						</svg>
						<svg x-show="darkMode" x-cloak class="icon-theme" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="5"/>
							<line x1="12" y1="1" x2="12" y2="3"/>
							<line x1="12" y1="21" x2="12" y2="23"/>
							<line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
							<line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
							<line x1="1" y1="12" x2="3" y2="12"/>
							<line x1="21" y1="12" x2="23" y2="12"/>
							<line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
							<line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
						</svg>
					</button>
					<button @click="mobileMenu = !mobileMenu" 
							class="w-9 h-9 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors duration-300"
							aria-label="Abrir menú de navegación">
						<div class="hamburger" :class="mobileMenu && 'open'">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</button>
				</div>
			</nav>
		</div>
	</header>

	<!-- Fondo oscuro al abrir menú móvil -->
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

	<!-- Menú móvil (panel lateral derecho) -->
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
						<a @click="mobileMenu = false" href="/" 
						   class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-colors font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 group">
							<i class="fas fa-home w-5 text-gray-400 group-hover:text-cyan-500"></i>
							<span>Inicio</span>
						</a>
					</li>
					<li>
						<a @click="mobileMenu = false" href="{{ route('products') }}" 
						   class="flex items-center gap-3 py-3 px-4 bg-cyan-50 dark:bg-gray-700 rounded-lg font-semibold text-cyan-700 dark:text-cyan-400 group">
							<i class="fas fa-shopping-bag w-5 text-cyan-500"></i>
							<span>Productos</span>
						</a>
					</li>
					<li>
						<a @click="mobileMenu = false" href="/#contacto" onclick="goToContact(); return false;" 
						   class="flex items-center gap-3 py-3 px-4 hover:bg-cyan-50 dark:hover:bg-gray-700 rounded-lg transition-colors font-medium text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 group">
							<i class="fas fa-phone w-5 text-gray-400 group-hover:text-cyan-500"></i>
							<span>Contacto</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>

	<!-- Botón volver arriba -->
	<button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
			x-show="scrolled"
			x-cloak
			x-transition
			class="fixed bottom-6 right-6 w-10 h-10 md:w-14 md:h-14 bg-gradient-to-r from-cyan-600 to-blue-700 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-[transform,box-shadow] duration-300 z-40"
			aria-label="Volver arriba">
		<i class="fas fa-arrow-up text-sm md:text-base"></i>
	</button>

	<!-- Contenido principal -->
	<main class="pt-20 md:pt-24 pb-8 md:pb-12">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Título de la página -->
			<div class="mb-2 md:mb-8">
				<h1 class="text-lg md:text-4xl font-bold text-gray-900 dark:text-white mb-0 md:mb-2">Catálogo de Productos</h1>
				<p class="text-xs md:text-base text-gray-600 dark:text-gray-400">Explora todo nuestro catálogo de productos</p>
			</div>

			<div class="flex flex-col lg:flex-row gap-8">
				<!-- Barra lateral de filtros (escritorio) -->
				<aside class="hidden lg:block w-64 flex-shrink-0">
					<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-24">
						<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
							<i class="fas fa-filter text-cyan-700 dark:text-cyan-400"></i> Filtros
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

						<!-- Ordenar -->
						<div class="mb-6">
							<label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
								<i class="fas fa-sort mr-1"></i> Ordenar por
							</label>
							<select x-model="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
								<option value="name">Nombre A-Z</option>
								<option value="price_asc">Menor precio</option>
								<option value="price_desc">Mayor precio</option>

							</select>
						</div>

						<button @click="search = ''; categoryId = 0; sort = 'name'; page = 1;" class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-lg transition">
							<i class="fas fa-times mr-2"></i> Limpiar Filtros
						</button>
					</div>

				</aside>

				<!-- Filtros móvil (siempre visibles, compactos) -->
				<div class="lg:hidden space-y-1 mb-1">
					<!-- Búsqueda + Ordenar -->
					<div style="display:flex;gap:4px;align-items:center">
						<div style="position:relative;flex:1">
							<i class="fas fa-search text-gray-400" style="position:absolute;left:6px;top:50%;transform:translateY(-50%);font-size:9px;pointer-events:none"></i>
							<input type="text" x-model="search" placeholder="Buscar producto..."
								   class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-1 focus:ring-cyan-500 focus:border-cyan-500"
								   style="height:26px;padding:0 8px 0 20px;font-size:10px;border-radius:4px;box-sizing:border-box">
						</div>
						<select x-model="sort" class="border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-1 focus:ring-cyan-500"
								style="height:26px;font-size:10px;padding:0 18px 0 6px;border-radius:4px;box-sizing:border-box">
							<option value="name">A-Z</option>
							<option value="price_asc">Menor $</option>
							<option value="price_desc">Mayor $</option>
						</select>
					</div>
					<!-- Categorías scroll horizontal -->
					<div class="flex gap-1 overflow-x-auto scrollbar-hide -mx-4 px-4 py-0.5">
						<button x-show="search !== '' || categoryId !== 0 || sort !== 'name'"
								@click="search = ''; categoryId = 0; sort = 'name'; page = 1;"
								class="flex-shrink-0 px-1.5 py-px rounded-full border border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 cursor-pointer whitespace-nowrap" style="font-size:9px">
							× Limpiar
						</button>
						<button @click="categoryId = 0; page = 1;"
								:class="categoryId === 0 ? 'bg-cyan-600 text-white border-cyan-600' : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400'"
								class="flex-shrink-0 px-1.5 py-px rounded-full border transition cursor-pointer whitespace-nowrap" style="font-size:9px">
							Todas
						</button>
						@foreach($categories as $category)
						<button @click="categoryId = {{ $category->id_category }}; page = 1;"
								:class="categoryId === {{ $category->id_category }} ? 'bg-cyan-600 text-white border-cyan-600' : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400'"
								class="flex-shrink-0 px-1.5 py-px rounded-full border transition cursor-pointer whitespace-nowrap" style="font-size:9px">
							{{ $category->name }} <span class="opacity-50">{{ $category->products_count }}</span>
						</button>
						@endforeach
					</div>
				</div>

				<!-- Grid de productos -->
				<div class="flex-1">
					<!-- Contador de resultados -->
					<div class="mb-1 lg:mb-4 text-[9px] lg:text-sm text-gray-500 dark:text-gray-400">
						<span x-text="filtered().length"></span> producto(s) encontrado(s)
					</div>

					<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-1.5 md:gap-3">
						<template x-for="product in paginated()" :key="product.id">
							<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden group flex flex-col">
								<div class="aspect-[4/3] md:aspect-square relative w-full overflow-hidden flex-shrink-0 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800"
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
								<div class="p-1.5 md:p-3 flex flex-col flex-1">
									<div class="hidden md:flex items-center justify-between mb-1 gap-1">
										<span class="inline-block px-2 py-0.5 bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300 text-xs font-semibold rounded-full truncate max-w-[60%]"
											  x-text="product.category"></span>
										<template x-if="product.brand">
											<span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[38%]" x-text="product.brand"></span>
										</template>
									</div>
									<h3 class="font-semibold text-[11px] md:text-sm text-gray-900 dark:text-white mb-0.5 md:mb-1 line-clamp-2 leading-tight" x-text="product.name"></h3>
									<p class="hidden md:block text-gray-600 dark:text-gray-400 text-xs mb-1 line-clamp-2" x-text="product.description"></p>
									<div class="mt-auto pt-1 md:pt-2 border-t border-gray-200 dark:border-gray-700">
										<span class="text-xs md:text-lg font-bold text-cyan-700 dark:text-cyan-400" x-text="'$' + parseFloat(product.price || 0).toFixed(2) + ' MXN'"></span>
									</div>
								</div>
							</div>
						</template>
					</div>

					<!-- Sin resultados -->
					<div x-show="filtered().length === 0" x-cloak class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-12 text-center">
						<i class="fas fa-search text-6xl text-gray-400 dark:text-gray-600 mb-4"></i>
						<h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No se encontraron productos</h3>
						<p class="text-gray-600 dark:text-gray-400 mb-6">Intenta con otros filtros de búsqueda</p>
						<button @click="search = ''; categoryId = 0; sort = 'name'; page = 1;" class="inline-block bg-gradient-to-r from-cyan-600 to-blue-700 text-white font-bold py-3 px-8 rounded-lg hover:shadow-xl transition cursor-pointer">
							Ver todos los productos
						</button>
					</div>

					<!-- Paginación -->
					<div x-show="totalPages() > 1" class="mt-12 flex flex-wrap justify-center items-center gap-1.5">
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

						<button @click="page = Math.min(totalPages(), page + 1); $nextTick(() => window.scrollTo({top: 0, behavior: 'smooth'}))" :disabled="page === totalPages()"
								class="px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition text-sm">
							<i class="fas fa-chevron-right"></i>
						</button>

						<span class="w-full text-center text-xs text-gray-400 dark:text-gray-500 mt-1">
							Página <span x-text="page"></span> de <span x-text="totalPages()"></span>
							&nbsp;(<span x-text="filtered().length"></span> productos)
						</span>
					</div>
				</div>
			</div>
		</div>

	<!-- Modal para ver imagen del producto en grande -->
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
	</main>

	<!-- Anuncio AdSense horizontal -->
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-6 md:my-10">
		<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-4900355905448266"
			 data-ad-slot="6167489182"
			 data-ad-format="horizontal"
			 data-full-width-responsive="true"></ins>
	</div>

	<!-- Pie de página -->
	@include('partials.footer')

	<script>
	var __productsData = @json($productsJson);
	function productCatalog() {
		var allProducts = __productsData;

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

			// Genera los items del paginador con elipsis inteligentes
			pageItems() {
				var total = this.totalPages();
				var cur = this.page;
				var delta = 2; // páginas a cada lado de la actual
				var items = [];
				var pages = new Set();

				// Siempre incluir primera y última
				pages.add(1);
				pages.add(total);
				// Ventana alrededor de la página actual
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
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var s = document.createElement('script');
		s.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
		s.async = true;
		document.body.appendChild(s);
	});
	</script>

	<!-- Banner de consentimiento de cookies -->
	<div x-data="{ show: !localStorage.getItem('cookieConsent') }" x-show="show" x-cloak
		 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
		 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-full opacity-0"
		 class="fixed bottom-0 left-0 right-0 z-[100] bg-white dark:bg-gray-800 shadow-[0_-4px_20px_rgba(0,0,0,0.15)] border-t border-gray-200 dark:border-gray-700 p-4 md:p-6">
		<div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
			<div class="flex-1">
				<p class="text-sm text-gray-700 dark:text-gray-300">
					<i class="fas fa-cookie-bite text-cyan-600 dark:text-cyan-400 mr-1"></i>
					Usamos cookies para mejorar tu experiencia y mostrar anuncios relevantes. Al continuar navegando, aceptas nuestro
					<a href="{{ route('privacy') }}" class="text-cyan-600 dark:text-cyan-400 hover:underline font-medium">Aviso de Privacidad</a>.
				</p>
			</div>
			<div class="flex gap-3 flex-shrink-0">
				<button @click="localStorage.setItem('cookieConsent', 'rejected'); show = false"
						class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition cursor-pointer">
					Rechazar
				</button>
				<button @click="localStorage.setItem('cookieConsent', 'accepted'); show = false"
						class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-cyan-600 to-blue-700 rounded-lg hover:shadow-lg transition cursor-pointer">
					Aceptar
				</button>
			</div>
		</div>
	</div>

	<script>
	document.querySelectorAll('.adsbygoogle').forEach(function() {
		try { (adsbygoogle = window.adsbygoogle || []).push({}); } catch(e) {}
	});
	</script>

	<!-- Datos estructurados para SEO (JSON-LD) -->
	<script type="application/ld+json">
	{
		"@@context": "https://schema.org",
		"@@type": "BreadcrumbList",
		"itemListElement": [
			{
				"@@type": "ListItem",
				"position": 1,
				"name": "Inicio",
				"item": "{{ url('/') }}"
			},
			{
				"@@type": "ListItem",
				"position": 2,
				"name": "Catálogo de Productos",
				"item": "{{ url('/productos') }}"
			}
		]
	}
	</script>
	<script type="application/ld+json">
	{
		"@@context": "https://schema.org",
		"@@type": "CollectionPage",
		"@@id": "{{ url('/productos') }}",
		"url": "{{ url('/productos') }}",
		"name": "Catálogo de Productos - Tendejón Azael",
		"description": "Catálogo completo de abarrotes, bebidas, snacks, hielo y más en Tendejón Azael, Chabihau, Yucatán.",
		"inLanguage": "es-MX",
		"isPartOf": {
			"@@id": "{{ url('/') }}/#website"
		},
		"breadcrumb": {
			"@@type": "BreadcrumbList",
			"itemListElement": [
				{ "@@type": "ListItem", "position": 1, "name": "Inicio", "item": "{{ url('/') }}" },
				{ "@@type": "ListItem", "position": 2, "name": "Productos", "item": "{{ url('/productos') }}" }
			]
		}
	}
	</script>

</body>
</html>
