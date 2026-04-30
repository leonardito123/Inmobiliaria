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

    <script type="module" src="<?php echo htmlspecialchars($mainJsAsset); ?>"></script>
</head>
<body class="font-sans bg-paper text-ink">
    <!-- Navigation -->
    <nav class="bg-ink text-paper py-5 sticky top-0 z-50 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-8 lg:px-16 flex items-center justify-between">
            <a href="/" class="text-xl font-serif font-black tracking-[0.08em] uppercase hover:text-gold transition-colors duration-200">
                HAVRE<span class="text-gold">·</span>ESTATES
            </a>
            <ul class="hidden md:flex gap-8 items-center">
                <li><a href="/" class="text-sm font-mono tracking-[0.12em] uppercase text-paper/70 hover:text-gold transition-colors duration-200">Home</a></li>
                <li><a href="/venta" class="text-sm font-mono tracking-[0.12em] uppercase text-paper/70 hover:text-gold transition-colors duration-200">Venta</a></li>
                <li><a href="/renta" class="text-sm font-mono tracking-[0.12em] uppercase text-paper/70 hover:text-gold transition-colors duration-200">Renta</a></li>
                <li><a href="/desarrollos" class="text-sm font-mono tracking-[0.12em] uppercase text-paper/70 hover:text-gold transition-colors duration-200">Desarrollos</a></li>
                <li><a href="/contacto" class="text-sm font-mono tracking-[0.12em] uppercase text-paper/70 hover:text-gold transition-colors duration-200">Contacto</a></li>
            </ul>
            <span class="text-xs font-mono text-gold/70 tracking-[0.2em]"><?php echo $country ?? 'MX'; ?>&nbsp;·&nbsp;<?php echo $currency ?? 'MXN'; ?></span>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-ink text-muted border-t border-white/10">
        <div class="max-w-7xl mx-auto px-8 lg:px-16">
            <!-- Top grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-10 py-16">
                <div class="col-span-2 lg:col-span-1">
                    <p class="text-xl font-serif font-black tracking-[0.08em] uppercase text-paper mb-4">HAVRE<span class="text-gold">·</span>ESTATES</p>
                    <p class="text-sm leading-relaxed text-paper/40">Plataforma inmobiliaria de lujo en México, Colombia y Chile.</p>
                </div>
                <div>
                    <h4 class="text-paper/60 font-mono text-[11px] tracking-[0.3em] uppercase mb-5">Servicios</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/venta" class="text-paper/40 hover:text-gold transition-colors">Venta</a></li>
                        <li><a href="/renta" class="text-paper/40 hover:text-gold transition-colors">Renta</a></li>
                        <li><a href="/desarrollos" class="text-paper/40 hover:text-gold transition-colors">Desarrollos</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-paper/60 font-mono text-[11px] tracking-[0.3em] uppercase mb-5">Empresa</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/contacto" class="text-paper/40 hover:text-gold transition-colors">Contacto</a></li>
                        <li><a href="#" class="text-paper/40 hover:text-gold transition-colors">Prensa</a></li>
                        <li><a href="#" class="text-paper/40 hover:text-gold transition-colors">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-paper/60 font-mono text-[11px] tracking-[0.3em] uppercase mb-5">Legal</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-paper/40 hover:text-gold transition-colors">Privacidad</a></li>
                        <li><a href="#" class="text-paper/40 hover:text-gold transition-colors">Términos</a></li>
                        <li><a href="#" class="text-paper/40 hover:text-gold transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <!-- Bottom bar -->
            <div class="border-t border-white/8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs">© 2026 HAVRE ESTATES. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JSON-LD Schema -->
    <?php echo $seo_json_ld ?? ''; ?>

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
