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
	<title>Sobre Nosotros | Tendejón Azael</title>
	<meta name="description" content="Conoce la historia de Tendejón Azael, tu tienda de abarrotes de confianza en Chabihau, Yucatán, sirviendo a la comunidad desde 2005.">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="{{ url('/sobre-nosotros') }}">
	<link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ url('/sobre-nosotros') }}">
	<meta property="og:title" content="Sobre Nosotros | Tendejón Azael">
	<meta property="og:site_name" content="Tendejón Azael">
	<meta property="og:description" content="Conoce la historia de Tendejón Azael, tienda de abarrotes en Chabihau desde 2005.">
	<meta property="og:image" content="{{ asset('images/logos/logo_general.jpg') }}">
	<meta property="og:locale" content="es_MX">

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="Sobre Nosotros | Tendejón Azael">
	<meta name="twitter:description" content="Conoce la historia de Tendejón Azael, tienda de abarrotes en Chabihau desde 2005.">
	<meta name="twitter:image" content="{{ asset('images/logos/logo_general.jpg') }}">
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/subset.min.css') }}" />
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
	</style>
	<!-- Datos estructurados LocalBusiness -->
	<script type="application/ld+json">
	{
		"@@context": "https://schema.org",
		"@@type": "LocalBusiness",
		"name": "Tendejón Azael",
		"description": "Tienda de abarrotes en Chabihau, Yucatán. Desde 2005 ofreciendo productos esenciales a la comunidad y visitantes de la costa norte.",
		"foundingDate": "2005",
		"address": {
			"@@type": "PostalAddress",
			"streetAddress": "Calle 21 entre 14 y 16",
			"addressLocality": "Chabihau",
			"addressRegion": "Yucatán",
			"addressCountry": "MX"
		},
		"telephone": "+5219911161668",
		"url": "{{ url('/') }}",
		"image": "{{ asset('images/logos/logo_general.jpg') }}",
		"openingHoursSpecification": [
			{
				"@@type": "OpeningHoursSpecification",
				"dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
				"opens": "07:00",
				"closes": "21:00"
			}
		]
	}
	</script>
</head>
<body x-data="{ darkMode: document.documentElement.classList.contains('dark'), scrolled: false, lang: document.cookie.match(/googtrans=\/es\/en/) ? 'en' : 'es' }" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

	@include('partials.header-secondary')

	<main class="pt-24 pb-12">
		<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

			<!-- Encabezado -->
			<div class="text-center mb-12">
				<h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Sobre Nosotros</h1>
				<p class="text-lg text-gray-600 dark:text-gray-400">Más que una tienda, somos parte de la comunidad de Chabihau</p>
			</div>

			<!-- Historia -->
			<section class="mb-12">
				<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 md:p-10">
					<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
						<i class="fas fa-store text-cyan-600 dark:text-cyan-400"></i> Nuestra Historia
					</h2>
					<div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 space-y-4">
						<p>
							Tendejón Azael nació en <strong>2005</strong> como un pequeño puesto de Coca-Cola en el corazón de Chabihau, un tranquilo puerto pesquero en la costa norte de Yucatán. En <strong>2007</strong> formalizamos el negocio con el alta ante Hacienda. Lo que comenzó como un modesto puesto de refrescos se ha convertido en un punto de referencia para los habitantes del pueblo y los miles de visitantes que llegan cada temporada vacacional.
						</p>
						<p>
							El nombre "Tendejón" refleja nuestras raíces yucatecas — así es como en la península llamamos a las tiendas de la esquina, esas donde encuentras de todo, desde lo básico para la despensa hasta ese antojito que no puede faltar. <strong>Azael</strong>, el nombre de uno de los hijos de la familia fundadora, le da ese toque personal que nos caracteriza.
						</p>
						<p>
							A lo largo de los años hemos crecido para ofrecer un catálogo cada vez más amplio: abarrotes, bebidas frías, snacks, hielo, productos de higiene, artículos de limpieza y mucho más. Todo pensado para que nuestros clientes — ya sean vecinos del pueblo o familias de vacaciones — encuentren lo que necesitan sin tener que desplazarse hasta Motul o Mérida.
						</p>
					</div>
				</div>
			</section>

			<!-- Misión y valores -->
			<section class="mb-12">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
						<h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-3">
							<i class="fas fa-bullseye text-cyan-600 dark:text-cyan-400"></i> Nuestra Misión
						</h2>
						<p class="text-gray-700 dark:text-gray-300">
							Ser la tienda de confianza de Chabihau, ofreciendo productos de calidad a precios accesibles, con un servicio cálido y cercano que haga sentir a cada cliente como en casa. Queremos que tanto los vecinos como los visitantes tengan la tranquilidad de encontrar todo lo que necesitan a la vuelta de la esquina.
						</p>
					</div>
					<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
						<h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-3">
							<i class="fas fa-eye text-cyan-600 dark:text-cyan-400"></i> Nuestra Visión
						</h2>
						<p class="text-gray-700 dark:text-gray-300">
							Convertirnos en el mejor punto de abastecimiento de la costa norte de Yucatán, incorporando tecnología para mejorar la experiencia de compra sin perder la esencia de tienda de barrio que nos define. Buscamos crecer de manera sustentable, apoyando siempre a nuestra comunidad.
						</p>
					</div>
				</div>
			</section>

			<!-- Por qué elegirnos -->
			<section class="mb-12">
				<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">¿Por qué elegirnos?</h2>
				<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
					<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 text-center">
						<div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900 rounded-full flex items-center justify-center mx-auto mb-4">
							<i class="fas fa-clock text-2xl text-cyan-600 dark:text-cyan-400"></i>
						</div>
						<h3 class="font-bold text-gray-900 dark:text-white mb-2">Horario Amplio</h3>
						<p class="text-sm text-gray-600 dark:text-gray-400">Abiertos todos los días de 7:00 AM a 9:00 PM. Horario extendido en temporada vacacional.</p>
					</div>
					<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 text-center">
						<div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900 rounded-full flex items-center justify-center mx-auto mb-4">
							<i class="fas fa-map-marker-alt text-2xl text-cyan-600 dark:text-cyan-400"></i>
						</div>
						<h3 class="font-bold text-gray-900 dark:text-white mb-2">Ubicación Céntrica</h3>
						<p class="text-sm text-gray-600 dark:text-gray-400">En el centro de Chabihau, a pocos pasos de la playa. Fácil de encontrar para vecinos y visitantes.</p>
					</div>
					<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 text-center">
						<div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900 rounded-full flex items-center justify-center mx-auto mb-4">
							<i class="fas fa-boxes-stacked text-2xl text-cyan-600 dark:text-cyan-400"></i>
						</div>
						<h3 class="font-bold text-gray-900 dark:text-white mb-2">Variedad</h3>
						<p class="text-sm text-gray-600 dark:text-gray-400">Más de 500 productos: abarrotes, bebidas, snacks, hielo, limpieza, higiene y más.</p>
					</div>
					<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 text-center">
						<div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900 rounded-full flex items-center justify-center mx-auto mb-4">
							<i class="fas fa-heart text-2xl text-cyan-600 dark:text-cyan-400"></i>
						</div>
						<h3 class="font-bold text-gray-900 dark:text-white mb-2">Trato Familiar</h3>
						<p class="text-sm text-gray-600 dark:text-gray-400">Somos una familia que atiende con calidez. Aquí te conocemos por tu nombre y te ayudamos con gusto.</p>
					</div>
				</div>
			</section>

			<!-- Comunidad -->
			<section class="mb-12">
				<div class="bg-gradient-to-r from-cyan-600 to-blue-700 rounded-2xl shadow-lg p-8 md:p-10 text-white">
					<h2 class="text-2xl font-bold mb-4 flex items-center gap-3">
						<i class="fas fa-users"></i> Compromiso con Chabihau
					</h2>
					<div class="space-y-4 text-cyan-50">
						<p>
							Para nosotros, Chabihau no es solo donde está nuestra tienda — es nuestro hogar. Por eso nos importa el bienestar de la comunidad. Colaboramos con las iniciativas locales, apoyamos las festividades del pueblo y procuramos ofrecer empleo a jóvenes de la zona.
						</p>
						<p>
							Creemos firmemente que una tienda de barrio puede ser un motor de cambio positivo. Cada compra que haces con nosotros apoya directamente a una familia yucateca y contribuye a la economía local de este hermoso rincón de la costa norte.
						</p>
					</div>
				</div>
			</section>
		</div>
	</main>

	@include('partials.footer')

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
</body>
</html>
