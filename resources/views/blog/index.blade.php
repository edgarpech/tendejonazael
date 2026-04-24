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
	<title>Blog | Tendejón Azael - Chabihau, Yucatán</title>
	<meta name="description" content="Lee nuestros artículos sobre Chabihau, Yucatán: guías de viaje, recomendaciones de productos, recetas y todo lo que necesitas saber para disfrutar la costa norte de Yucatán.">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="{{ url('/blog') }}">
	<link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ url('/blog') }}">
	<meta property="og:title" content="Blog | Tendejón Azael - Chabihau, Yucatán">
	<meta property="og:site_name" content="Tendejón Azael">
	<meta property="og:description" content="Artículos sobre Chabihau, guías de viaje, recomendaciones y más.">
	<meta property="og:image" content="{{ asset('images/logos/logo_general.jpg') }}">
	<meta property="og:locale" content="es_MX">
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
	</style>
	<!-- Google AdSense -->
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4900355905448266" crossorigin="anonymous"></script>
</head>
<body x-data="{ darkMode: document.documentElement.classList.contains('dark'), scrolled: false, lang: document.cookie.match(/googtrans=\/es\/en/) ? 'en' : 'es' }" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

	@include('partials.header-secondary')

	<main class="pt-24 pb-12">
		<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Encabezado del blog -->
			<div class="mb-10 text-center">
				<h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">Blog de Tendejón Azael</h1>
				<p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Guías de viaje, recomendaciones, recetas y todo lo que necesitas saber sobre Chabihau y la costa norte de Yucatán.</p>
			</div>

			@if($articles->isEmpty())
				<div class="text-center py-16">
					<i class="fas fa-pen-fancy text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
					<p class="text-gray-500 dark:text-gray-400">Próximamente publicaremos artículos. ¡Vuelve pronto!</p>
				</div>
			@else
				<!-- Artículos destacados -->
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
					@foreach($articles as $article)
						<article class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
							@if($article->image)
								<a href="{{ route('blog.show', $article->slug) }}">
									<img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover" loading="lazy">
								</a>
							@else
								<a href="{{ route('blog.show', $article->slug) }}" class="block w-full h-48 bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
									<i class="fas fa-newspaper text-5xl text-white/50"></i>
								</a>
							@endif
							<div class="p-6 flex flex-col flex-1">
								<div class="flex items-center gap-2 mb-3">
									<span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300 capitalize">{{ $article->category }}</span>
									<time class="text-xs text-gray-500 dark:text-gray-400" datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->translatedFormat('d M Y') }}</time>
								</div>
								<h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
									<a href="{{ route('blog.show', $article->slug) }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition">{{ $article->title }}</a>
								</h2>
								<p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3 flex-1">{{ $article->excerpt }}</p>
								<a href="{{ route('blog.show', $article->slug) }}" class="inline-flex items-center text-sm font-semibold text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition mt-auto">
									Leer más <i class="fas fa-arrow-right ml-2 text-xs"></i>
								</a>
							</div>
						</article>
					@endforeach
				</div>

				{{-- Anuncio AdSense Multiplex (autorelaxed) al pie del listado del blog --}}
				<div class="my-10">
					<ins class="adsbygoogle"
						 style="display:block"
						 data-ad-format="autorelaxed"
						 data-ad-client="ca-pub-4900355905448266"
						 data-ad-slot="4645155341"></ins>
					<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
				</div>
			@endif
		</div>
	</main>

	@include('partials.footer')

	{{-- JSON-LD: Blog + ItemList con artículos para SEO/AdSense --}}
	<script type="application/ld+json">
	{!! json_encode([
		'@context' => 'https://schema.org',
		'@type' => 'Blog',
		'@id' => url('/blog'),
		'url' => url('/blog'),
		'name' => 'Blog de Tendejón Azael',
		'description' => 'Guías de viaje, recomendaciones, recetas y artículos sobre Chabihau y la costa norte de Yucatán.',
		'inLanguage' => 'es-MX',
		'publisher' => [
			'@type' => 'Organization',
			'name' => 'Tendejón Azael',
			'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logos/logo_general.jpg')],
		],
		'blogPost' => $articles->map(function ($a) {
			return array_filter([
				'@type' => 'BlogPosting',
				'headline' => $a->title,
				'description' => $a->excerpt,
				'url' => url('/blog/' . $a->slug),
				'datePublished' => optional($a->published_at)->toIso8601String(),
				'dateModified' => optional($a->updated_at)->toIso8601String(),
				'image' => $a->image ? asset($a->image) : null,
				'author' => ['@type' => 'Organization', 'name' => 'Tendejón Azael'],
			]);
		})->all(),
	], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
	</script>
	<script type="application/ld+json">
	{
		"@@context": "https://schema.org",
		"@@type": "BreadcrumbList",
		"itemListElement": [
			{ "@@type": "ListItem", "position": 1, "name": "Inicio", "item": "{{ url('/') }}" },
			{ "@@type": "ListItem", "position": 2, "name": "Blog", "item": "{{ url('/blog') }}" }
		]
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
</body>
</html>
