<footer class="bg-gray-900 text-white py-6 md:py-12 mt-6 md:mt-12">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 mb-4 md:mb-8">
			<div>
				<h3 class="text-lg md:text-2xl font-bold mb-2 md:mb-4 bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Tendejón Azael</h3>
				<p class="text-sm md:text-base text-gray-400">Tu tienda de abarrotes de confianza desde 2005.</p>
			</div>
			<div>
				<h3 class="text-base md:text-xl font-bold mb-2 md:mb-4">Enlaces Rápidos</h3>
				<ul class="space-y-1 md:space-y-2 text-sm md:text-base">
					@if(request()->routeIs('home'))
						<li><a href="#hero" class="text-gray-400 hover:text-cyan-400 transition">Inicio</a></li>
						<li><a href="#catalogo" class="text-gray-400 hover:text-cyan-400 transition">Productos</a></li>
						<li><a href="#contacto" class="text-gray-400 hover:text-cyan-400 transition">Contacto</a></li>
					@else
						<li><a href="/" class="text-gray-400 hover:text-cyan-400 transition">Inicio</a></li>
						<li><a href="{{ route('products') }}" class="text-gray-400 hover:text-cyan-400 transition">Productos</a></li>
						<li><a href="/#contacto" class="text-gray-400 hover:text-cyan-400 transition">Contacto</a></li>
					@endif
					<li><a href="{{ route('blog') }}" class="text-gray-400 hover:text-cyan-400 transition">Blog</a></li>
					<li><a href="{{ route('about') }}" class="text-gray-400 hover:text-cyan-400 transition">Sobre Nosotros</a></li>
					<li><a href="{{ route('faq') }}" class="text-gray-400 hover:text-cyan-400 transition">Preguntas Frecuentes</a></li>
					<li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-cyan-400 transition">Aviso de Privacidad</a></li>
				</ul>
			</div>
			<div>
				<h3 class="text-base md:text-xl font-bold mb-2 md:mb-4">Síguenos</h3>
				<div class="flex gap-3 md:gap-4 text-xl md:text-2xl">
					<a href="https://www.facebook.com/TendejonAzael" class="text-gray-400 hover:text-cyan-400 transition" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
					<a href="https://www.instagram.com/tendejonazael" class="text-gray-400 hover:text-cyan-400 transition" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
					<a href="https://wa.me/+5219911161668" target="_blank" class="text-gray-400 hover:text-cyan-400 transition" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
				</div>
			</div>
		</div>
		<div class="border-t border-gray-800 pt-4 md:pt-8 text-center text-xs md:text-base text-gray-400">
			<p>&copy; 2005-{{ date('Y') }} Tendejón Azael. Todos los derechos reservados.</p>
		</div>
	</div>
</footer>
