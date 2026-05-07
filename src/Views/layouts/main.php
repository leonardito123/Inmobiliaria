<!DOCTYPE html>
<?php
$mainJsAsset = '/assets/main.js';
$mainCssAssets = [];
$preloadFontAssets = [];
$manifestPath = ROOT_PATH . '/public/assets/.vite/manifest.json';

$fontPatterns = [
    'playfair-display-latin-400-normal.*.woff2',
    'ibm-plex-sans-latin-400-normal.*.woff2',
];

foreach ($fontPatterns as $pattern) {
    $matches = glob(ROOT_PATH . '/public/assets/' . $pattern);

    if (!empty($matches)) {
        $preloadFontAssets[] = '/assets/' . basename($matches[0]);
    }
}

if (file_exists($manifestPath)) {
    $manifestRaw = file_get_contents($manifestPath);
    $manifest = json_decode($manifestRaw, true);

    if (is_array($manifest) && isset($manifest['js/main.js'])) {
        $entry = $manifest['js/main.js'];

        if (!empty($entry['file'])) {
            $mainJsAsset = '/assets/' . $entry['file'];
        }

        if (!empty($entry['css']) && is_array($entry['css'])) {
            foreach ($entry['css'] as $cssFile) {
                $mainCssAssets[] = '/assets/' . $cssFile;
            }
        }
    }
}

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$isHome = ($currentPath === '/');

$navLinks = [
    ['href' => '/', 'label' => 'Inicio', 'i18n' => 'nav.home'],
    ['href' => '/venta', 'label' => 'Venta', 'i18n' => 'nav.sale'],
    ['href' => '/renta', 'label' => 'Renta', 'i18n' => 'nav.rent'],
    ['href' => '/desarrollos', 'label' => 'Desarrollos', 'i18n' => 'nav.developments'],
    ['href' => '/contacto', 'label' => 'Contacto', 'i18n' => 'nav.contact'],
];
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0a0a0a">
    <link rel="manifest" href="/manifest.webmanifest">
    
    <!-- SEO Tags -->
    <?php echo $seo_tags ?? ''; ?>

        <!-- Preload critical fonts -->
        <?php foreach ($preloadFontAssets as $fontAsset): ?>
          <link rel="preload" as="font" type="font/woff2"
              href="<?php echo htmlspecialchars($fontAsset); ?>"
              crossorigin="anonymous">
        <?php endforeach; ?>

    <?php foreach ($mainCssAssets as $cssAsset): ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($cssAsset); ?>">
    <?php endforeach; ?>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin="anonymous">
    <script defer
            src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin="anonymous"></script>

    <style>
    @keyframes hero-fade-up {
        from { opacity: 0; transform: translateY(1.25rem); }
        to { opacity: 1; transform: translateY(0); }
    }

    .anim-word {
        display: inline-block;
        opacity: 0;
        animation: hero-fade-up .65s ease both;
    }

    .anim-copy {
        opacity: 0;
        animation: hero-fade-up .7s ease both;
    }

    @media (prefers-reduced-motion: reduce) {
        .anim-word,
        .anim-copy {
            opacity: 1;
            animation: none;
        }
    }
    </style>

    <script type="module" src="<?php echo htmlspecialchars($mainJsAsset); ?>"></script>
</head>
<body class="font-sans bg-ink text-paper">

    <!-- â”€â”€ TOP INFO BAR â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <div class="bg-black text-paper/60 text-xs font-mono tracking-[0.15em] py-2 text-center border-b border-white/5">
        <span>Paseo de la Reforma 24, Col. JuÃ¡rez, CDMX, C.P. 06600</span>
        <span class="mx-4 text-white/20">|</span>
        <a href="tel:+525541698259" class="hover:text-gold transition-colors">(52) 55 4169 8259</a>
    </div>

    <!-- â”€â”€ NAVIGATION â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <nav id="mainNav" class="bg-ink backdrop-blur-sm text-paper py-4 sticky top-0 z-50 border-b border-white/8 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-16 flex items-center gap-8">

            <!-- Logo â€” extremo izquierdo -->
            <a href="/" class="text-lg font-serif font-black tracking-[0.1em] uppercase hover:text-gold transition-colors flex-shrink-0">
                HAVRE<span class="text-gold">&middot;</span>ESTATES
            </a>

            <!-- Links centrados â€” ocupa el espacio restante -->
            <ul class="hidden md:flex items-center flex-1 justify-center gap-0">
                <?php
                $navIndex = 0;
                $navTotal = count($navLinks);
                foreach ($navLinks as $item):
                    $isActive = ($currentPath === $item['href']);
                    $navIndex++;
                ?>
                <li class="flex items-center">
                    <a href="<?php echo htmlspecialchars($item['href']); ?>"
                       data-i18n="<?php echo htmlspecialchars($item['i18n']); ?>"
                       class="px-4 lg:px-5 py-1.5 text-[11px] lg:text-[12px] font-mono tracking-[0.22em] uppercase whitespace-nowrap transition-colors duration-200
                              <?php echo $isActive ? 'text-paper border-b border-gold' : 'text-paper/55 hover:text-paper'; ?>">
                        <?php echo htmlspecialchars($item['label']); ?>
                    </a>
                    <?php if ($navIndex < $navTotal): ?>
                    <span class="text-paper/20 text-[10px] select-none" aria-hidden="true">Â·</span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>

            <!-- Derecha: selector idioma + CTA â€” extremo derecho -->
            <div class="hidden md:flex items-center gap-5 flex-shrink-0">

                <!-- Selector ES / EN / FR elegante -->
                <div class="lang-switcher flex items-center border border-white/15 divide-x divide-white/10 overflow-hidden"
                     role="group" aria-label="Selector de idioma">
                    <button type="button" data-lang-switch="es"
                            class="lang-switch px-3 py-1.5 text-[10px] font-mono tracking-[0.25em] uppercase transition-all duration-200 text-paper/45 hover:text-paper hover:bg-white/5">
                        ES
                    </button>
                    <button type="button" data-lang-switch="en"
                            class="lang-switch px-3 py-1.5 text-[10px] font-mono tracking-[0.25em] uppercase transition-all duration-200 text-paper/45 hover:text-paper hover:bg-white/5">
                        EN
                    </button>
                    <button type="button" data-lang-switch="fr"
                            class="lang-switch px-3 py-1.5 text-[10px] font-mono tracking-[0.25em] uppercase transition-all duration-200 text-paper/45 hover:text-paper hover:bg-white/5">
                        FR
                    </button>
                </div>

                <!-- CTA -->
                <a href="/contacto"
                   data-i18n="nav.bookVisit"
                   class="inline-flex items-center gap-2 px-5 py-2.5 border border-gold text-gold text-[10px] font-mono tracking-[0.28em] uppercase whitespace-nowrap hover:bg-gold hover:text-ink transition-all duration-300">
                    Agendar Visita
                </a>

            </div><!-- /derecha -->

        </div><!-- /nav-inner -->
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <!-- â”€â”€ FOOTER â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <footer class="bg-black text-paper/50">
        <!-- Links grid â€” 5 columnas horizontales, bien distribuidas -->
        <div class="max-w-7xl mx-auto px-8 lg:px-16 py-10 border-b border-white/8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">

                <!-- Marca (col mÃ¡s ancha) -->
                <div class="lg:col-span-2">
                    <p class="font-serif font-black text-paper tracking-[0.08em] uppercase text-[15px] mb-3">HAVRE<span class="text-gold">&middot;</span>ESTATES</p>
                    <p data-i18n="footer.description" class="text-[11px] leading-relaxed text-paper/35 max-w-[32ch] mb-4">Plataforma inmobiliaria de lujo en Mexico, Colombia y Chile.</p>
                    <p class="text-[11px] text-paper/35">
                        <a href="tel:+525541698259" class="hover:text-gold transition-colors">(52) 55 4169 8259</a>
                    </p>
                    <p class="mt-1 text-[11px] text-paper/35">
                        <a href="mailto:info@havreestates.mx" class="hover:text-gold transition-colors">info@havreestates.mx</a>
                    </p>
                </div>

                <!-- Servicios -->
                <div>
                    <h4 data-i18n="footer.services" class="text-[10px] font-mono tracking-[0.35em] uppercase text-paper/40 mb-4">Servicios</h4>
                    <ul class="space-y-2.5 text-[11px]">
                        <li><a href="/venta" data-i18n="nav.sale" class="hover:text-gold transition-colors">Venta</a></li>
                        <li><a href="/renta" data-i18n="nav.rent" class="hover:text-gold transition-colors">Renta</a></li>
                        <li><a href="/desarrollos" data-i18n="nav.developments" class="hover:text-gold transition-colors">Desarrollos</a></li>
                    </ul>
                </div>

                <!-- Empresa -->
                <div>
                    <h4 data-i18n="footer.company" class="text-[10px] font-mono tracking-[0.35em] uppercase text-paper/40 mb-4">Empresa</h4>
                    <ul class="space-y-2.5 text-[11px]">
                        <li><a href="/contacto" data-i18n="nav.contact" class="hover:text-gold transition-colors">Contacto</a></li>
                        <li><a href="#" data-i18n="footer.press" class="hover:text-gold transition-colors">Prensa</a></li>
                        <li><a href="#" data-i18n="footer.blog" class="hover:text-gold transition-colors">Blog</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 data-i18n="footer.legal" class="text-[10px] font-mono tracking-[0.35em] uppercase text-paper/40 mb-4">Legal</h4>
                    <ul class="space-y-2.5 text-[11px]">
                        <li><a href="#" data-i18n="footer.privacy" class="hover:text-gold transition-colors">Privacidad</a></li>
                        <li><a href="#" data-i18n="footer.terms" class="hover:text-gold transition-colors">Terminos</a></li>
                        <li><a href="#" data-i18n="footer.cookies" class="hover:text-gold transition-colors">Cookies</a></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- Bottom bar -->
        <div class="max-w-7xl mx-auto px-8 lg:px-16 py-5 flex flex-col sm:flex-row items-center justify-between gap-2 text-[10px] font-mono tracking-[0.08em] text-paper/25">
            <p><span data-i18n="footer.copy">Copyright</span> Â© <?php echo date('Y'); ?> HAVRE ESTATES â€” <span data-i18n="footer.rights">Todos los derechos reservados.</span></p>
            <p><span data-i18n="footer.hotline">LLAMANOS LAS 24 HORAS</span> &nbsp;Â·&nbsp; (52) 55 4169 8259</p>
        </div>
    </footer>

    <!-- JSON-LD Schema -->
    <?php echo $seo_json_ld ?? ''; ?>

    <script>
    (function () {
        var TOKEN_TRANSLATIONS = {
            es: {
                'nav.home': 'Inicio',
                'nav.sale': 'Venta',
                'nav.rent': 'Renta',
                'nav.developments': 'Desarrollos',
                'nav.contact': 'Contacto',
                'nav.bookVisit': 'Agendar Visita',
                'footer.description': 'Plataforma inmobiliaria de lujo en Mexico, Colombia y Chile.',
                'footer.services': 'Servicios',
                'footer.company': 'Empresa',
                'footer.legal': 'Legal',
                'footer.press': 'Prensa',
                'footer.blog': 'Blog',
                'footer.privacy': 'Privacidad',
                'footer.terms': 'Terminos',
                'footer.cookies': 'Cookies',
                'footer.copy': 'Copyright',
                'footer.rights': 'Todos los derechos reservados.',
                'footer.hotline': 'LLAMANOS LAS 24 HORAS'
            },
            en: {
                'nav.home': 'Home',
                'nav.sale': 'Sale',
                'nav.rent': 'Rent',
                'nav.developments': 'Developments',
                'nav.contact': 'Contact',
                'nav.bookVisit': 'Book Visit',
                'footer.description': 'Luxury real estate platform in Mexico, Colombia and Chile.',
                'footer.services': 'Services',
                'footer.company': 'Company',
                'footer.legal': 'Legal',
                'footer.press': 'Press',
                'footer.blog': 'Blog',
                'footer.privacy': 'Privacy',
                'footer.terms': 'Terms',
                'footer.cookies': 'Cookies',
                'footer.copy': 'Copyright',
                'footer.rights': 'All rights reserved.',
                'footer.hotline': 'CALL US 24 HOURS'
            },
            fr: {
                'nav.home': 'Accueil',
                'nav.sale': 'Vente',
                'nav.rent': 'Location',
                'nav.developments': 'Projets',
                'nav.contact': 'Contact',
                'nav.bookVisit': 'Reserver visite',
                'footer.description': 'Plateforme immobiliere de luxe au Mexique, Colombie et Chili.',
                'footer.services': 'Services',
                'footer.company': 'Entreprise',
                'footer.legal': 'Mentions',
                'footer.press': 'Presse',
                'footer.blog': 'Blog',
                'footer.privacy': 'Confidentialite',
                'footer.terms': 'Conditions',
                'footer.cookies': 'Cookies',
                'footer.copy': 'Copyright',
                'footer.rights': 'Tous droits reserves.',
                'footer.hotline': 'APPELEZ-NOUS 24H'
            }
        };

        var PHRASE_TRANSLATIONS = {
            en: {
                'Sin conexion': 'Offline',
                'Volver al inicio': 'Back to home',
                'No hay red disponible en este momento. Puedes reintentar o volver al inicio cuando recuperes conexion.': 'No network is available right now. You can retry or return home once your connection is back.',
                'Todos los derechos reservados.': 'All rights reserved.',
                'LLAMANOS LAS 24 HORAS': 'CALL US 24 HOURS',
                'Inmobiliaria Premium': 'Strategic Real Estate Advisory',
                'Bienvenido': 'Investment-Grade Real Estate',
                'AGENDA UNA VISITA': 'SPEAK WITH AN ADVISOR',
                'VER PROPIEDADES': 'VIEW INVESTMENT PORTFOLIO',
                'VER PROPIEDAD': 'VIEW ASSET DETAILS',
                'Propiedades Disponibles': 'Available Investment Assets',
                'Propiedades en Venta': 'Properties for Sale',
                'Propiedades Premium en Venta': 'Premium Properties for Sale',
                'Filtrar': 'Apply Investment Filters',
                'Limpiar filtros': 'Clear filters',
                'Comparar': 'Compare',
                'Comparar (0/3)': 'Benchmark Assets (0/3)',
                'DESTACADO': 'FEATURED',
                'Ciudad': 'City',
                'Recamaras': 'Bedrooms',
                'Precio Min': 'Min Price',
                'Precio Max': 'Max Price',
                'Sin limite': 'No limit',
                'Todas': 'All',
                'Renta Premium': 'Premium Rentals',
                'Iniciar busqueda â†’': 'Start search â†’',
                'Precios dinamicos segun temporada': 'Dynamic pricing by season',
                'Solicita tu visita en 3 pasos': 'Request your visit in 3 steps',
                'Chat en tiempo real': 'Investor Desk in Real Time',
                'Enviar mensaje â†’': 'Start the conversation â†’',
                'Asesoria inmobiliaria en tiempo real': 'Real-time real estate guidance',
                'Como contactarnos': 'How to contact us',
                'Agentes especializados': 'Specialized agents',
                'Nuestras oficinas': 'Our offices',
                'Manifiesto': 'Manifesto',
                'Arquitectura de nueva generacion': 'Next-generation architecture',
                'Nuevos Desarrollos': 'New Developments',
                'Amenidades de clase mundial': 'World-class amenities',
                'Linea de tiempo': 'Timeline',
                'Inventario disponible': 'Available inventory',
                'Vista 360Â°': '360Â° View',
                'Siguiente â€º': 'Next â€º',
                'â€¹ Anterior': 'â€¹ Previous',
                'Curamos residencias, inversiÃ³n y experiencias inmobiliarias con criterio editorial, atenciÃ³n boutique y ejecuciÃ³n sin fricciÃ³n en cada etapa.': 'We curate residences, investments, and real estate experiences with an editorial mindset, boutique service, and frictionless execution at every stage.',
                'Nuestra ubicacion es una gran ventaja para inversion y estilo de vida.': 'Our location is a strategic advantage for both investment and lifestyle.',
                'Seleccion exclusiva en venta, renta y desarrollos con plusvalia.': 'Exclusive selection across sale, rental, and developments with strong appreciation potential.',
                'PROPIEDADES CON ACABADOS DE': 'PROPERTIES WITH PREMIUM FINISHES',
                'LUJO, SEGURIDAD Y PLUSVALIA': 'LUXURY, SECURITY, AND CAPITAL APPRECIATION',
                'No hay propiedades disponibles en este momento.': 'There are no properties available at this time.',
                'LA INVERSION IDEAL PARA TU PATRIMONIO': 'THE IDEAL INVESTMENT FOR YOUR LEGACY',
                'RESERVA UNA VISITA': 'BOOK A VISIT',
                'Conectate con nosotros': 'Follow HAVRE Market Intelligence',
                'Suscribirse': 'Investor Brief Subscription',
                'Suscribete para recibir noticias sobre propiedades, inversiones y eventos exclusivos.': 'Subscribe to receive market updates, portfolio opportunities, and executive briefings.',
                'OK - Suscripcion confirmada. Bienvenido a HAVRE ESTATES.': 'OK - Subscription confirmed. Welcome to HAVRE ESTATES.',
                'Correo electronico': 'Email address',
                'Registrarse': 'Subscribe to brief',
                'Sin spam Â· Cancela cuando quieras': 'No spam Â· Unsubscribe anytime',
                'Cargar mÃ¡s propiedades': 'Load more properties',
                'Sin resultados': 'No results',
                'Ajusta los filtros o limpia la bÃºsqueda.': 'Adjust filters or clear the search.',
                'VER DETALLES': 'VIEW INVESTMENT MEMO',
                'Simula tu': 'Estimate your',
                'Financiamiento': 'Financing',
                'Mensualidad estimada': 'Estimated monthly payment',
                'Renta mensual y vacacional en': 'Monthly and vacation rentals in',
                'Selecciona fechas, elige huÃ©spedes y reserva al instante.': 'Choose your dates, select guests, and book instantly.',
                'Tarifas que se ajustan a la temporada y al estilo de estancia': 'Rates that adapt to seasonality and your stay profile',
                'MantÃ©n claridad de precio en baja, media y alta temporada con una visual mÃ¡s alineada al tono premium del proyecto.': 'Keep pricing clear across low, mid, and high season with visuals aligned to the project premium tone.',
                'Coordina una visita privada con fechas y preferencias claras': 'Coordinate a private visit with clear dates and preferences',
                'Agenda el recorrido con una experiencia mÃ¡s directa y ordenada.': 'Schedule your tour through a more direct and structured experience.',
                'Experiencias incluidas en tu renta': 'Experiences included with your rental',
                'Sin propiedades disponibles': 'No properties available',
                'Chat SSE en vivo, red de agentes especializados y oficinas en 3 paÃ­ses. Sin tiempos de espera.': 'Live SSE chat, a specialized agent network, and offices across 3 countries. No waiting times.',
                'Creemos que cada hogar cuenta una historia.': 'We believe every home tells a story.',
                'Que una inversiÃ³n bien hecha transforma vidas.': 'That a well-executed investment transforms lives.',
                'Que la transparencia es la base de la confianza.': 'That transparency is the foundation of trust.',
                'Que el lujo es una experiencia, no solo un precio.': 'That luxury is an experience, not just a price point.',
                'Nos han mencionado en': 'Featured in',
                'Contacto': 'Contact',
                'Venta': 'Sale',
                'Renta': 'Rent',
                'Desarrollos': 'Developments',
                'Inicio': 'Home',
                'Servicios': 'Services',
                'Empresa': 'Company',
                'Legal': 'Legal',
                'Prensa': 'Press',
                'Privacidad': 'Privacy',
                'Terminos': 'Terms',
                'Cookies': 'Cookies',
                'Agendar Visita': 'Book Visit'
            },
            fr: {
                'Sin conexion': 'Hors ligne',
                'Volver al inicio': 'Retour a l accueil',
                'No hay red disponible en este momento. Puedes reintentar o volver al inicio cuando recuperes conexion.': 'Aucun reseau disponible pour le moment. Vous pouvez reessayer ou revenir a l accueil lorsque la connexion revient.',
                'Todos los derechos reservados.': 'Tous droits reserves.',
                'LLAMANOS LAS 24 HORAS': 'APPELEZ-NOUS 24H',
                'Inmobiliaria Premium': 'Conseil Immobilier Strategique',
                'Bienvenido': 'Immobilier d investissement haut de gamme',
                'AGENDA UNA VISITA': 'PARLER A UN CONSEILLER',
                'VER PROPIEDADES': 'VOIR LE PORTEFEUILLE D INVESTISSEMENT',
                'VER PROPIEDAD': 'VOIR LE DOSSIER DE L ACTIF',
                'Propiedades Disponibles': 'Actifs d investissement disponibles',
                'Propiedades en Venta': 'Proprietes a vendre',
                'Propiedades Premium en Venta': 'Proprietes premium a vendre',
                'Filtrar': 'Appliquer les filtres d investissement',
                'Limpiar filtros': 'Effacer les filtres',
                'Comparar': 'Comparer',
                'Comparar (0/3)': 'Comparer les actifs (0/3)',
                'DESTACADO': 'EN VEDETTE',
                'Ciudad': 'Ville',
                'Recamaras': 'Chambres',
                'Precio Min': 'Prix Min',
                'Precio Max': 'Prix Max',
                'Sin limite': 'Sans limite',
                'Todas': 'Toutes',
                'Renta Premium': 'Location Premium',
                'Iniciar busqueda â†’': 'Demarrer la recherche â†’',
                'Precios dinamicos segun temporada': 'Prix dynamiques selon la saison',
                'Solicita tu visita en 3 pasos': 'Demandez votre visite en 3 etapes',
                'Chat en tiempo real': 'Desk investisseurs en temps reel',
                'Enviar mensaje â†’': 'Demarrer la conversation â†’',
                'Asesoria inmobiliaria en tiempo real': 'Conseil immobilier en temps reel',
                'Como contactarnos': 'Comment nous contacter',
                'Agentes especializados': 'Agents specialises',
                'Nuestras oficinas': 'Nos bureaux',
                'Manifiesto': 'Manifeste',
                'Arquitectura de nueva generacion': 'Architecture de nouvelle generation',
                'Nuevos Desarrollos': 'Nouveaux Projets',
                'Amenidades de clase mundial': 'Equipements de classe mondiale',
                'Linea de tiempo': 'Chronologie',
                'Inventario disponible': 'Inventaire disponible',
                'Vista 360Â°': 'Vue 360Â°',
                'Siguiente â€º': 'Suivant â€º',
                'â€¹ Anterior': 'â€¹ Precedent',
                'Curamos residencias, inversiÃ³n y experiencias inmobiliarias con criterio editorial, atenciÃ³n boutique y ejecuciÃ³n sin fricciÃ³n en cada etapa.': 'Nous concevons des residences, des investissements et des experiences immobilieres avec une approche editoriale, un service boutique et une execution fluide a chaque etape.',
                'Nuestra ubicacion es una gran ventaja para inversion y estilo de vida.': 'Notre emplacement est un avantage strategique pour l investissement et le style de vie.',
                'Seleccion exclusiva en venta, renta y desarrollos con plusvalia.': 'Selection exclusive en vente, location et projets a forte valorisation.',
                'PROPIEDADES CON ACABADOS DE': 'PROPRIETES AUX FINITIONS PREMIUM',
                'LUJO, SEGURIDAD Y PLUSVALIA': 'LUXE, SECURITE ET VALORISATION',
                'No hay propiedades disponibles en este momento.': 'Aucune propriete disponible pour le moment.',
                'LA INVERSION IDEAL PARA TU PATRIMONIO': 'L INVESTISSEMENT IDEAL POUR VOTRE PATRIMOINE',
                'RESERVA UNA VISITA': 'RESERVER UNE VISITE',
                'Conectate con nosotros': 'Suivez l intelligence marche HAVRE',
                'Suscribirse': 'Abonnement Investor Brief',
                'Suscribete para recibir noticias sobre propiedades, inversiones y eventos exclusivos.': 'Abonnez-vous pour recevoir les tendances de marche, les opportunites de portefeuille et les notes executives.',
                'OK - Suscripcion confirmada. Bienvenido a HAVRE ESTATES.': 'OK - Abonnement confirme. Bienvenue chez HAVRE ESTATES.',
                'Correo electronico': 'Adresse e-mail',
                'Registrarse': 'S abonner au brief',
                'Sin spam Â· Cancela cuando quieras': 'Sans spam Â· Desabonnez-vous quand vous voulez',
                'Cargar mÃ¡s propiedades': 'Charger plus de proprietes',
                'Sin resultados': 'Aucun resultat',
                'Ajusta los filtros o limpia la bÃºsqueda.': 'Ajustez les filtres ou effacez la recherche.',
                'VER DETALLES': 'VOIR LA NOTE D INVESTISSEMENT',
                'Simula tu': 'Simulez votre',
                'Financiamiento': 'Financement',
                'Mensualidad estimada': 'Mensualite estimee',
                'Renta mensual y vacacional en': 'Location mensuelle et saisonniere en',
                'Selecciona fechas, elige huÃ©spedes y reserva al instante.': 'Choisissez vos dates, vos voyageurs et reservez instantanement.',
                'Tarifas que se ajustan a la temporada y al estilo de estancia': 'Des tarifs adaptes a la saison et au style de sejour',
                'MantÃ©n claridad de precio en baja, media y alta temporada con una visual mÃ¡s alineada al tono premium del proyecto.': 'Conservez une lecture claire des prix en basse, moyenne et haute saison avec une presentation alignee sur le ton premium du projet.',
                'Coordina una visita privada con fechas y preferencias claras': 'Organisez une visite privee avec des dates et des preferences claires',
                'Agenda el recorrido con una experiencia mÃ¡s directa y ordenada.': 'Planifiez la visite avec une experience plus directe et mieux structuree.',
                'Experiencias incluidas en tu renta': 'Experiences incluses dans votre location',
                'Sin propiedades disponibles': 'Aucune propriete disponible',
                'Chat SSE en vivo, red de agentes especializados y oficinas en 3 paÃ­ses. Sin tiempos de espera.': 'Chat SSE en direct, reseau d agents specialises et bureaux dans 3 pays. Sans attente.',
                'Creemos que cada hogar cuenta una historia.': 'Nous croyons que chaque maison raconte une histoire.',
                'Que una inversiÃ³n bien hecha transforma vidas.': 'Qu un investissement bien mene transforme des vies.',
                'Que la transparencia es la base de la confianza.': 'Que la transparence est la base de la confiance.',
                'Que el lujo es una experiencia, no solo un precio.': 'Que le luxe est une experience, pas seulement un prix.',
                'Nos han mencionado en': 'Ils parlent de nous dans',
                'Contacto': 'Contact',
                'Venta': 'Vente',
                'Renta': 'Location',
                'Desarrollos': 'Projets',
                'Inicio': 'Accueil',
                'Servicios': 'Services',
                'Empresa': 'Entreprise',
                'Legal': 'Mentions',
                'Prensa': 'Presse',
                'Privacidad': 'Confidentialite',
                'Terminos': 'Conditions',
                'Cookies': 'Cookies',
                'Agendar Visita': 'Reserver visite'
            }
        };

        var WORD_TRANSLATIONS = {
            en: {
                'inicio': 'home',
                'venta': 'sale',
                'renta': 'rent',
                'desarrollos': 'developments',
                'contacto': 'contact',
                'inmobiliaria': 'real estate',
                'premium': 'premium',
                'bienvenido': 'welcome',
                'ubicacion': 'location',
                'excepcional': 'exceptional',
                'corazon': 'heart',
                'planeando': 'planning',
                'invertir': 'invest',
                'bienes': 'real',
                'raices': 'estate',
                'plusvalia': 'appreciation',
                'seguridad': 'security',
                'lujo': 'luxury',
                'servicios': 'services',
                'empresa': 'company',
                'legal': 'legal',
                'prensa': 'press',
                'blog': 'blog',
                'privacidad': 'privacy',
                'terminos': 'terms',
                'terminos.': 'terms.',
                'cookies': 'cookies',
                'agendar': 'book',
                'visita': 'visit',
                'llamanos': 'call us',
                'llamanos las 24 horas': 'call us 24 hours',
                'todos': 'all',
                'derechos': 'rights',
                'reservados': 'reserved',
                'propiedades': 'properties',
                'propiedad': 'property',
                'disponibles': 'available',
                'destacado': 'featured',
                'filtros': 'filters',
                'filtrar': 'filter',
                'limpiar': 'clear',
                'comparar': 'compare',
                'resultado': 'result',
                'resultados': 'results',
                'ciudad': 'city',
                'precio': 'price',
                'min': 'min',
                'max': 'max',
                'minimo': 'minimum',
                'maximo': 'maximum',
                'habitaciones': 'bedrooms',
                'recamaras': 'bedrooms',
                'banos': 'bathrooms',
                'dormitorios': 'bedrooms',
                'baÃ±os': 'bathrooms',
                'hogar': 'home',
                'temporada': 'season',
                'temporadas': 'seasons',
                'reserva': 'booking',
                'visita': 'visit',
                'visitas': 'visits',
                'chat': 'chat',
                'tiempo': 'time',
                'real': 'real',
                'mensajes': 'messages',
                'enviar': 'send',
                'nombre': 'name',
                'correo': 'email',
                'mensaje': 'message',
                'oficinas': 'offices',
                'agentes': 'agents',
                'asesoria': 'advisory',
                'nuevos': 'new',
                'proxima': 'next',
                'entrega': 'delivery',
                'amenidades': 'amenities',
                'linea': 'line',
                'inventario': 'inventory',
                'disponible': 'available',
                'telefono': 'phone',
                'mexico': 'mexico',
                'colombia': 'colombia',
                'chile': 'chile'
            },
            fr: {
                'inicio': 'accueil',
                'venta': 'vente',
                'renta': 'location',
                'desarrollos': 'projets',
                'contacto': 'contact',
                'inmobiliaria': 'immobilier',
                'premium': 'premium',
                'bienvenido': 'bienvenue',
                'ubicacion': 'emplacement',
                'excepcional': 'exceptionnel',
                'corazon': 'coeur',
                'planeando': 'planifier',
                'invertir': 'investir',
                'bienes': 'biens',
                'raices': 'immobiliers',
                'plusvalia': 'plus-value',
                'seguridad': 'securite',
                'lujo': 'luxe',
                'servicios': 'services',
                'empresa': 'entreprise',
                'legal': 'mentions',
                'prensa': 'presse',
                'blog': 'blog',
                'privacidad': 'confidentialite',
                'terminos': 'conditions',
                'terminos.': 'conditions.',
                'cookies': 'cookies',
                'agendar': 'reserver',
                'visita': 'visite',
                'llamanos': 'appelez-nous',
                'llamanos las 24 horas': 'appelez-nous 24h',
                'todos': 'tous',
                'derechos': 'droits',
                'reservados': 'reserves',
                'propiedades': 'proprietes',
                'propiedad': 'propriete',
                'disponibles': 'disponibles',
                'destacado': 'vedette',
                'filtros': 'filtres',
                'filtrar': 'filtrer',
                'limpiar': 'effacer',
                'comparar': 'comparer',
                'resultado': 'resultat',
                'resultados': 'resultats',
                'ciudad': 'ville',
                'precio': 'prix',
                'min': 'min',
                'max': 'max',
                'minimo': 'minimum',
                'maximo': 'maximum',
                'habitaciones': 'chambres',
                'recamaras': 'chambres',
                'banos': 'salles de bain',
                'dormitorios': 'chambres',
                'baÃ±os': 'salles de bain',
                'hogar': 'foyer',
                'temporada': 'saison',
                'temporadas': 'saisons',
                'reserva': 'reservation',
                'visita': 'visite',
                'visitas': 'visites',
                'chat': 'chat',
                'tiempo': 'temps',
                'real': 'reel',
                'mensajes': 'messages',
                'enviar': 'envoyer',
                'nombre': 'nom',
                'correo': 'email',
                'mensaje': 'message',
                'oficinas': 'bureaux',
                'agentes': 'agents',
                'asesoria': 'conseil',
                'nuevos': 'nouveaux',
                'proxima': 'prochaine',
                'entrega': 'livraison',
                'amenidades': 'equipements',
                'linea': 'ligne',
                'inventario': 'inventaire',
                'disponible': 'disponible',
                'telefono': 'telephone',
                'mexico': 'mexique',
                'colombia': 'colombie',
                'chile': 'chili'
            }
        };

        var CURATED_SELECTOR_TRANSLATIONS = {
            en: [
                { selector: '#filtros label[for="f_city"]', text: 'City' },
                { selector: '#filtros label[for="f_beds"]', text: 'Bedrooms' },
                { selector: '#filtros label[for="f_pmin"]', text: 'Min Price' },
                { selector: '#filtros label[for="f_pmax"]', text: 'Max Price' },
                { selector: '#filtros label[for="f_sqm"]', text: 'Min mÂ²' },
                { selector: '#filtros input[name="city"]', attr: 'placeholder', text: 'CDMX, Bogotaâ€¦' },
                { selector: '#filtros input[name="price_max"]', attr: 'placeholder', text: 'No limit' },
                { selector: '#filtros button[type="submit"]', text: 'Apply portfolio filters' },
                { selector: '#toggleCompare', text: 'Benchmark assets (0/3)' },
                { selector: '#listado h2', text: 'Available investment assets' },
                { selector: '#chat-section h2', text: 'Investor desk live' },
                { selector: '#chatForm label[for="chatName"]', text: 'Your name' },
                { selector: '#chatForm label[for="chatMessage"]', text: 'Message' },
                { selector: '#chatName', attr: 'placeholder', text: 'Ana Garcia' },
                { selector: '#chatMessage', attr: 'placeholder', text: 'Write your questionâ€¦' },
                { selector: '#chatForm button[type="submit"]', text: 'Request advisory â†’' },
                { selector: '#multistep h2', text: 'Schedule a private review in 3 steps' },
                { selector: '#temporadas h2', text: 'Dynamic pricing by season' },
                { selector: '#countdown h2', text: 'Insignia Tower â€” Estimated delivery' },
                { selector: '#masterplan h2', text: 'Interactive master plan with investment inventory' },
                { selector: '#amenidades h2', text: 'World-class amenities' },
                { selector: '#agentes h2', text: 'Specialized agents' },
                { selector: '#mapa-oficinas h2', text: 'Our offices' },
                { selector: '#homeHeroTitle', html: '<span class="anim-word" style="animation-delay:0.16s;">Welcome</span> <span class="anim-word" style="animation-delay:0.24s;">to</span><br><span class="anim-word text-gold" style="animation-delay:0.34s;">HAVRE</span> <span class="anim-word" style="animation-delay:0.42s;">ESTATES</span>' },
                { selector: '#homeHeroDescription', text: 'We curate residences, investment, and real estate experiences with editorial criteria, boutique attention, and frictionless execution at every stage.' },
                { selector: '#ventaHeroKicker', text: '01 · Properties for Sale' },
                { selector: '#ventaHeroTitle', html: '<span class="anim-word" style="animation-delay:0.18s;">Properties</span><br><span class="anim-word text-gold italic" style="animation-delay:0.3s;">Premium</span> <span class="anim-word" style="animation-delay:0.4s;">for Sale</span>' },
                { selector: '#ventaHeroDescription', text: 'Exclusive selection of homes, penthouses and high-yield developments.' },
                { selector: '#rentaHeroKicker', text: '01 · Premium Rentals' },
                { selector: '#rentaHeroTitle', html: '<span class="anim-word" style="animation-delay:0.18s;">Your next</span> <span class="anim-word" style="animation-delay:0.26s;">home,</span><br><span class="anim-word text-gold italic" style="animation-delay:0.46s;">no commitment</span>' },
                { selector: '#rentaHeroDescription', text: 'Monthly and vacation rentals. Select dates, choose guests and book instantly.' },
                { selector: '#desarrollosHeroKicker', text: '01 · New Developments' },
                { selector: '#desarrollosHeroTitle', html: '<span class="anim-word" style="animation-delay:0.18s;">Architecture</span> <span class="anim-word" style="animation-delay:0.28s;">of</span> <span class="anim-word text-gold italic" style="animation-delay:0.4s;">new</span><br><span class="anim-word text-gold italic" style="animation-delay:0.52s;">generation</span>' },
                { selector: '#desarrollosHeroDescription', text: 'Pre-sale, construction and delivery. Interactive floor plan, countdown and investment interest form.' },
                { selector: '#contactoHeroKicker', text: '01 · Contact Advisory' },
                { selector: '#contactoHeroTitle', html: '<span class="anim-word" style="animation-delay:0.18s;">Real Estate</span> <span class="anim-word" style="animation-delay:0.28s;">Advisory</span><br><span class="anim-word text-gold italic" style="animation-delay:0.42s;">in Real Time</span>' },
                { selector: '#contactoHeroDescription', text: 'Consultative support, specialized agents, and offices in 3 countries to accelerate every decision.' }
            ],
            fr: [
                { selector: '#filtros label[for="f_city"]', text: 'Ville' },
                { selector: '#filtros label[for="f_beds"]', text: 'Chambres' },
                { selector: '#filtros label[for="f_pmin"]', text: 'Prix Min' },
                { selector: '#filtros label[for="f_pmax"]', text: 'Prix Max' },
                { selector: '#filtros label[for="f_sqm"]', text: 'mÂ² Min' },
                { selector: '#filtros input[name="city"]', attr: 'placeholder', text: 'CDMX, Bogotaâ€¦' },
                { selector: '#filtros input[name="price_max"]', attr: 'placeholder', text: 'Sans limite' },
                { selector: '#filtros button[type="submit"]', text: 'Appliquer les filtres portefeuille' },
                { selector: '#toggleCompare', text: 'Comparer les actifs (0/3)' },
                { selector: '#listado h2', text: 'Actifs d investissement disponibles' },
                { selector: '#chat-section h2', text: 'Desk investisseurs en direct' },
                { selector: '#chatForm label[for="chatName"]', text: 'Votre nom' },
                { selector: '#chatForm label[for="chatMessage"]', text: 'Message' },
                { selector: '#chatName', attr: 'placeholder', text: 'Ana Garcia' },
                { selector: '#chatMessage', attr: 'placeholder', text: 'Ecrivez votre demandeâ€¦' },
                { selector: '#chatForm button[type="submit"]', text: 'Demander un conseil â†’' },
                { selector: '#multistep h2', text: 'Planifier une revue privee en 3 etapes' },
                { selector: '#temporadas h2', text: 'Prix dynamiques selon la saison' },
                { selector: '#countdown h2', text: 'Tour Insignia â€” Livraison estimee' },
                { selector: '#masterplan h2', text: 'Plan interactif avec inventaire d investissement' },
                { selector: '#amenidades h2', text: 'Equipements de classe mondiale' },
                { selector: '#agentes h2', text: 'Agents specialises' },
                { selector: '#mapa-oficinas h2', text: 'Nos bureaux' },
                { selector: '#homeHeroTitle', html: '<span class="anim-word" style="animation-delay:0.16s;">Bienvenue</span> <span class="anim-word" style="animation-delay:0.24s;">chez</span><br><span class="anim-word text-gold" style="animation-delay:0.34s;">HAVRE</span> <span class="anim-word" style="animation-delay:0.42s;">ESTATES</span>' },
                { selector: '#homeHeroDescription', text: 'Nous selectionnons residences, investissements et experiences immobilieres avec un regard editorial, une attention boutique et une execution sans friction.' },
                { selector: '#ventaHeroKicker', text: '01 \u00b7 Proprietes a la Vente' },
                { selector: '#ventaHeroTitle', html: '<span class="anim-word" style="animation-delay:0.18s;">Proprietes</span><br><span class="anim-word text-gold italic" style="animation-delay:0.3s;">Premium</span> <span class="anim-word" style="animation-delay:0.4s;">a la Vente</span>' },
                { selector: '#ventaHeroDescription', text: 'Selection exclusive de residences, penthouses et projets a haute plus-value.' },
                { selector: '#rentaHeroKicker', text: '01 \u00b7 Locations Premium' },
                { selector: '#rentaHeroTitle', html: '<span class="anim-word" style="animation-delay:0.18s;">Votre prochain</span> <span class="anim-word" style="animation-delay:0.26s;">logement,</span><br><span class="anim-word text-gold italic" style="animation-delay:0.46s;">sans engagement</span>' },
                { selector: '#rentaHeroDescription', text: 'Locations mensuelles et vacances. Selectionnez les dates, choisissez les hotes et reservez.' },
                { selector: '#desarrollosHeroKicker', text: '01 \u00b7 Nouveaux Projets' },
                { selector: '#desarrollosHeroTitle', html: '<span class="anim-word" style="animation-delay:0.18s;">Architecture</span> <span class="anim-word" style="animation-delay:0.28s;">de</span> <span class="anim-word text-gold italic" style="animation-delay:0.4s;">nouvelle</span><br><span class="anim-word text-gold italic" style="animation-delay:0.52s;">generation</span>' },
                { selector: '#desarrollosHeroDescription', text: 'Pre-vente, construction et livraison. Plan interactif, compte a rebours et formulaire d\'interet.' },
                { selector: '#contactoHeroKicker', text: '01 \u00b7 Conseil Contact' },
                { selector: '#contactoHeroTitle', html: '<span class="anim-word" style="animation-delay:0.18s;">Conseil</span> <span class="anim-word" style="animation-delay:0.28s;">Immobilier</span><br><span class="anim-word text-gold italic" style="animation-delay:0.42s;">en Temps Reel</span>' },
                { selector: '#contactoHeroDescription', text: 'Accompagnement consultatif, reseau d\'agents specialises et bureaux dans 3 pays pour accelerer chaque decision.' }
            ]
        };

        var STORAGE_KEY = 'havre.lang';
        var SYNC_CHANNEL_NAME = 'havre-lang-sync';
        var currentLang = 'es';
        var textNodeBase = new WeakMap();
        var syncChannel = null;
        var ATTRS = ['placeholder', 'title', 'aria-label', 'alt'];

        if ('BroadcastChannel' in window) {
            syncChannel = new BroadcastChannel(SYNC_CHANNEL_NAME);
        }

        function preserveCase(source, target) {
            if (!source || !target) return target;

            if (source === source.toUpperCase()) {
                return target.toUpperCase();
            }

            var startsUpper = source.charAt(0) === source.charAt(0).toUpperCase();
            if (startsUpper) {
                return target.charAt(0).toUpperCase() + target.slice(1);
            }

            return target;
        }

        function translateText(rawText, lang) {
            if (!rawText || lang === 'es') {
                return rawText;
            }

            var exactMap = PHRASE_TRANSLATIONS[lang] || {};
            if (Object.prototype.hasOwnProperty.call(exactMap, rawText)) {
                return exactMap[rawText];
            }

            var trimmed = rawText.trim();
            if (!trimmed) {
                return rawText;
            }

            if (Object.prototype.hasOwnProperty.call(exactMap, trimmed)) {
                return rawText.replace(trimmed, exactMap[trimmed]);
            }

            var wordMap = WORD_TRANSLATIONS[lang] || {};
            return rawText.replace(/[A-Za-zÃÃ‰ÃÃ“ÃšÃœÃ‘Ã¡Ã©Ã­Ã³ÃºÃ¼Ã±]+/g, function (token) {
                var normalized = token
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase();
                var translated = wordMap[normalized];

                if (!translated) {
                    return token;
                }

                return preserveCase(token, translated);
            });
        }

        function shouldSkipNode(node) {
            var parent = node.parentElement;
            if (!parent) return true;

            var tag = parent.tagName;
            if (tag === 'SCRIPT' || tag === 'STYLE' || tag === 'NOSCRIPT' || tag === 'CODE' || tag === 'PRE' || tag === 'TEXTAREA') {
                return true;
            }

            if (parent.closest('[data-i18n-skip="true"]')) {
                return true;
            }

            return false;
        }

        function setActiveButtons(lang) {
            document.querySelectorAll('[data-lang-switch]').forEach(function (btn) {
                var isActive = btn.getAttribute('data-lang-switch') === lang;
                btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                btn.classList.toggle('text-gold', isActive);
                btn.classList.toggle('bg-gold/15', isActive);
                btn.classList.toggle('text-paper/50', !isActive);
            });
        }

        function translateTokenElements(lang) {
            var map = TOKEN_TRANSLATIONS[lang] || TOKEN_TRANSLATIONS.es;
            document.querySelectorAll('[data-i18n]').forEach(function (el) {
                var token = el.getAttribute('data-i18n');
                if (token && map[token]) {
                    el.textContent = map[token];
                }
            });
        }

        function translateAttributes(lang, root) {
            var container = root || document;
            var selector = '[placeholder], [title], [aria-label], img[alt], input[type="button"], input[type="submit"], input[type="reset"], button[value]';

            container.querySelectorAll(selector).forEach(function (el) {
                ATTRS.forEach(function (attr) {
                    if (!el.hasAttribute(attr)) return;

                    var baseAttrName = 'data-i18n-base-' + attr;
                    if (!el.hasAttribute(baseAttrName)) {
                        el.setAttribute(baseAttrName, el.getAttribute(attr));
                    }

                    var baseValue = el.getAttribute(baseAttrName) || '';
                    el.setAttribute(attr, translateText(baseValue, lang));
                });

                if (el.hasAttribute('value')) {
                    var type = (el.getAttribute('type') || '').toLowerCase();
                    if (type === 'button' || type === 'submit' || type === 'reset' || el.tagName === 'BUTTON') {
                        if (!el.hasAttribute('data-i18n-base-value')) {
                            el.setAttribute('data-i18n-base-value', el.getAttribute('value'));
                        }

                        var baseValue = el.getAttribute('data-i18n-base-value') || '';
                        el.setAttribute('value', translateText(baseValue, lang));
                    }
                }
            });
        }

        function translateTextNodes(lang, root) {
            var container = root || document.body;
            if (!container) return;

            var walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, null);
            var node;

            while ((node = walker.nextNode())) {
                if (shouldSkipNode(node)) {
                    continue;
                }

                if (!textNodeBase.has(node)) {
                    textNodeBase.set(node, node.nodeValue);
                }

                var base = textNodeBase.get(node);
                node.nodeValue = translateText(base, lang);
            }
        }

        function getScopedElements(scope, selector) {
            var list = [];
            if (scope === document) {
                return Array.from(document.querySelectorAll(selector));
            }

            if (scope.matches && scope.matches(selector)) {
                list.push(scope);
            }

            return list.concat(Array.from(scope.querySelectorAll(selector)));
        }

        function applyCuratedSelectorTranslations(lang, root) {
            var scope = root || document;
            var entries = CURATED_SELECTOR_TRANSLATIONS[lang] || [];

            if (lang === 'es') {
                var resetSelector = '[data-i18n-curated-base-text], [data-i18n-curated-base-html], [data-i18n-curated-base-placeholder], [data-i18n-curated-base-title], [data-i18n-curated-base-aria-label], [data-i18n-curated-base-alt]';
                getScopedElements(scope, resetSelector).forEach(function (el) {
                    var baseHtml = el.getAttribute('data-i18n-curated-base-html');
                    if (baseHtml !== null) {
                        el.innerHTML = baseHtml;
                    }
                    var baseText = el.getAttribute('data-i18n-curated-base-text');
                    if (baseText !== null) {
                        el.textContent = baseText;
                    }

                    ATTRS.forEach(function (attr) {
                        var baseAttr = el.getAttribute('data-i18n-curated-base-' + attr);
                        if (baseAttr !== null) {
                            el.setAttribute(attr, baseAttr);
                        }
                    });
                });
                return;
            }

            entries.forEach(function (entry) {
                getScopedElements(scope, entry.selector).forEach(function (el) {
                    if (!entry.attr) {
                        if (entry.html) {
                            if (!el.hasAttribute('data-i18n-curated-base-html')) {
                                el.setAttribute('data-i18n-curated-base-html', el.innerHTML);
                            }
                            el.innerHTML = entry.html;
                        } else {
                            if (!el.hasAttribute('data-i18n-curated-base-text')) {
                                el.setAttribute('data-i18n-curated-base-text', el.textContent);
                            }
                            el.textContent = entry.text;
                        }
                        return;
                    }

                    if (!el.hasAttribute('data-i18n-curated-base-' + entry.attr)) {
                        el.setAttribute('data-i18n-curated-base-' + entry.attr, el.getAttribute(entry.attr) || '');
                    }
                    el.setAttribute(entry.attr, entry.text);
                });
            });
        }

        function applyLanguage(lang, options) {
            options = options || {};

            if (!TOKEN_TRANSLATIONS[lang]) {
                lang = 'es';
            }

            currentLang = lang;
            document.documentElement.lang = lang;

            translateTokenElements(lang);
            translateAttributes(lang);
            translateTextNodes(lang);
            applyCuratedSelectorTranslations(lang);
            setActiveButtons(lang);

            if (!options.skipPersist) {
                localStorage.setItem(STORAGE_KEY, lang);
            }

            if (!options.skipBroadcast && syncChannel) {
                syncChannel.postMessage({ lang: lang });
            }
        }

        function detectBrowserLanguage() {
            var lang = (navigator.language || navigator.userLanguage || 'es').toLowerCase();
            if (lang.indexOf('fr') === 0) return 'fr';
            if (lang.indexOf('en') === 0) return 'en';
            return 'es';
        }

        function bootTranslationObserver() {
            if (!window.MutationObserver || !document.body) {
                return;
            }

            var observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    mutation.addedNodes.forEach(function (added) {
                        if (added.nodeType === Node.TEXT_NODE) {
                            if (shouldSkipNode(added)) {
                                return;
                            }

                            if (!textNodeBase.has(added)) {
                                textNodeBase.set(added, added.nodeValue);
                            }

                            added.nodeValue = translateText(textNodeBase.get(added), currentLang);
                            return;
                        }

                        if (added.nodeType === Node.ELEMENT_NODE) {
                            translateAttributes(currentLang, added);
                            translateTextNodes(currentLang, added);
                            applyCuratedSelectorTranslations(currentLang, added);
                        }
                    });
                });
            });

            observer.observe(document.body, { childList: true, subtree: true });
        }

        var saved = localStorage.getItem(STORAGE_KEY);
        var initialLang = saved || detectBrowserLanguage();
        applyLanguage(initialLang, { skipBroadcast: true });
        bootTranslationObserver();

        document.querySelectorAll('[data-lang-switch]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var lang = btn.getAttribute('data-lang-switch') || 'es';
                applyLanguage(lang);
            });
        });

        window.addEventListener('storage', function (event) {
            if (event.key !== STORAGE_KEY || !event.newValue || event.newValue === currentLang) {
                return;
            }

            applyLanguage(event.newValue, { skipPersist: true, skipBroadcast: true });
        });

        if (syncChannel) {
            syncChannel.addEventListener('message', function (event) {
                var payload = event.data || {};
                if (!payload.lang || payload.lang === currentLang) {
                    return;
                }

                applyLanguage(payload.lang, { skipPersist: false, skipBroadcast: true });
            });
        }
    })();
    </script>

    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js').catch(function (error) {
                console.warn('SW registration failed', error);
            });
        });
    }
    </script>

</body>
</html>

