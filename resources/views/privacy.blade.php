<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6130FGQMRE"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-6130FGQMRE');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso de Privacidad | Tendejón Azael - Chabihau, Yucatán</title>
    <meta name="description" content="Aviso de privacidad y política de cookies de Tendejón Azael, tienda de abarrotes en Chabihau, Yucatán.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/aviso-de-privacidad') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/aviso-de-privacidad') }}">
    <meta property="og:title" content="Aviso de Privacidad | Tendejón Azael - Chabihau, Yucatán">
    <meta property="og:description" content="Aviso de privacidad y política de cookies de Tendejón Azael, tienda de abarrotes en Chabihau, Yucatán.">
    <meta property="og:image" content="{{ asset('images/logos/logo_general.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Tendejón Azael - Chabihau, Yucatán">
    <meta property="og:site_name" content="Tendejón Azael">
    <meta property="og:locale" content="es_MX">

    <!-- Meta Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Aviso de Privacidad | Tendejón Azael - Chabihau, Yucatán">
    <meta name="twitter:description" content="Aviso de privacidad y política de cookies de Tendejón Azael, Chabihau.">
    <meta name="twitter:image" content="{{ asset('images/logos/logo_general.jpg') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
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
</head>
<body x-data="{ darkMode: document.documentElement.classList.contains('dark'), scrolled: false, lang: document.cookie.match(/googtrans=\/es\/en/) ? 'en' : 'es' }" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    <!-- Header -->
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

    <!-- Content -->
    <main class="pt-24 pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">Aviso de Privacidad</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">Última actualización: 21 de marzo de 2026</p>

            <div class="prose prose-sm md:prose-base dark:prose-invert max-w-none space-y-6">

                <!-- Responsable -->
                <section>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">1. Responsable de los datos</h2>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Tendejón Azael</strong>, con domicilio en Chabihau, Yobaín, Yucatán, México, es responsable del tratamiento de los datos personales que pudieran recopilarse a través de este sitio web.
                    </p>
                </section>

                <!-- Datos que se recopilan -->
                <section>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">2. Datos que recopilamos</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        Este sitio web es de carácter <strong>informativo</strong> y no requiere registro ni recopila datos personales directamente. Sin embargo, de forma automática podemos recibir:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li><strong>Datos de navegación:</strong> dirección IP, tipo de navegador, sistema operativo, páginas visitadas, tiempo de permanencia y fecha/hora de acceso.</li>
                        <li><strong>Cookies:</strong> pequeños archivos de texto almacenados en tu dispositivo para mejorar la experiencia de navegación y mostrar publicidad relevante.</li>
                    </ul>
                </section>

                <!-- Finalidad -->
                <section>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">3. Finalidad del tratamiento</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">Los datos recopilados se utilizan para:</p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Analizar el tráfico y comportamiento de navegación para mejorar el sitio web (Google Analytics).</li>
                        <li>Mostrar anuncios publicitarios relevantes a través de servicios de terceros (Google AdSense).</li>
                        <li>Garantizar el correcto funcionamiento del sitio web.</li>
                    </ul>
                </section>

                <!-- Cookies -->
                <section>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">4. Política de Cookies</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">Este sitio utiliza los siguientes tipos de cookies:</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900 dark:text-white">Tipo</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 dark:text-white">Finalidad</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 dark:text-white">Duración</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 dark:text-gray-300">
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-3 font-medium">Esenciales</td>
                                    <td class="px-4 py-3">Funcionamiento básico del sitio (modo oscuro, preferencias de idioma).</td>
                                    <td class="px-4 py-3">Sesión / Persistentes</td>
                                </tr>
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-3 font-medium">Analíticas</td>
                                    <td class="px-4 py-3">Google Analytics: estadísticas de uso y tráfico del sitio.</td>
                                    <td class="px-4 py-3">Hasta 2 años</td>
                                </tr>
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-3 font-medium">Publicitarias</td>
                                    <td class="px-4 py-3">Google AdSense: mostrar anuncios relevantes según intereses de navegación.</td>
                                    <td class="px-4 py-3">Hasta 2 años</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="text-gray-700 dark:text-gray-300 mt-4">
                        Puedes configurar tu navegador para rechazar cookies o eliminar las existentes. Ten en cuenta que desactivar cookies puede afectar la funcionalidad del sitio.
                    </p>
                </section>

                <!-- Terceros -->
                <section>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">5. Servicios de terceros</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">Este sitio utiliza los siguientes servicios de terceros que pueden recopilar información:</p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li><strong>Google Analytics:</strong> para análisis de tráfico web. <a href="https://policies.google.com/privacy" target="_blank" rel="noopener" class="text-cyan-600 dark:text-cyan-400 hover:underline">Política de privacidad de Google</a>.</li>
                        <li><strong>Google AdSense:</strong> para la visualización de anuncios publicitarios. Google utiliza cookies para mostrar anuncios basados en visitas previas del usuario a este y otros sitios web.</li>
                        <li><strong>Google Maps:</strong> para mostrar la ubicación de nuestra tienda.</li>
                        <li><strong>Google Translate:</strong> para la traducción del contenido del sitio.</li>
                    </ul>
                </section>

                <!-- Derechos ARCO -->
                <section>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">6. Derechos ARCO</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        De acuerdo con la Ley Federal de Protección de Datos Personales en Posesión de los Particulares (LFPDPPP), tienes derecho a:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li><strong>Acceder</strong> a tus datos personales.</li>
                        <li><strong>Rectificar</strong> datos inexactos o incompletos.</li>
                        <li><strong>Cancelar</strong> el tratamiento de tus datos.</li>
                        <li><strong>Oponerte</strong> al tratamiento de tus datos para fines específicos.</li>
                    </ul>
                    <p class="text-gray-700 dark:text-gray-300 mt-3">
                        Para ejercer estos derechos, puedes contactarnos a través de nuestro WhatsApp: <a href="https://wa.me/+5219911161668" target="_blank" class="text-cyan-600 dark:text-cyan-400 hover:underline">+52 1 991 116 1668</a>.
                    </p>
                </section>

                <!-- Cambios -->
                <section>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">7. Cambios al aviso de privacidad</h2>
                    <p class="text-gray-700 dark:text-gray-300">
                        Nos reservamos el derecho de modificar este aviso de privacidad en cualquier momento. Cualquier cambio será publicado en esta misma página con la fecha de actualización correspondiente.
                    </p>
                </section>

                <!-- Consentimiento -->
                <section class="bg-cyan-50 dark:bg-cyan-900/20 rounded-xl p-6 border border-cyan-200 dark:border-cyan-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">8. Consentimiento</h2>
                    <p class="text-gray-700 dark:text-gray-300">
                        Al navegar en este sitio web, aceptas el uso de cookies y el tratamiento de datos conforme a lo descrito en este aviso de privacidad. Si no estás de acuerdo, te recomendamos no utilizar este sitio o configurar tu navegador para bloquear las cookies.
                    </p>
                </section>

            </div>
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
