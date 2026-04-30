<?php
/**
 * Home Landing Page
 *
 * Variables disponibles:
 * - $country         : Código del país (MX, CO, CL)
 * - $currency        : Moneda (MXN, COP, CLP)
 * - $phone           : Teléfono de contacto
 * - $featured_properties : Array de propiedades destacadas
 * - $newsletter_csrf_token : Token CSRF para newsletter
 * - $newsletter_status    : Estado de la suscripción
 */
$countryName = match($country ?? 'MX') {
    'CO'    => 'Colombia',
    'CL'    => 'Chile',
    default => 'México',
};
?>

<!-- ══════════════════════════════════
     1. HERO — Split layout premium
     ══════════════════════════════════ -->
<section class="relative min-h-[100dvh] flex items-center overflow-hidden bg-ink text-paper" aria-label="Hero principal">

    <!-- Background layers -->
    <div class="absolute inset-0" aria-hidden="true">
        <div class="absolute inset-0 bg-gradient-to-br from-[#050505] via-accent/40 to-[#050505]"></div>
        <div class="absolute inset-0 opacity-[0.06] bg-[url('/images/hero-poster.svg')] bg-cover bg-center"></div>
        <!-- Atmospheric glows -->
        <div class="absolute top-0 right-0 w-[50vw] h-[60vh] bg-gold/5 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 w-[40vw] h-[50vh] bg-accent/10 rounded-full blur-[100px]"></div>
        <!-- Subtle grid pattern -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 80px 80px;"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-8 lg:px-16 py-32 lg:py-0 min-h-[100dvh] flex items-center">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center w-full">

            <!-- ── Left content (7 cols) ── -->
            <div class="lg:col-span-7">
                <!-- Eyebrow with rule -->
                <div class="flex items-center gap-5 mb-10" data-geo-country="<?php echo htmlspecialchars($country ?? 'MX'); ?>">
                    <span class="block h-px w-10 bg-gold flex-shrink-0" aria-hidden="true"></span>
                    <p class="text-gold font-mono text-[11px] tracking-[0.35em] uppercase">
                        Inmobiliaria Premium &nbsp;·&nbsp; <?php echo htmlspecialchars($countryName); ?>
                    </p>
                </div>

                <!-- Display heading -->
                <h1 class="font-serif font-black leading-[0.92] mb-8 max-w-2xl"
                    style="font-size: clamp(3.2rem, 7.5vw, 5.8rem);">
                    Propiedades<br>
                    de Lujo en<br>
                    <em class="text-gold not-italic"><?php echo htmlspecialchars($countryName); ?></em>
                </h1>

                <!-- Gold divider -->
                <div class="w-14 h-[2px] bg-gold mb-10" aria-hidden="true"></div>

                <!-- Body -->
                <p class="text-paper/65 mb-12 max-w-lg leading-relaxed font-light"
                   style="font-size: clamp(1rem, 1.3vw, 1.15rem);">
                    Selección exclusiva de inmuebles premium con GEO targeting,
                    SEO avanzado y experiencia de clase mundial en 3 mercados.
                </p>

                <!-- CTAs -->
                <div class="flex flex-wrap gap-4 mb-12">
                    <a href="/venta"
                       class="inline-flex items-center gap-3 px-10 py-4 bg-gold text-ink font-bold text-sm tracking-[0.1em] uppercase hover:bg-gold/85 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                        Ver Propiedades
                        <span aria-hidden="true">→</span>
                    </a>
                    <a href="/contacto"
                       class="inline-flex items-center gap-3 px-10 py-4 border border-paper/25 text-paper font-bold text-sm tracking-[0.1em] uppercase hover:border-paper/60 hover:bg-paper/8 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-paper">
                        Hablar con un Agente
                    </a>
                </div>

                <!-- GEO phone -->
                <p class="text-paper/30 font-mono text-xs tracking-[0.25em]">
                    <span id="geoPhone"><?php echo htmlspecialchars($phone ?? '+52 55 4169 8259'); ?></span>
                    &nbsp;&nbsp;/&nbsp;&nbsp;<?php echo htmlspecialchars($currency ?? 'MXN'); ?>
                </p>
            </div>

            <!-- ── Right panel (5 cols) — Disponibilidad quick-stats ── -->
            <div class="lg:col-span-5 hidden lg:flex justify-end">
                <div class="w-full max-w-[360px] border border-white/10 bg-white/[0.03] backdrop-blur-sm p-8 space-y-0">
                    <!-- Panel header -->
                    <p class="font-mono text-[10px] text-paper/35 tracking-[0.4em] uppercase mb-8">Disponibilidad · <?php echo date('Y'); ?></p>

                    <!-- Stats list -->
                    <?php
                    $heroStats = [
                        ['label' => 'Propiedades activas', 'value' => '450+'],
                        ['label' => 'Ciudades cubiertas', 'value' => '12'],
                        ['label' => 'Países de operación', 'value' => '3'],
                        ['label' => 'Años en el mercado', 'value' => '15'],
                    ];
                    ?>
                    <?php foreach ($heroStats as $i => $stat): ?>
                    <div class="flex justify-between items-baseline py-5 <?php echo $i < count($heroStats) - 1 ? 'border-b border-white/8' : ''; ?>">
                        <span class="text-paper/50 text-sm font-light"><?php echo htmlspecialchars($stat['label']); ?></span>
                        <span class="text-gold font-serif font-black text-3xl leading-none"><?php echo htmlspecialchars($stat['value']); ?></span>
                    </div>
                    <?php endforeach; ?>

                    <!-- CTA button -->
                    <a href="/contacto"
                       class="block mt-8 py-4 border border-gold/60 text-gold text-[11px] font-mono tracking-[0.35em] uppercase text-center hover:bg-gold hover:text-ink transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                        AGENDA UNA VISITA
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-3 text-paper/30" aria-hidden="true">
        <span class="text-[10px] font-mono tracking-[0.4em] uppercase">Explorar</span>
        <span class="block w-px h-10 bg-gradient-to-b from-paper/25 to-transparent"></span>
    </div>
</section>

<!-- ══════════════════════════════════
     2. BUSCADOR AJAX
     ══════════════════════════════════ -->
<section class="py-20 bg-paper border-b border-rule" id="search" aria-label="Buscador de propiedades">
    <div class="max-w-7xl mx-auto px-8 lg:px-16">
        <!-- Header row -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
            <div>
                <p class="font-mono text-[11px] text-gold tracking-[0.35em] uppercase mb-3">02 &nbsp;/&nbsp; Búsqueda</p>
                <h2 class="text-4xl lg:text-5xl font-serif font-black leading-tight text-ink">Encuentra tu<br>propiedad ideal</h2>
            </div>
            <p class="text-muted text-sm max-w-xs leading-relaxed lg:text-right">Filtra por tipo, país, precio y metraje. Resultados en tiempo real.</p>
        </div>

        <form id="searchForm" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3" role="search" aria-label="Filtros de búsqueda">
            <select name="type" class="px-5 py-4 border border-rule bg-white text-ink text-sm focus:outline-none focus:ring-2 focus:ring-gold" aria-label="Tipo de propiedad">
                <option value="">Tipo de propiedad</option>
                <option value="venta">Venta</option>
                <option value="renta">Renta</option>
                <option value="desarrollo">Desarrollo</option>
            </select>

            <select name="country" class="px-5 py-4 border border-rule bg-white text-ink text-sm focus:outline-none focus:ring-2 focus:ring-gold" aria-label="País">
                <option value="MX" <?php if (($country ?? 'MX') === 'MX') echo 'selected'; ?>>México</option>
                <option value="CO" <?php if (($country ?? '') === 'CO') echo 'selected'; ?>>Colombia</option>
                <option value="CL" <?php if (($country ?? '') === 'CL') echo 'selected'; ?>>Chile</option>
            </select>

            <input type="number" name="min_price" placeholder="Precio mínimo"
                   class="px-5 py-4 border border-rule bg-white text-sm focus:outline-none focus:ring-2 focus:ring-gold" aria-label="Precio mínimo">

            <input type="number" name="max_sqm" placeholder="Metros cuadrados máx."
                   class="px-5 py-4 border border-rule bg-white text-sm focus:outline-none focus:ring-2 focus:ring-gold" aria-label="Metros cuadrados máximo">

            <button type="submit"
                    class="px-8 py-4 bg-ink text-paper font-bold text-sm tracking-[0.1em] uppercase hover:bg-accent transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                Buscar →
            </button>
        </form>

        <!-- Resultados AJAX -->
        <div id="searchResults" role="region" aria-live="polite" aria-label="Resultados de búsqueda"
             class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
        </div>
        <div id="searchLoader" aria-live="polite" class="mt-10 text-center text-muted hidden">
            <span class="inline-block w-5 h-5 border-2 border-gold border-t-transparent rounded-full animate-spin mr-2" aria-hidden="true"></span>
            Buscando propiedades…
        </div>
        <p id="searchEmpty" class="mt-10 text-center text-muted hidden">No se encontraron propiedades con esos filtros.</p>
    </div>
</section>

<!-- ══════════════════════════════════
     3. CAROUSEL — Propiedades destacadas
     ══════════════════════════════════ -->
<section class="py-28 bg-white" id="destacadas" aria-label="Propiedades destacadas">
    <div class="max-w-7xl mx-auto px-8 lg:px-16">
        <div class="flex items-end justify-between mb-14">
            <div>
                <p class="font-mono text-[11px] text-gold tracking-[0.35em] uppercase mb-3">03 &nbsp;/&nbsp; Destacadas</p>
                <h2 class="text-4xl lg:text-5xl font-serif font-black leading-tight">Propiedades Premium<br><em class="not-italic text-muted font-light" style="font-size:0.75em;">en <?php echo htmlspecialchars($countryName); ?></em></h2>
            </div>
            <div class="flex gap-3" role="group" aria-label="Controles del carrusel">
                <button id="prevSlide" aria-label="Anterior propiedad"
                        class="w-11 h-11 flex items-center justify-center border border-rule text-ink text-xl hover:bg-ink hover:text-paper hover:border-ink transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                    ‹
                </button>
                <button id="nextSlide" aria-label="Siguiente propiedad"
                        class="w-11 h-11 flex items-center justify-center border border-rule text-ink text-xl hover:bg-ink hover:text-paper hover:border-ink transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                    ›
                </button>
            </div>
        </div>

        <?php if (!empty($featured_properties)): ?>
        <!-- Carousel wrapper -->
        <div id="carouselTrack" class="relative overflow-hidden" role="region" aria-label="Carrusel de propiedades" aria-roledescription="carousel">
            <ul id="carouselList" class="flex transition-transform duration-500 ease-in-out gap-6" role="list">
                <?php foreach ($featured_properties as $idx => $prop): ?>
                <?php
                    $slug = (string)($prop['slug'] ?? '');
                    $imgSlug = $slug === 'depto-ñuñoa-cl' ? 'depto-nunoa-cl' : $slug;
                    $imgUrl  = '/images/properties/' . $imgSlug . '.svg';
                ?>
                <li id="slide-<?php echo $idx; ?>"
                    role="group"
                    aria-roledescription="slide"
                    aria-label="<?php echo $idx + 1; ?> de <?php echo count($featured_properties); ?>"
                    class="carousel-item flex-shrink-0 w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                    <div class="group bg-white border border-rule overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 h-full flex flex-col">
                        <!-- Image -->
                        <div class="aspect-[4/3] bg-gradient-to-br from-muted/15 to-rule overflow-hidden">
                            <img src="<?php echo htmlspecialchars($imgUrl); ?>"
                                 alt="<?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad destacada'); ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                 loading="lazy"
                                 onerror="this.src='/images/property-fallback.svg'">
                        </div>
                        <!-- Content -->
                        <div class="p-7 flex flex-col flex-1">
                            <h3 class="text-lg font-serif font-bold leading-snug mb-1"><?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad'); ?></h3>
                            <p class="text-muted text-sm font-mono tracking-wide mb-5"><?php echo htmlspecialchars($prop['city'] ?? 'Ubicación'); ?></p>
                            <div class="flex gap-5 mb-5 text-xs text-muted flex-wrap border-b border-rule pb-5">
                                <?php if ($prop['bedrooms'] ?? 0): ?>
                                <span class="flex flex-col gap-0.5"><strong class="text-ink text-sm font-bold"><?php echo (int)$prop['bedrooms']; ?></strong> Habitaciones</span>
                                <?php endif; ?>
                                <?php if ($prop['bathrooms'] ?? 0): ?>
                                <span class="flex flex-col gap-0.5"><strong class="text-ink text-sm font-bold"><?php echo (int)$prop['bathrooms']; ?></strong> Baños</span>
                                <?php endif; ?>
                                <?php if ($prop['sqm'] ?? 0): ?>
                                <span class="flex flex-col gap-0.5"><strong class="text-ink text-sm font-bold"><?php echo number_format($prop['sqm'], 0); ?></strong> m²</span>
                                <?php endif; ?>
                            </div>
                            <div class="mt-auto">
                                <p class="font-serif font-black text-gold leading-none" style="font-size:clamp(1.5rem,2.5vw,2rem);">
                                    <?php echo number_format($prop['price'] ?? 0, 0, '.', ','); ?>
                                    <span class="text-xs text-muted font-sans font-normal ml-1"><?php echo htmlspecialchars($prop['currency'] ?? $currency ?? 'MXN'); ?></span>
                                </p>
                            </div>
                            <a href="/venta?id=<?php echo (int)($prop['id'] ?? 0); ?>"
                               class="block mt-5 text-center py-3.5 bg-ink text-paper text-sm font-bold tracking-[0.08em] uppercase hover:bg-accent transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Dots navigation -->
        <div class="flex justify-center gap-2 mt-8" role="tablist" aria-label="Navegación del carrusel">
            <?php foreach ($featured_properties as $idx => $prop): ?>
            <button role="tab"
                    aria-selected="<?php echo $idx === 0 ? 'true' : 'false'; ?>"
                    aria-controls="slide-<?php echo $idx; ?>"
                    data-slide="<?php echo $idx; ?>"
                    class="carousel-dot h-[3px] transition-all duration-300 <?php echo $idx === 0 ? 'bg-gold w-8' : 'bg-rule w-4'; ?>"
                    aria-label="Ir a la propiedad <?php echo $idx + 1; ?>">
            </button>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-center text-muted py-12">No hay propiedades destacadas disponibles.</p>
        <?php endif; ?>

        <!-- Ver todas -->
        <div class="mt-14 text-center">
            <a href="/venta" class="inline-flex items-center gap-3 text-sm font-mono text-muted tracking-[0.2em] uppercase hover:text-ink transition-colors">
                <span class="block h-px w-8 bg-current"></span>
                Ver todas las propiedades
                <span class="block h-px w-8 bg-current"></span>
            </a>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     4. MAPA LEAFLET — Clusters por ciudad
     ══════════════════════════════════ -->
<section class="py-28 bg-ink text-paper" id="mapa" aria-label="Mapa de propiedades">
    <div class="max-w-7xl mx-auto px-8 lg:px-16">
        <!-- Header split -->
        <div class="grid lg:grid-cols-12 gap-10 items-end mb-12">
            <div class="lg:col-span-7">
                <p class="font-mono text-[11px] text-gold tracking-[0.35em] uppercase mb-3">04 &nbsp;/&nbsp; Mapa</p>
                <h2 class="text-4xl lg:text-5xl font-serif font-black leading-tight">Propiedades<br>por ubicación</h2>
            </div>
            <div class="lg:col-span-5">
                <p class="text-paper/50 leading-relaxed">Explora propiedades disponibles en los tres mercados de HAVRE ESTATES. Navega el mapa y haz clic en cualquier marcador para ver detalles.</p>
            </div>
        </div>

        <!-- Map container with border treatment -->
        <div class="border border-white/10 overflow-hidden">
            <div id="propertyMap" style="height:520px;" role="application" aria-label="Mapa interactivo de propiedades">
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     5. CONTADORES ANIMADOS
     ══════════════════════════════════ -->
<section class="py-28 bg-paper" id="metricas" aria-label="Métricas de la empresa">
    <div class="max-w-7xl mx-auto px-8 lg:px-16">
        <!-- Header centered -->
        <div class="text-center mb-16">
            <p class="font-mono text-[11px] text-gold tracking-[0.35em] uppercase mb-3">05 &nbsp;/&nbsp; Métricas</p>
            <h2 class="text-4xl lg:text-5xl font-serif font-black">Números que hablan</h2>
        </div>

        <!-- Stats grid with separators -->
        <div class="grid grid-cols-2 lg:grid-cols-4" id="statsGrid">
            <?php
            $statsItems = [
                ['target'=>'450',   'suffix'=>'+',       'label'=>'Propiedades Listadas'],
                ['target'=>'12000', 'suffix'=>'+',       'label'=>'Clientes Satisfechos'],
                ['target'=>'15',    'suffix'=>' años',   'label'=>'En el Mercado'],
                ['target'=>'3',     'suffix'=>' países', 'label'=>'Mercados Activos'],
            ];
            ?>
            <?php foreach ($statsItems as $si => $stat): ?>
            <div class="stat-block flex flex-col items-center justify-center py-14 px-6 text-center
                        <?php echo $si < count($statsItems) - 1 ? 'border-r border-rule' : ''; ?>
                        <?php echo $si < 2 ? 'border-b border-rule lg:border-b-0' : ''; ?>
                        group hover:bg-ink/[0.03] transition-colors duration-300">
                <p class="font-serif font-black text-gold mb-3 leading-none"
                   style="font-size: clamp(3rem, 5vw, 4.5rem);"
                   data-target="<?php echo $stat['target']; ?>"
                   data-suffix="<?php echo $stat['suffix']; ?>"
                   aria-label="<?php echo $stat['target'] . $stat['suffix'] . ' ' . $stat['label']; ?>">0</p>
                <p class="font-mono text-xs text-muted tracking-[0.25em] uppercase"><?php echo $stat['label']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     6. TESTIMONIOS — schema Review
     ══════════════════════════════════ -->
<!-- ══════════════════════════════════
     6. TESTIMONIOS — schema Review
     ══════════════════════════════════ -->
<section class="py-28 bg-ink text-paper" id="testimonios" aria-label="Testimonios de clientes">
    <div class="max-w-7xl mx-auto px-8 lg:px-16">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-16">
            <div>
                <p class="font-mono text-[11px] text-gold tracking-[0.35em] uppercase mb-3">06 &nbsp;/&nbsp; Testimonios</p>
                <h2 class="text-4xl lg:text-5xl font-serif font-black leading-tight">Lo que dicen<br>nuestros clientes</h2>
            </div>
            <p class="text-paper/40 text-sm max-w-xs leading-relaxed lg:text-right">Más de 12,000 familias e inversores confían en HAVRE ESTATES.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $testimonials = $testimonials ?? [
                ['author'=>'María Fernández','title'=>'Compradora, CDMX','rating'=>5,'body'=>'El proceso fue increíblemente ágil. Encontramos el penthouse perfecto en menos de 3 semanas.'],
                ['author'=>'Andrés Velásquez','title'=>'Inversionista, Bogotá','rating'=>5,'body'=>'La atención es de primer nivel y la plataforma me permitió comparar propiedades en tiempo real.'],
                ['author'=>'Valentina Lagos','title'=>'Arrendataria, Santiago','rating'=>5,'body'=>'Excelente servicio. El chat en tiempo real con los agentes marcó la diferencia.'],
            ];
            ?>
            <?php foreach ($testimonials as $t): ?>
            <article class="border border-white/10 p-8 flex flex-col hover:border-gold/30 transition-colors duration-300" itemscope itemtype="https://schema.org/Review">
                <!-- Decorative quote -->
                <div class="text-gold/15 font-serif leading-none mb-4 select-none" style="font-size:5rem;" aria-hidden="true">"</div>
                <!-- Stars -->
                <div class="flex gap-1 mb-5" aria-label="Calificación <?php echo (int)$t['rating']; ?> de 5 estrellas">
                    <?php for ($s = 0; $s < ($t['rating'] ?? 5); $s++): ?>
                    <span class="text-gold text-sm" aria-hidden="true">★</span>
                    <?php endfor; ?>
                </div>
                <!-- Body -->
                <blockquote class="text-paper/65 leading-relaxed flex-1 mb-8 text-[0.95rem]" itemprop="reviewBody">
                    <?php echo htmlspecialchars($t['body']); ?>
                </blockquote>
                <!-- Author -->
                <footer class="border-t border-white/10 pt-5">
                    <p class="font-serif font-bold text-paper" itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <span itemprop="name"><?php echo htmlspecialchars($t['author']); ?></span>
                    </p>
                    <p class="text-xs text-paper/40 font-mono tracking-wide mt-1"><?php echo htmlspecialchars($t['title']); ?></p>
                </footer>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     7. NEWSLETTER
     ══════════════════════════════════ -->
<section class="py-28 bg-paper border-t border-rule" aria-label="Suscripción al newsletter">
    <div class="max-w-7xl mx-auto px-8 lg:px-16">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <!-- Left copy -->
            <div class="lg:col-span-5">
                <p class="font-mono text-[11px] text-gold tracking-[0.35em] uppercase mb-3">07 &nbsp;/&nbsp; Newsletter</p>
                <h2 class="text-4xl lg:text-5xl font-serif font-black leading-tight mb-5">Recibe propiedades<br>antes que nadie</h2>
                <p class="text-muted leading-relaxed max-w-sm">Actualizaciones semanales por país, tipo de propiedad y rangos de precio. Sin spam.</p>
            </div>
            <!-- Right form -->
            <div class="lg:col-span-7">
                <?php if (($newsletter_status ?? '') === 'ok'): ?>
                    <div role="alert" class="p-6 border border-gold/40 bg-gold/5 text-gold font-mono text-sm tracking-wide">
                        ✓ &nbsp;Suscripción confirmada. ¡Bienvenido a HAVRE ESTATES!
                    </div>
                <?php else: ?>
                    <?php if (($newsletter_status ?? '') === 'invalid_email'): ?>
                        <div role="alert" class="mb-4 p-4 border border-amber-400/40 bg-amber-50 text-amber-800 text-sm">Correo inválido. Verifica e intenta de nuevo.</div>
                    <?php elseif (($newsletter_status ?? '') === 'rate_limited'): ?>
                        <div role="alert" class="mb-4 p-4 border border-amber-400/40 bg-amber-50 text-amber-800 text-sm">Demasiados intentos. Espera antes de reintentar.</div>
                    <?php elseif (($newsletter_status ?? '') === 'csrf_error'): ?>
                        <div role="alert" class="mb-4 p-4 border border-red-300 bg-red-50 text-red-700 text-sm">Sesión inválida. Recarga la página.</div>
                    <?php elseif (($newsletter_status ?? '') === 'server_error'): ?>
                        <div role="alert" class="mb-4 p-4 border border-red-300 bg-red-50 text-red-700 text-sm">No se pudo registrar la suscripción.</div>
                    <?php endif; ?>
                    <form action="/newsletter/subscribe" method="POST"
                          class="flex flex-col sm:flex-row gap-0 border border-rule overflow-hidden">
                        <input type="hidden" name="csrf_token"
                               value="<?php echo htmlspecialchars($newsletter_csrf_token ?? ''); ?>">
                        <input type="text" name="name" placeholder="Nombre"
                               class="flex-1 px-6 py-5 border-0 border-r border-rule bg-white text-ink text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                        <input type="email" name="email" required placeholder="tu@email.com"
                               class="flex-1 px-6 py-5 border-0 border-r border-rule bg-white text-ink text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                        <button type="submit"
                                class="px-8 py-5 bg-ink text-paper text-sm font-bold tracking-[0.1em] uppercase hover:bg-accent transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-ink whitespace-nowrap">
                            Suscribirse →
                        </button>
                        <!-- Honeypot anti-spam -->
                        <div class="hidden" aria-hidden="true">
                            <label for="website">No llenar</label>
                            <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>
                    </form>
                    <p class="mt-4 text-xs text-muted font-mono">Sin spam · Cancela cuando quieras</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    'use strict';

    // ── 1. CAROUSEL ──────────────────────────────────────────────────
    const list   = document.getElementById('carouselList');
    const items  = list ? Array.from(list.querySelectorAll('.carousel-item')) : [];
    const dots   = Array.from(document.querySelectorAll('.carousel-dot'));
    let current  = 0;
    let autoPlay = null;

    function goTo(idx) {
        if (!list || !items.length) return;
        // responsive: 1 col on mobile, 2 on sm, 3 on lg
        const perView = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 640 ? 2 : 1;
        const maxIdx  = Math.max(0, items.length - perView);
        current = Math.min(Math.max(idx, 0), maxIdx);

        const itemW = items[0].getBoundingClientRect().width + 24; // 24 = gap-6
        list.style.transform = 'translateX(-' + (current * itemW) + 'px)';

        dots.forEach(function (d, i) {
            d.setAttribute('aria-selected', String(i === current));
            d.classList.toggle('bg-gold', i === current);
            d.classList.toggle('w-4',     i === current);
            d.classList.toggle('bg-rule', i !== current);
        });
    }

    document.getElementById('prevSlide')?.addEventListener('click', function () { goTo(current - 1); });
    document.getElementById('nextSlide')?.addEventListener('click', function () { goTo(current + 1); });
    dots.forEach(function (d) {
        d.addEventListener('click', function () { goTo(parseInt(d.dataset.slide, 10)); });
    });

    // Swipe gesture (nativo, sin librerías)
    if (list) {
        let touchStartX = 0;
        list.addEventListener('touchstart', function (e) { touchStartX = e.touches[0].clientX; }, { passive: true });
        list.addEventListener('touchend', function (e) {
            const dx = e.changedTouches[0].clientX - touchStartX;
            if (Math.abs(dx) > 50) { goTo(dx < 0 ? current + 1 : current - 1); }
        }, { passive: true });
    }

    autoPlay = setInterval(function () { goTo(current + 1 < items.length ? current + 1 : 0); }, 5000);
    document.getElementById('carouselTrack')?.addEventListener('mouseenter', function () { clearInterval(autoPlay); });
    document.getElementById('carouselTrack')?.addEventListener('mouseleave', function () {
        autoPlay = setInterval(function () { goTo(current + 1 < items.length ? current + 1 : 0); }, 5000);
    });

    // ── 2. CONTADORES ANIMADOS ────────────────────────────────────────
    function animateCounter(el) {
        const target = parseInt(el.dataset.target || '0', 10);
        const suffix = el.dataset.suffix || '';
        const dur    = 1600;
        const start  = performance.now();

        function format(n) {
            if (target >= 1000) return n.toLocaleString('es-MX');
            return String(n);
        }

        function step(now) {
            const t = Math.min((now - start) / dur, 1);
            const ease = 1 - Math.pow(1 - t, 3); // ease-out-cubic
            el.textContent = format(Math.round(ease * target)) + (t >= 1 ? suffix : '');
            if (t < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    const statsObserver = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.querySelectorAll('[data-target]').forEach(animateCounter);
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    const statsGrid = document.getElementById('statsGrid');
    if (statsGrid) statsObserver.observe(statsGrid);

    // ── 3. BUSCADOR AJAX ─────────────────────────────────────────────
    const searchForm    = document.getElementById('searchForm');
    const searchResults = document.getElementById('searchResults');
    const searchLoader  = document.getElementById('searchLoader');
    const searchEmpty   = document.getElementById('searchEmpty');

    function renderCard(p) {
        return '<div class="bg-white border border-rule rounded-xl overflow-hidden">' +
            '<img src="/images/properties/' + (p.slug || 'default') + '.svg" ' +
                 'alt="' + (p.meta_title || 'Propiedad') + '" ' +
                 'class="w-full aspect-video object-cover" loading="lazy">' +
            '<div class="p-4">' +
                '<h3 class="font-serif font-bold text-lg">' + (p.meta_title || '') + '</h3>' +
                '<p class="text-muted text-sm mb-2">' + (p.city || '') + '</p>' +
                '<p class="text-gold font-bold font-serif text-xl">' +
                    Number(p.price || 0).toLocaleString('es-MX') + ' ' + (p.currency || '') +
                '</p>' +
            '</div>' +
        '</div>';
    }

    searchForm?.addEventListener('submit', function (e) {
        e.preventDefault();
        const params = new URLSearchParams(new FormData(searchForm));
        searchResults.classList.add('hidden');
        searchEmpty.classList.add('hidden');
        searchLoader.classList.remove('hidden');

        fetch('/api/properties/' + (params.get('country') || 'MX') + '?' + params.toString())
            .then(function (r) { return r.json(); })
            .then(function (data) {
                searchLoader.classList.add('hidden');
                if (!data || !data.length) {
                    searchEmpty.classList.remove('hidden');
                    return;
                }
                searchResults.innerHTML = data.map(renderCard).join('');
                searchResults.classList.remove('hidden');
            })
            .catch(function () {
                searchLoader.classList.add('hidden');
                searchEmpty.classList.remove('hidden');
            });
    });

    // ── 4. MAPA LEAFLET ──────────────────────────────────────────────
    const mapEl = document.getElementById('propertyMap');
    if (mapEl && typeof L !== 'undefined') {
        const geoCountry = document.querySelector('[data-geo-country]')?.dataset.geoCountry || 'MX';
        const centerMap  = { MX: [23.6345, -102.5528], CO: [4.5709, -74.2973], CL: [-35.6751, -71.5430] };
        const center     = centerMap[geoCountry] || centerMap.MX;

        const map = L.map('propertyMap', { scrollWheelZoom: false }).setView(center, 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 18,
        }).addTo(map);

        // Markers from API
        fetch('/api/properties/' + geoCountry)
            .then(function (r) { return r.json(); })
            .then(function (props) {
                props.forEach(function (p) {
                    if (!p.lat || !p.lng) return;
                    L.marker([p.lat, p.lng])
                        .bindPopup('<strong>' + (p.meta_title || 'Propiedad') + '</strong>' +
                                   '<br>' + (p.city || '') +
                                   '<br><span class="text-gold">' +
                                   Number(p.price || 0).toLocaleString('es-MX') + ' ' + (p.currency || '') +
                                   '</span>')
                        .addTo(map);
                });
            })
            .catch(function () {});
    }
})();
</script>
