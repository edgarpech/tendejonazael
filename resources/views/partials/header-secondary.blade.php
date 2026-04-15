{{-- Encabezado para páginas secundarias (blog, about, FAQ, privacy) --}}
<header :class="scrolled ? 'bg-white dark:bg-gray-800 shadow-lg' : 'bg-white/95 dark:bg-gray-800/95'" class="fixed w-full top-0 z-[60] transition-all duration-300">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<nav class="flex justify-between items-center h-16">
			<a href="/" class="flex items-center">
				<img x-show="!darkMode" src="{{ asset('images/logos/logo_text_dark.webp') }}" alt="Tendejón Azael" class="h-10 md:h-12 w-auto" width="99" height="48">
				<img x-show="darkMode" x-cloak src="{{ asset('images/logos/logo_text.webp') }}" alt="Tendejón Azael" class="h-10 md:h-12 w-auto" width="99" height="48">
			</a>
			<!-- Controles desktop -->
			<div class="hidden md:flex items-center gap-3">
				<a href="/" class="text-sm text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium">
					<i class="fas fa-arrow-left mr-1"></i> Volver al inicio
				</a>
				<a href="{{ route('blog') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium">
					Blog
				</a>
				<button @click="darkMode = document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', darkMode)"
						class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer"
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
				<div id="google_translate_element_desktop" class="hidden"></div>
				<button @click="if (lang === 'es') { document.cookie = 'googtrans=/es/en; path=/'; lang = 'en'; } else { document.cookie = 'googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC'; document.cookie = 'googtrans=; path=/; domain=.' + location.hostname + '; expires=Thu, 01 Jan 1970 00:00:00 UTC'; lang = 'es'; } location.reload();"
						class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition cursor-pointer"
						:class="lang === 'en' ? 'bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'">
					<svg class="icon-globe" :class="lang === 'en' && 'active'" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="10"/>
						<path d="M2 12h20"/>
						<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
					</svg>
					<span x-text="lang === 'en' ? 'EN' : 'ES'"></span>
				</button>
			</div>
			<!-- Controles móvil -->
			<div class="flex md:hidden items-center gap-1">
				<a href="/" class="w-9 h-9 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition" aria-label="Volver al inicio">
					<i class="fas fa-arrow-left"></i>
				</a>
				<button @click="if (lang === 'es') { document.cookie = 'googtrans=/es/en; path=/'; lang = 'en'; } else { document.cookie = 'googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC'; document.cookie = 'googtrans=; path=/; domain=.' + location.hostname + '; expires=Thu, 01 Jan 1970 00:00:00 UTC'; lang = 'es'; } location.reload();"
						class="w-9 h-9 flex items-center justify-center transition cursor-pointer"
						:class="lang === 'en' ? 'text-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400'"
						aria-label="Traducir página">
					<svg class="icon-globe" :class="lang === 'en' && 'active'" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="10"/>
						<path d="M2 12h20"/>
						<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
					</svg>
				</button>
				<button @click="darkMode = document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', darkMode)"
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
			</div>
		</nav>
	</div>
</header>
