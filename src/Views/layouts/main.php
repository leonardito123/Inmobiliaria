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

    <script type="module" src="<?php echo htmlspecialchars($mainJsAsset); ?>"></script>
</head>
<body class="font-sans bg-ink text-paper">

    <!-- ── TOP INFO BAR ─────────────────────────────────────────── -->
    <div class="bg-black text-paper/60 text-xs font-mono tracking-[0.15em] py-2 text-center border-b border-white/5">
        <span>Paseo de la Reforma 24, Col. Juárez, CDMX, C.P. 06600</span>
        <span class="mx-4 text-white/20">|</span>
        <a href="tel:+525541698259" class="hover:text-gold transition-colors">(52) 55 4169 8259</a>
    </div>

    <!-- ── NAVIGATION ────────────────────────────────────────────── -->
    <nav id="mainNav" class="bg-ink backdrop-blur-sm text-paper py-4 sticky top-0 z-50 border-b border-white/8 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-16 flex items-center gap-8">

            <!-- Logo — extremo izquierdo -->
            <a href="/" class="text-lg font-serif font-black tracking-[0.1em] uppercase hover:text-gold transition-colors flex-shrink-0">
                HAVRE<span class="text-gold">·</span>ESTATES
            </a>

            <!-- Links centrados — ocupa el espacio restante -->
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
                    <span class="text-paper/20 text-[10px] select-none" aria-hidden="true">·</span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>

            <!-- Derecha: selector idioma + CTA — extremo derecho -->
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

    <!-- ── FOOTER ───────────────────────────────────────────────── -->
    <footer class="bg-black text-paper/50">
        <!-- Links grid — 5 columnas horizontales, bien distribuidas -->
        <div class="max-w-7xl mx-auto px-8 lg:px-16 py-10 border-b border-white/8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">

                <!-- Marca (col más ancha) -->
                <div class="lg:col-span-2">
                    <p class="font-serif font-black text-paper tracking-[0.08em] uppercase text-[15px] mb-3">HAVRE<span class="text-gold">·</span>ESTATES</p>
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
            <p><span data-i18n="footer.copy">Copyright</span> © <?php echo date('Y'); ?> HAVRE ESTATES — <span data-i18n="footer.rights">Todos los derechos reservados.</span></p>
            <p><span data-i18n="footer.hotline">LLAMANOS LAS 24 HORAS</span> &nbsp;·&nbsp; (52) 55 4169 8259</p>
        </div>
    </footer>

    <!-- JSON-LD Schema -->
    <?php echo $seo_json_ld ?? ''; ?>

    <script>
    (function () {
        var i18n = {
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

        var key = 'havre.lang';

        function setActiveButtons(lang) {
            document.querySelectorAll('[data-lang-switch]').forEach(function (btn) {
                var isActive = btn.getAttribute('data-lang-switch') === lang;
                btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                // active: gold text + subtle gold bg; inactive: muted
                btn.classList.toggle('text-gold',     isActive);
                btn.classList.toggle('bg-gold/15',    isActive);
                btn.classList.toggle('text-paper/50', !isActive);
            });
        }

        function applyLanguage(lang) {
            if (!i18n[lang]) lang = 'es';
            document.documentElement.lang = lang;
            document.querySelectorAll('[data-i18n]').forEach(function (el) {
                var token = el.getAttribute('data-i18n');
                if (i18n[lang][token]) {
                    el.textContent = i18n[lang][token];
                }
            });
            localStorage.setItem(key, lang);
            setActiveButtons(lang);
        }

        function detectBrowserLanguage() {
            var lang = (navigator.language || navigator.userLanguage || 'es').toLowerCase();
            if (lang.indexOf('fr') === 0) return 'fr';
            if (lang.indexOf('en') === 0) return 'en';
            return 'es';
        }

        var saved = localStorage.getItem(key);
        var initialLang = saved || detectBrowserLanguage();
        applyLanguage(initialLang);

        document.querySelectorAll('[data-lang-switch]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                applyLanguage(btn.getAttribute('data-lang-switch'));
            });
        });
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
