<!DOCTYPE html>
<?php
$mainJsAsset = '/assets/main.js';
$mainCssAssets = [];
$manifestPath = ROOT_PATH . '/public/assets/.vite/manifest.json';

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
    
    <?php foreach ($mainCssAssets as $cssAsset): ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($cssAsset); ?>">
    <?php endforeach; ?>

    <script type="module" src="<?php echo htmlspecialchars($mainJsAsset); ?>"></script>
</head>
<body class="font-sans bg-paper text-ink">
    <!-- Navigation -->
    <nav class="bg-ink text-paper py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <h1 class="text-2xl font-serif font-bold">
                <a href="/">HAVRE ESTATES</a>
            </h1>
            <ul class="flex gap-8">
                <li><a href="/" class="hover:text-gold transition">Home</a></li>
                <li><a href="/venta" class="hover:text-gold transition">Venta</a></li>
                <li><a href="/renta" class="hover:text-gold transition">Renta</a></li>
                <li><a href="/desarrollos" class="hover:text-gold transition">Desarrollos</a></li>
                <li><a href="/contacto" class="hover:text-gold transition">Contacto</a></li>
            </ul>
            <span class="text-sm text-gold"><?php echo $country ?? 'MX'; ?> · <?php echo $currency ?? 'MXN'; ?></span>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-ink text-muted py-8 border-t-4 border-gold">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-paper font-serif font-bold mb-4">HAVRE ESTATES</h3>
                    <p class="text-sm">Plataforma inmobiliaria de lujo en 3 países.</p>
                </div>
                <div>
                    <h4 class="text-paper font-mono text-sm font-bold mb-4 uppercase">SERVICIOS</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="/venta" class="hover:text-gold">Venta</a></li>
                        <li><a href="/renta" class="hover:text-gold">Renta</a></li>
                        <li><a href="/desarrollos" class="hover:text-gold">Desarrollos</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-paper font-mono text-sm font-bold mb-4 uppercase">EMPRESA</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="/contacto" class="hover:text-gold">Contacto</a></li>
                        <li><a href="#" class="hover:text-gold">Prensa</a></li>
                        <li><a href="#" class="hover:text-gold">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-paper font-mono text-sm font-bold mb-4 uppercase">LEGAL</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-gold">Privacidad</a></li>
                        <li><a href="#" class="hover:text-gold">Términos</a></li>
                        <li><a href="#" class="hover:text-gold">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-rule pt-8 text-center">
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
