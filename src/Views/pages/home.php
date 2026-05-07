<?php
/**
 * Home Landing Page
 * Variables:
 * - $country, $currency, $phone
 * - $featured_properties
 * - $newsletter_csrf_token, $newsletter_status
 */
$countryName = match($country ?? 'MX') {
    'CO' => 'Colombia',
    'CL' => 'Chile',
    default => 'Mexico',
};
$countryCode = strtoupper((string)($country ?? 'MX'));
?>

<section class="relative h-[100dvh] min-h-[580px] overflow-hidden bg-ink text-paper" aria-label="Hero principal"
         data-geo-country="<?php echo htmlspecialchars($country ?? 'MX'); ?>">
    <div id="heroCarousel" class="absolute inset-0">
        <?php
        $heroSlides = [
            ['image' => '/images/hero/cdmx-hero-1.jpg', 'alt' => 'Skyline premium en Mexico City', 'overlay' => 'from-black/80 via-black/50 to-black/75', 'accent' => 'bg-amber-900/25'],
            ['image' => '/images/hero/cdmx-hero-2.jpg', 'alt' => 'Arquitectura moderna para inversion', 'overlay' => 'from-black/75 via-[#0a1a2a]/45 to-black/78', 'accent' => 'bg-blue-900/25'],
            ['image' => '/images/hero/cdmx-hero-3.jpg', 'alt' => 'Vista urbana nocturna', 'overlay' => 'from-black/82 via-black/55 to-black/80', 'accent' => 'bg-yellow-900/20'],
            ['image' => '/images/hero/cdmx-hero-4.jpg', 'alt' => 'Ciudad y desarrollos premium', 'overlay' => 'from-black/78 via-[#150a1a]/45 to-black/76', 'accent' => 'bg-purple-900/15'],
        ];
        foreach ($heroSlides as $si => $slide):
        ?>
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 <?php echo $si === 0 ? 'opacity-100' : 'opacity-0'; ?>"
             role="group" aria-roledescription="slide" aria-label="Imagen <?php echo $si + 1; ?> de <?php echo count($heroSlides); ?>">
            <img src="<?php echo htmlspecialchars($slide['image']); ?>"
                 alt="<?php echo htmlspecialchars($slide['alt']); ?>"
                 class="absolute inset-0 w-full h-full object-cover"
                 loading="<?php echo $si === 0 ? 'eager' : 'lazy'; ?>"
                 decoding="async">
            <div class="absolute inset-0 bg-gradient-to-br <?php echo $slide['overlay']; ?>"></div>
            <div class="absolute top-0 right-0 w-1/2 h-2/3 <?php echo $slide['accent']; ?> rounded-full blur-[150px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-1/3 h-1/2 bg-gold/8 rounded-full blur-[100px] pointer-events-none"></div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
        <p class="font-mono text-[11px] md:text-xs tracking-[0.22em] uppercase text-gold/90 mb-8 flex items-center gap-3 anim-copy" style="animation-delay:0.1s;">
            <span>Inmobiliaria Premium</span>
            <span class="text-gold/60" aria-hidden="true">·</span>
            <span class="inline-flex items-center rounded-full border border-gold/45 bg-black/30 px-3 py-1 text-paper tracking-[0.12em]">
                <?php echo htmlspecialchars($countryCode); ?> · <?php echo htmlspecialchars($countryName); ?>
            </span>
        </p>

        <h1 class="font-serif font-black leading-[0.94] mb-6 max-w-4xl"
            style="font-size:clamp(3rem,7vw,6rem);text-shadow:0 10px 35px rgba(0,0,0,.75);">
            <span class="anim-word" style="animation-delay:0.16s;">Bienvenido</span>
            <span class="anim-word" style="animation-delay:0.24s;">a</span><br>
            <span class="anim-word text-gold" style="animation-delay:0.34s;">HAVRE</span>
            <span class="anim-word" style="animation-delay:0.42s;">ESTATES</span>
        </h1>

        <div class="w-24 h-px bg-gold mb-8 anim-copy" style="animation-delay:0.5s;" aria-hidden="true"></div>

        <a href="/contacto"
           class="inline-flex items-center gap-3 px-10 py-4 border border-paper/50 text-paper text-[11px] font-mono tracking-[0.35em] uppercase hover:bg-paper hover:text-ink transition-all duration-300 mb-10 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold anim-copy"
           style="animation-delay:0.62s;">
            AGENDA UNA VISITA
        </a>

        <a href="tel:<?php echo preg_replace('/\s+/', '', $phone ?? '+525541698259'); ?>"
           class="text-paper/60 font-mono text-sm tracking-[0.2em] hover:text-gold transition-colors">
            <?php echo htmlspecialchars($phone ?? '+52 55 4169 8259'); ?>
        </a>
    </div>

</section>

<section class="py-24 bg-ink text-paper" aria-label="Descripcion de la inmobiliaria">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-20">
            <div class="aspect-[4/3] border border-white/8 overflow-hidden">
                <img src="/images/properties/penthouse-reforma-mx.jpg" alt="Propiedades de lujo"
                     class="w-full h-full object-cover opacity-85" loading="lazy"
                     onerror="this.src='/images/properties/penthouse-reforma-mx.svg'">
            </div>
            <div>
                <h2 class="font-serif font-black uppercase tracking-[0.04em] leading-tight mb-6" style="font-size: clamp(1.6rem, 3.5vw, 2.8rem);">
                    UBICACION EXCEPCIONAL<br>
                    <span class="text-gold">EN EL CORAZON DE <?php echo mb_strtoupper(htmlspecialchars($countryName)); ?></span>
                </h2>
                <div class="w-14 h-px bg-gold mb-6" aria-hidden="true"></div>
                <p class="text-paper/60 leading-relaxed mb-8 max-w-md">
                    Nuestra ubicacion es una gran ventaja para inversion y estilo de vida.
                </p>
                <ul class="space-y-3">
                    <?php
                    $locationBullets = match($country ?? 'MX') {
                        'CO' => ['A 5 min de El Poblado', 'Cerca de Zona Rosa', 'A 10 min de Chapinero', 'Conectado a transporte'],
                        'CL' => ['A 5 min de Providencia', 'Cerca de Las Condes', 'A 10 min del centro', 'Acceso inmediato al metro'],
                        default => ['A 5 min de Paseo de la Reforma', 'A 2 cuadras del Metrobus', 'A 2 cuadras del Metro Insurgentes', 'Cerca de Polanco y Condesa'],
                    };
                    foreach ($locationBullets as $bullet):
                    ?>
                    <li class="flex items-start gap-3 text-paper/70 text-sm"><span class="text-gold mt-1 flex-shrink-0" aria-hidden="true">•</span><?php echo htmlspecialchars($bullet); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="order-2 lg:order-1">
                <h2 class="font-serif font-black uppercase tracking-[0.04em] leading-tight mb-6" style="font-size: clamp(1.6rem, 3.5vw, 2.8rem);">
                    PLANEANDO INVERTIR<br><span class="text-gold">EN BIENES RAICES?</span>
                </h2>
                <div class="w-14 h-px bg-gold mb-6" aria-hidden="true"></div>
                <p class="text-paper/60 leading-relaxed mb-8 max-w-md">
                    Seleccion exclusiva en venta, renta y desarrollos con plusvalia.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <?php $featureItems = [['icon' => '+', 'label' => 'Venta'], ['icon' => '◇', 'label' => 'Renta'], ['icon' => '◻', 'label' => 'Desarrollos'], ['icon' => '◎', 'label' => 'Asesoria 24/7']];
                    foreach ($featureItems as $fi): ?>
                    <div class="flex items-center gap-3 border border-white/10 p-4">
                        <span class="text-gold text-xl leading-none" aria-hidden="true"><?php echo $fi['icon']; ?></span>
                        <span class="font-mono text-[11px] tracking-[0.2em] uppercase text-paper/70"><?php echo $fi['label']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="order-1 lg:order-2 aspect-[4/3] border border-white/8 overflow-hidden">
                <img src="/images/properties/desarrollo-nova-polanco-mx.jpg" alt="Desarrollos premium"
                     class="w-full h-full object-cover opacity-85" loading="lazy"
                     onerror="this.src='/images/properties/desarrollo-nova-polanco-mx.svg'">
            </div>
        </div>
    </div>
</section>

<section class="relative overflow-hidden" aria-label="Banner de servicios">
    <div class="absolute inset-0 bg-gradient-to-r from-[#050505] via-[#1a1208] to-[#050505]" aria-hidden="true"></div>
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(ellipse at 60% 50%, #b8942a 0%, transparent 70%);" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between px-8 lg:px-24 py-16 gap-8">
        <h2 class="font-serif font-black uppercase tracking-[0.06em] text-paper leading-tight text-center md:text-left max-w-2xl" style="font-size: clamp(1.3rem, 3vw, 2.2rem);">
            PROPIEDADES CON ACABADOS DE<br><span class="text-gold">LUJO, SEGURIDAD Y PLUSVALIA</span>
        </h2>
        <a href="/venta" class="flex-shrink-0 px-10 py-4 border border-paper/50 text-paper text-[11px] font-mono tracking-[0.35em] uppercase hover:bg-paper hover:text-ink transition-all duration-300">VER PROPIEDADES</a>
    </div>
</section>

<section class="py-24 bg-ink text-paper" id="propiedades" aria-label="Propiedades destacadas">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
            <h2 class="font-serif font-black uppercase tracking-[0.06em] mb-4" style="font-size: clamp(1.4rem, 3.5vw, 2.6rem);">BUSCANDO PROPIEDAD EN <?php echo mb_strtoupper(htmlspecialchars($countryName)); ?>?</h2>
            <div class="w-16 h-px bg-gold mx-auto" aria-hidden="true"></div>
        </div>

        <?php if (!empty($featured_properties)): ?>
        <div class="space-y-0">
            <?php foreach ($featured_properties as $idx => $prop):
                $slug = (string)($prop['slug'] ?? '');
                $imgSlug = $slug === 'depto-ñuñoa-cl' ? 'depto-nunoa-cl' : $slug;
                $imgJpg = '/images/properties/' . $imgSlug . '.jpg';
                $imgSvg = '/images/properties/' . $imgSlug . '.svg';
                $imgUrl = file_exists(ROOT_PATH . '/public' . $imgJpg) ? $imgJpg : $imgSvg;
                $isEven = ($idx % 2 === 0);
            ?>
            <article class="prop-card grid md:grid-cols-2 border-b border-white/8 last:border-b-0 opacity-0 translate-y-6"
                     style="transition:opacity .6s ease <?php echo $idx * 120; ?>ms, transform .6s ease <?php echo $idx * 120; ?>ms"
                     aria-label="<?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad'); ?>">

                <!-- Imagen con overlay hover -->
                <div class="<?php echo $isEven ? '' : 'md:order-2'; ?> aspect-[4/3] overflow-hidden relative group">
                    <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="<?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad'); ?>"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-108" loading="lazy"
                         onerror="this.src='<?php echo htmlspecialchars($imgSvg); ?>'">
                    <!-- Overlay dorado al hover -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent
                                opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    <!-- Línea dorada inferior que crece -->
                    <div class="absolute bottom-0 left-0 h-[2px] bg-gold w-0 group-hover:w-full transition-all duration-500 ease-out"></div>
                    <!-- Tag ciudad -->
                    <span class="absolute top-4 left-4 px-3 py-1 bg-black/60 backdrop-blur-sm text-gold text-[9px] font-mono tracking-[0.3em] uppercase
                                 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-400 delay-100">
                        <?php echo htmlspecialchars($prop['city'] ?? ''); ?>
                    </span>
                </div>

                <!-- Texto -->
                <div class="<?php echo $isEven ? '' : 'md:order-1'; ?> flex flex-col justify-center px-10 py-12">
                    <h3 class="font-serif font-black uppercase tracking-[0.04em] leading-tight mb-3"
                        style="font-size: clamp(1.2rem, 2.5vw, 1.8rem);">
                        <?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad'); ?>
                    </h3>
                    <p class="text-gold font-mono text-[11px] tracking-[0.3em] uppercase mb-5">
                        <?php echo htmlspecialchars($prop['city'] ?? ''); ?>
                    </p>
                    <div class="w-10 h-px bg-gold mb-6" aria-hidden="true"></div>
                    <div class="flex flex-wrap gap-6 mb-6 text-sm text-paper/60">
                        <?php if ($prop['bedrooms'] ?? 0): ?><span><?php echo (int)$prop['bedrooms']; ?> Recamaras</span><?php endif; ?>
                        <?php if ($prop['bathrooms'] ?? 0): ?><span><?php echo (int)$prop['bathrooms']; ?> Banos</span><?php endif; ?>
                        <?php if ($prop['sqm'] ?? 0): ?><span><?php echo number_format((float)$prop['sqm'], 0); ?> m2</span><?php endif; ?>
                    </div>
                    <p class="font-serif font-black text-gold mb-8" style="font-size: clamp(1.5rem, 3vw, 2.2rem);">
                        <?php echo number_format((float)($prop['price'] ?? 0), 0, '.', ','); ?>
                        <span class="text-xs text-paper/40 font-mono font-normal ml-1">
                            <?php echo htmlspecialchars($prop['currency'] ?? $currency ?? 'MXN'); ?>
                        </span>
                    </p>
                    <!-- Botón con shimmer -->
                    <a href="/venta?id=<?php echo (int)($prop['id'] ?? 0); ?>"
                       class="prop-btn self-start relative overflow-hidden px-8 py-4 border border-paper/30 text-paper text-[11px] font-mono tracking-[0.3em] uppercase hover:border-gold hover:text-gold transition-all duration-300">
                        <span class="relative z-10">VER PROPIEDAD</span>
                        <span class="shimmer-line absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/8 to-transparent"
                              aria-hidden="true"></span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-center text-paper/40 py-16 font-mono tracking-wide">No hay propiedades disponibles en este momento.</p>
        <?php endif; ?>
    </div>
</section>

<section class="bg-ink" aria-label="Galeria de propiedades">
    <div class="grid md:grid-cols-3 overflow-hidden" id="gallery" aria-label="Galeria de imagenes">
        <?php
        $galleryImages = [
            ['src' => '/images/properties/casa-lomas-mx.jpg', 'fallback' => '/images/properties/casa-lomas-mx.svg', 'alt' => 'Casa de lujo en Lomas'],
            ['src' => '/images/properties/loft-laureles-co.jpg', 'fallback' => '/images/properties/loft-laureles-co.svg', 'alt' => 'Loft moderno en Laureles'],
            ['src' => '/images/properties/apto-vitacura-cl.jpg', 'fallback' => '/images/properties/apto-vitacura-cl.svg', 'alt' => 'Apartamento en Vitacura'],
        ];
        foreach ($galleryImages as $img):
        ?>
        <div class="gallery-cell aspect-square overflow-hidden border-r border-b border-white/5 last:border-r-0 relative group"
             aria-label="<?php echo htmlspecialchars($img['alt']); ?>">
            <img src="<?php echo htmlspecialchars($img['src']); ?>" alt="<?php echo htmlspecialchars($img['alt']); ?>"
                 class="w-full h-full object-cover opacity-75 group-hover:opacity-100 group-hover:scale-108 transition-all duration-700" loading="lazy"
                 onerror="this.src='<?php echo htmlspecialchars($img['fallback']); ?>'">
            <!-- Overlay con texto alt -->
            <div class="absolute inset-0 flex items-end p-5 bg-gradient-to-t from-black/65 via-transparent to-transparent
                        opacity-0 group-hover:opacity-100 transition-opacity duration-400 pointer-events-none">
                <p class="text-paper/90 text-[10px] font-mono tracking-[0.25em] uppercase translate-y-3 group-hover:translate-y-0 transition-transform duration-400">
                    <?php echo htmlspecialchars($img['alt']); ?>
                </p>
            </div>
            <div class="absolute bottom-0 left-0 h-[2px] bg-gold w-0 group-hover:w-full transition-all duration-500 ease-out"></div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="bg-black/80 backdrop-blur-sm py-12 text-center border-t border-white/5">
        <p class="font-serif font-black uppercase tracking-[0.08em] text-paper mb-6" style="font-size: clamp(1.1rem, 2.5vw, 1.8rem);">LA INVERSION IDEAL PARA TU PATRIMONIO</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="tel:<?php echo preg_replace('/\s+/', '', $phone ?? '+525541698259'); ?>" class="px-8 py-3 border border-paper/30 text-paper text-[10px] font-mono tracking-[0.35em] uppercase hover:bg-paper hover:text-ink transition-all duration-300">LLAMANOS LAS 24 HORAS</a>
            <a href="/contacto" class="px-8 py-3 bg-gold text-ink text-[10px] font-mono tracking-[0.35em] uppercase hover:bg-gold/80 transition-all duration-300">RESERVA UNA VISITA</a>
        </div>
    </div>
</section>

<section class="py-20 bg-ink text-paper" id="mapa" aria-label="Ubicacion de propiedades">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-10">
            <h2 class="font-serif font-black uppercase tracking-[0.06em] mb-2" style="font-size: clamp(1.4rem, 3vw, 2.2rem);">HAVRE ESTATES</h2>
            <p class="text-paper/40 font-mono text-xs tracking-[0.25em]"><?php echo $country === 'CO' ? 'El Poblado, Medellin, Colombia' : ($country === 'CL' ? 'Las Condes, Santiago, Chile' : 'Paseo de la Reforma 24, 06600 Ciudad de Mexico'); ?></p>
        </div>

        <div class="border border-white/8 overflow-hidden"><div id="propertyMap" style="height:460px;" role="application" aria-label="Mapa interactivo de propiedades"></div></div>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="https://maps.google.com/?q=Paseo+de+la+Reforma+24+CDMX" target="_blank" rel="noopener" class="text-paper/40 font-mono text-xs tracking-[0.2em] uppercase hover:text-gold transition-colors flex items-center gap-2"><span>⊕</span> Obtener indicaciones</a>
            <div class="flex flex-wrap items-center justify-center sm:justify-end gap-3 text-[10px] font-mono tracking-[0.2em] text-paper/40 uppercase">
                <span>Reserva ya con:</span>
                <a href="https://www.lamudi.com.mx" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-3 py-1.5 border border-white/12 hover:border-gold/50 hover:text-gold transition-colors"><span class="text-gold" aria-hidden="true">◉</span>Lamudi</a>
                <a href="https://www.inmuebles24.com" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-3 py-1.5 border border-white/12 hover:border-gold/50 hover:text-gold transition-colors"><span class="text-gold" aria-hidden="true">◉</span>Inmuebles24</a>
                <a href="https://www.vivanuncios.com.mx" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-3 py-1.5 border border-white/12 hover:border-gold/50 hover:text-gold transition-colors"><span class="text-gold" aria-hidden="true">◉</span>Vivanuncios</a>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-black border-t border-white/5" aria-label="Plataformas inmobiliarias">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <p class="font-mono text-[10px] tracking-[0.5em] uppercase text-paper/30 mb-10">PUBLICA CON NOSOTROS EN</p>
        <div class="flex flex-wrap items-center justify-center gap-10 lg:gap-16">
            <?php $portals = [
                ['name' => 'Lamudi', 'url' => 'https://www.lamudi.com.mx'],
                ['name' => 'Inmuebles24', 'url' => 'https://www.inmuebles24.com'],
                ['name' => 'Vivanuncios', 'url' => 'https://www.vivanuncios.com.mx'],
                ['name' => 'MercadoLibre', 'url' => 'https://inmuebles.mercadolibre.com.mx'],
                ['name' => 'Propiedades', 'url' => 'https://www.propiedades.com'],
            ];
            foreach ($portals as $portal): ?>
            <a href="<?php echo htmlspecialchars($portal['url']); ?>" target="_blank" rel="noopener" class="font-serif font-black text-paper/20 hover:text-gold transition-colors duration-300 text-lg tracking-[0.08em] uppercase"><?php echo htmlspecialchars($portal['name']); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-14 bg-black border-t border-white/5" aria-label="Redes sociales">
    <div class="max-w-lg mx-auto px-6 text-center">
        <h2 class="font-serif font-black uppercase tracking-[0.1em] text-paper mb-2"
            style="font-size: clamp(1.1rem, 2.5vw, 1.6rem);" data-i18n="social.title">Conectate con nosotros</h2>
        <div class="w-12 h-px bg-gold mx-auto mb-10" aria-hidden="true"></div>

        <div class="flex justify-center items-center gap-5">

            <!-- Facebook -->
            <a href="#" aria-label="Facebook de HAVRE ESTATES" rel="noopener"
               class="social-icon group w-12 h-12 rounded-full border border-white/15 flex items-center justify-center
                      text-paper/40 hover:text-gold hover:border-gold/60 hover:bg-gold/8
                      transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_18px_rgba(184,148,42,0.25)]">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>

            <!-- Instagram -->
            <a href="#" aria-label="Instagram de HAVRE ESTATES" rel="noopener"
               class="social-icon group w-12 h-12 rounded-full border border-white/15 flex items-center justify-center
                      text-paper/40 hover:text-gold hover:border-gold/60 hover:bg-gold/8
                      transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_18px_rgba(184,148,42,0.25)]">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                </svg>
            </a>

            <!-- TikTok -->
            <a href="#" aria-label="TikTok de HAVRE ESTATES" rel="noopener"
               class="social-icon group w-12 h-12 rounded-full border border-white/15 flex items-center justify-center
                      text-paper/40 hover:text-gold hover:border-gold/60 hover:bg-gold/8
                      transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_18px_rgba(184,148,42,0.25)]">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.53V6.74a4.85 4.85 0 01-1.01-.05z"/>
                </svg>
            </a>

            <!-- LinkedIn -->
            <a href="#" aria-label="LinkedIn de HAVRE ESTATES" rel="noopener"
               class="social-icon group w-12 h-12 rounded-full border border-white/15 flex items-center justify-center
                      text-paper/40 hover:text-gold hover:border-gold/60 hover:bg-gold/8
                      transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_18px_rgba(184,148,42,0.25)]">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
            </a>

            <!-- YouTube -->
            <a href="#" aria-label="YouTube de HAVRE ESTATES" rel="noopener"
               class="social-icon group w-12 h-12 rounded-full border border-white/15 flex items-center justify-center
                      text-paper/40 hover:text-gold hover:border-gold/60 hover:bg-gold/8
                      transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_18px_rgba(184,148,42,0.25)]">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
            </a>

        </div>
    </div>
</section>

<section class="relative overflow-hidden" aria-label="Suscripcion al newsletter">
    <div class="absolute inset-0 bg-gradient-to-br from-[#0a0806] via-[#100e06] to-[#0a0a0a]" aria-hidden="true"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background-image:radial-gradient(circle at 1px 1px, #b8942a 1px, transparent 0); background-size:40px 40px;" aria-hidden="true"></div>

    <div class="relative z-10 max-w-3xl mx-auto px-6 py-12 md:py-14 text-paper text-center">
        <h2 class="font-serif font-black uppercase tracking-[0.08em] mb-3" style="font-size: clamp(1.5rem, 3.5vw, 2.5rem);">Suscribirse</h2>
        <div class="w-12 h-px bg-gold mx-auto mb-5" aria-hidden="true"></div>
        <p class="text-paper/50 text-sm leading-relaxed max-w-xl mx-auto mb-7">Suscribete para recibir noticias sobre propiedades, inversiones y eventos exclusivos.</p>

        <div class="max-w-3xl mx-auto">
                <?php if (($newsletter_status ?? '') === 'ok'): ?>
                <div role="alert" class="p-5 border border-gold/40 bg-gold/8 text-gold font-mono text-sm tracking-wide">OK - Suscripcion confirmada. Bienvenido a HAVRE ESTATES.</div>
                <?php else: ?>
                <form action="/newsletter/subscribe" method="POST" class="flex flex-col sm:flex-row gap-0 border border-white/15 overflow-hidden bg-black/20">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($newsletter_csrf_token ?? ''); ?>">
                    <input type="email" name="email" required placeholder="Correo electronico" autocomplete="email" class="flex-1 px-5 py-3.5 bg-white/5 border-0 sm:border-r border-white/15 text-paper text-sm placeholder:text-paper/30 focus:outline-none focus:ring-2 focus:ring-gold">
                    <button type="submit" class="px-6 py-3.5 sm:min-w-[180px] bg-paper/10 text-paper text-[10px] font-mono tracking-[0.32em] uppercase hover:bg-gold hover:text-ink transition-all duration-300">Registrarse</button>
                    <div class="hidden" aria-hidden="true"><label for="website_hp">No llenar</label><input id="website_hp" type="text" name="website" tabindex="-1" autocomplete="off"></div>
                </form>
                <p class="mt-3 text-[11px] text-paper/25 font-mono tracking-wide">Sin spam · Cancela cuando quieras</p>
                <?php endif; ?>
        </div>
    </div>
</section>

<style>
/* ── Animaciones cards y galería ── */
@keyframes shimmer-sweep {
    0%   { transform: translateX(-100%); }
    100% { transform: translateX(200%); }
}
.prop-btn:hover .shimmer-line {
    animation: shimmer-sweep .7s ease forwards;
}
.prop-card.is-visible,
.gallery-cell.is-visible {
    opacity: 1 !important;
    transform: translateY(0) !important;
}
.gallery-cell {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity .55s ease, transform .55s ease;
}
</style>

<script>
/* IntersectionObserver para fade-in en cards y galería */
(function () {
    if ('IntersectionObserver' in window) {
        var cardObs = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    cardObs.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.prop-card, .gallery-cell').forEach(function (el, i) {
            if (el.classList.contains('gallery-cell')) {
                el.style.transitionDelay = (i % 3) * 100 + 'ms';
            }
            cardObs.observe(el);
        });
    } else {
        document.querySelectorAll('.prop-card, .gallery-cell').forEach(function (el) {
            el.classList.add('is-visible');
        });
    }
})();
</script>

<script>
(function () {
    'use strict';

    var slides = Array.from(document.querySelectorAll('.hero-slide'));
    var dots = Array.from(document.querySelectorAll('[data-hero-slide]'));
    var current = 0;

    function heroGoTo(idx) {
        if (!slides.length) return;
        slides[current].classList.remove('opacity-100');
        slides[current].classList.add('opacity-0');
        if (dots[current]) {
            dots[current].classList.remove('w-6', 'h-2', 'bg-gold');
            dots[current].classList.add('w-2', 'h-2', 'bg-paper/40');
            dots[current].setAttribute('aria-selected', 'false');
        }

        current = (idx + slides.length) % slides.length;

        slides[current].classList.remove('opacity-0');
        slides[current].classList.add('opacity-100');
        if (dots[current]) {
            dots[current].classList.remove('w-2', 'h-2', 'bg-paper/40');
            dots[current].classList.add('w-6', 'h-2', 'bg-gold');
            dots[current].setAttribute('aria-selected', 'true');
        }
    }

    dots.forEach(function (d) {
        d.addEventListener('click', function () {
            heroGoTo(parseInt(d.dataset.heroSlide, 10));
        });
    });

    setInterval(function () { heroGoTo(current + 1); }, 5500);

    function initMap() {
        var mapEl = document.getElementById('propertyMap');
        if (!mapEl || typeof L === 'undefined') {
            return false;
        }
        if (mapEl.dataset.mapReady === '1') {
            return true;
        }

        var geoNode = document.querySelector('[data-geo-country]');
        var geoCountry = (geoNode && geoNode.dataset && geoNode.dataset.geoCountry) ? geoNode.dataset.geoCountry : 'MX';
        var centers = { MX: [19.4326, -99.1332], CO: [6.2442, -75.5812], CL: [-33.4489, -70.6693] };
        var center = centers[geoCountry] || centers.MX;

        var map = L.map('propertyMap', { scrollWheelZoom: false }).setView(center, 12);
        mapEl.dataset.mapReady = '1';
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 18,
        }).addTo(map);

        fetch('/api/properties/' + geoCountry)
            .then(function (r) { return r.json(); })
            .then(function (props) {
                props.forEach(function (p) {
                    if (!p.lat || !p.lng) return;
                    L.marker([p.lat, p.lng])
                        .bindPopup('<strong>' + (p.meta_title || 'Propiedad') + '</strong><br>' + (p.city || '') + '<br>' + Number(p.price || 0).toLocaleString('es-MX') + ' ' + (p.currency || ''))
                        .addTo(map);
                });
            })
            .catch(function () {});

        return true;
    }

    if (!initMap()) {
        window.addEventListener('load', function () {
            initMap();
        });
        setTimeout(initMap, 450);
    }
})();
</script>
