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
	<title>{{ $article->title }}</title>
	<meta name="description" content="{{ \Illuminate\Support\Str::limit($article->excerpt, 155) }}">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="{{ url('/blog/' . $article->slug) }}">
	<link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
	<meta property="og:type" content="article">
	<meta property="og:url" content="{{ url('/blog/' . $article->slug) }}">
	<meta property="og:title" content="{{ $article->title }} | Tendejón Azael">
	<meta property="og:site_name" content="Tendejón Azael">
	<meta property="og:description" content="{{ \Illuminate\Support\Str::limit($article->excerpt, 200) }}">
	@if($article->image)
		<meta property="og:image" content="{{ asset($article->image) }}">
	@else
		<meta property="og:image" content="{{ asset('images/logos/logo_general.jpg') }}">
	@endif
	<meta property="og:locale" content="es_MX">
	<meta property="article:published_time" content="{{ $article->published_at->toIso8601String() }}">

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="{{ $article->title }}">
	<meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit($article->excerpt, 155) }}">
	@if($article->image)
		<meta name="twitter:image" content="{{ asset($article->image) }}">
	@else
		<meta name="twitter:image" content="{{ asset('images/logos/logo_general.jpg') }}">
	@endif
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
	<!-- Google AdSense -->
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4900355905448266" crossorigin="anonymous"></script>
	<!-- Datos estructurados Article -->
	<script type="application/ld+json">
	{
		"@@context": "https://schema.org",
		"@@type": "Article",
		"headline": "{{ $article->title }}",
		"description": "{{ $article->excerpt }}",
		"datePublished": "{{ $article->published_at->toIso8601String() }}",
		"dateModified": "{{ $article->updated_at->toIso8601String() }}",
		"author": {
			"@@type": "Organization",
			"name": "Tendejón Azael"
		},
		"publisher": {
			"@@type": "Organization",
			"name": "Tendejón Azael",
			"logo": {
				"@@type": "ImageObject",
				"url": "{{ asset('images/logos/logo_general.jpg') }}"
			}
		}
	}
	</script>
</head>
<body x-data="{ darkMode: document.documentElement.classList.contains('dark'), scrolled: false, lang: document.cookie.match(/googtrans=\/es\/en/) ? 'en' : 'es' }" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

	@include('partials.header-secondary')

	<main class="pt-24 pb-12">
		<article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Breadcrumb -->
			<nav class="mb-6 text-sm text-gray-500 dark:text-gray-400">
				<a href="/" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition">Inicio</a>
				<span class="mx-2">/</span>
				<a href="{{ route('blog') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition">Blog</a>
				<span class="mx-2">/</span>
				<span class="text-gray-700 dark:text-gray-300">{{ $article->title }}</span>
			</nav>

			<!-- Encabezado del artículo -->
			<header class="mb-8">
				<div class="flex items-center gap-3 mb-4">
					<span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300 capitalize">{{ $article->category }}</span>
					<time class="text-sm text-gray-500 dark:text-gray-400" datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->translatedFormat('d \d\e F, Y') }}</time>
				</div>
				<h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white leading-tight">{{ $article->title }}</h1>
			</header>

			@if($article->image)
				<img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full rounded-2xl mb-8 shadow-lg" loading="lazy">
			@endif

			@php
				// AdSense recomienda colocar el anuncio in-article ~2 párrafos dentro del contenido.
				// Inyectamos el bloque de anuncio justo después del 2º cierre de </p>.
				$inArticleAd = '<div class="my-6 not-prose">'
					.'<ins class="adsbygoogle" style="display:block; text-align:center;"'
					." data-ad-layout=\"in-article\" data-ad-format=\"fluid\""
					." data-ad-client=\"ca-pub-4900355905448266\" data-ad-slot=\"4149189681\"></ins>"
					.'<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>'
					.'</div>';
				$contentWithAd = preg_replace('#(</p>)#i', '$1'.$inArticleAd, $article->content, 2);
				// Si reemplazó las dos ocurrencias, dejamos solo la 2ª; si no, conservamos la única.
				if (substr_count($contentWithAd, $inArticleAd) > 1) {
					$pos = strpos($contentWithAd, $inArticleAd);
					$contentWithAd = substr_replace($contentWithAd, '', $pos, strlen($inArticleAd));
				}
			@endphp

			<!-- Contenido del artículo (con anuncio in-article inyectado tras el 2º párrafo) -->
			<div class="prose prose-lg dark:prose-invert max-w-none
				prose-headings:text-gray-900 dark:prose-headings:text-white
				prose-p:text-gray-700 dark:prose-p:text-gray-300
				prose-a:text-cyan-600 dark:prose-a:text-cyan-400
				prose-strong:text-gray-900 dark:prose-strong:text-white
				prose-ul:text-gray-700 dark:prose-ul:text-gray-300
				prose-ol:text-gray-700 dark:prose-ol:text-gray-300
				prose-li:text-gray-700 dark:prose-li:text-gray-300">
				{!! $contentWithAd !!}
			</div>

			<!-- Compartir -->
			<div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700">
				<p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Comparte este artículo:</p>
				<div class="flex gap-3">
					<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/blog/' . $article->slug)) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition" aria-label="Compartir en Facebook">
						<i class="fab fa-facebook-f"></i>
					</a>
					<a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url('/blog/' . $article->slug)) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition" aria-label="Compartir en WhatsApp">
						<i class="fab fa-whatsapp"></i>
					</a>
				</div>
			</div>

			{{-- Anuncio AdSense display responsive al final del artículo --}}
			<div class="mt-10">
				<!-- Blog artículo final -->
				<ins class="adsbygoogle"
					 style="display:block"
					 data-ad-client="ca-pub-4900355905448266"
					 data-ad-slot="9582101887"
					 data-ad-format="auto"
					 data-full-width-responsive="true"></ins>
				<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
			</div>
		</article>

		<!-- Artículos relacionados -->
		@if($related->isNotEmpty())
			<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
				<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Artículos relacionados</h2>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
					@foreach($related as $rel)
						<article class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
							@if($rel->image)
								<a href="{{ route('blog.show', $rel->slug) }}">
									<img src="{{ asset($rel->image) }}" alt="{{ $rel->title }}" class="w-full h-40 object-cover" loading="lazy">
								</a>
							@else
								<a href="{{ route('blog.show', $rel->slug) }}" class="block w-full h-40 bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
									<i class="fas fa-newspaper text-4xl text-white/50"></i>
								</a>
							@endif
							<div class="p-5 flex flex-col flex-1">
								<span class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 capitalize mb-2">{{ $rel->category }}</span>
								<h3 class="text-base font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
									<a href="{{ route('blog.show', $rel->slug) }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition">{{ $rel->title }}</a>
								</h3>
								<p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 flex-1">{{ $rel->excerpt }}</p>
							</div>
						</article>
					@endforeach
				</div>
			</section>
		@endif
	</main>

	@include('partials.footer')

	{{-- JSON-LD: BreadcrumbList del artículo --}}
	<script type="application/ld+json">
	{
		"@@context": "https://schema.org",
		"@@type": "BreadcrumbList",
		"itemListElement": [
			{ "@@type": "ListItem", "position": 1, "name": "Inicio", "item": "{{ url('/') }}" },
			{ "@@type": "ListItem", "position": 2, "name": "Blog", "item": "{{ url('/blog') }}" },
			{ "@@type": "ListItem", "position": 3, "name": @json($article->title), "item": "{{ url('/blog/' . $article->slug) }}" }
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
