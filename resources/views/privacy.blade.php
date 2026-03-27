<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6130FGQMRE"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-6130FGQMRE');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso de Privacidad - Tendejón Azael</title>
    <meta name="description" content="Aviso de privacidad y política de cookies de Tendejón Azael, tienda de abarrotes en Chabihau, Yucatán.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/aviso-de-privacidad') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4900355905448266" crossorigin="anonymous"></script>
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body x-data="{ darkMode: document.documentElement.classList.contains('dark'), scrolled: false }" @scroll.window="scrolled = window.pageYOffset > 50" class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    <!-- Header -->
    <header :class="scrolled ? 'bg-white dark:bg-gray-800 shadow-lg' : 'bg-white/95 dark:bg-gray-800/95'" class="fixed w-full top-0 z-[60] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center">
                    <img x-show="!darkMode" src="{{ asset('images/logos/logo_text_dark.webp') }}" alt="Tendejón Azael" class="h-10 md:h-12 w-auto" width="99" height="48">
                    <img x-show="darkMode" x-cloak src="{{ asset('images/logos/logo_text.webp') }}" alt="Tendejón Azael" class="h-10 md:h-12 w-auto" width="99" height="48">
                </a>
                <div class="flex items-center gap-4">
                    <a href="/" class="text-gray-700 dark:text-gray-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition font-medium">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al inicio
                    </a>
                    <button @click="darkMode = document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', darkMode)"
                            class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer"
                            aria-label="Cambiar modo oscuro">
                        <i x-show="!darkMode" class="fas fa-moon"></i>
                        <i x-show="darkMode" x-cloak class="fas fa-sun"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Content -->
    <main class="pt-24 pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-8">Aviso de Privacidad</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">Última actualización: {{ date('d/m/Y') }}</p>

            <div class="prose prose-lg dark:prose-invert max-w-none space-y-8">

                <!-- Responsable -->
                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">1. Responsable de los datos</h2>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Tendejón Azael</strong>, con domicilio en Chabihau, Yobaín, Yucatán, México, es responsable del tratamiento de los datos personales que pudieran recopilarse a través de este sitio web.
                    </p>
                </section>

                <!-- Datos que se recopilan -->
                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">2. Datos que recopilamos</h2>
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
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">3. Finalidad del tratamiento</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">Los datos recopilados se utilizan para:</p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Analizar el tráfico y comportamiento de navegación para mejorar el sitio web (Google Analytics).</li>
                        <li>Mostrar anuncios publicitarios relevantes a través de servicios de terceros (Google AdSense).</li>
                        <li>Garantizar el correcto funcionamiento del sitio web.</li>
                    </ul>
                </section>

                <!-- Cookies -->
                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">4. Política de Cookies</h2>
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
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">5. Servicios de terceros</h2>
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
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">6. Derechos ARCO</h2>
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
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">7. Cambios al aviso de privacidad</h2>
                    <p class="text-gray-700 dark:text-gray-300">
                        Nos reservamos el derecho de modificar este aviso de privacidad en cualquier momento. Cualquier cambio será publicado en esta misma página con la fecha de actualización correspondiente.
                    </p>
                </section>

                <!-- Consentimiento -->
                <section class="bg-cyan-50 dark:bg-cyan-900/20 rounded-xl p-6 border border-cyan-200 dark:border-cyan-800">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">8. Consentimiento</h2>
                    <p class="text-gray-700 dark:text-gray-300">
                        Al navegar en este sitio web, aceptas el uso de cookies y el tratamiento de datos conforme a lo descrito en este aviso de privacidad. Si no estás de acuerdo, te recomendamos no utilizar este sitio o configurar tu navegador para bloquear las cookies.
                    </p>
                </section>

            </div>
        </div>
    </main>

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
                <p>&copy; 2007-{{ date('Y') }} Tendejón Azael. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>
