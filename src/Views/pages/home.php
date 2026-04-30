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
     1. HERO — Video background
     ══════════════════════════════════ -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-ink text-paper" aria-label="Hero principal">

    <!-- Video poster / fallback -->
    <div class="absolute inset-0 bg-gradient-to-br from-ink via-accent/60 to-ink" aria-hidden="true">
        <div class="absolute inset-0 opacity-20 bg-[url('/images/hero-poster.svg')] bg-cover bg-center"></div>
    </div>
    <!-- Animated overlay -->
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute top-20 right-32 w-72 h-72 rounded-full bg-gold/10 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-24 left-16 w-96 h-96 rounded-full bg-accent/15 blur-3xl animate-pulse [animation-delay:1s]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 py-32 text-center md:text-left">
        <p class="text-gold font-mono text-xs tracking-[0.25em] uppercase mb-5" data-geo-country="<?php echo htmlspecialchars($country ?? 'MX'); ?>">
            🏗 Plataforma Inmobiliaria Premium · <?php echo htmlspecialchars($countryName); ?>
        </p>
        <h1 class="text-5xl md:text-7xl font-serif font-black leading-[1.05] mb-6 max-w-4xl">
            Propiedades de Lujo en
            <span class="text-gold italic"> <?php echo htmlspecialchars($countryName); ?></span>
        </h1>
        <p class="text-lg text-paper/75 mb-10 max-w-2xl leading-relaxed">
            Descubre una selección exclusiva de inmuebles premium con GEO targeting, SEO avanzado y experiencia de clase mundial.
        </p>

        <div class="flex flex-wrap gap-4">
            <a href="/venta"
               class="px-8 py-4 bg-gold text-ink font-bold rounded hover:bg-gold/90 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                Ver Propiedades
            </a>
            <a href="/contacto"
               class="px-8 py-4 border-2 border-paper/60 text-paper font-bold rounded hover:bg-paper hover:text-ink transition focus:outline-none focus-visible:ring-2 focus-visible:ring-paper">
                Hablar con un Agente
            </a>
        </div>

        <!-- GEO info badge -->
        <p class="mt-8 text-xs text-paper/40 font-mono">
            <span id="geoPhone"><?php echo htmlspecialchars($phone ?? '+52 55 4169 8259'); ?></span>
            &nbsp;·&nbsp; <?php echo htmlspecialchars($currency ?? 'MXN'); ?>
        </p>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 text-paper/40" aria-hidden="true">
        <span class="text-xs font-mono tracking-widest uppercase">scroll</span>
        <span class="block w-px h-8 bg-paper/30 animate-bounce"></span>
    </div>
</section>

<!-- ══════════════════════════════════
     2. BUSCADOR AJAX
     ══════════════════════════════════ -->
<section class="py-14 bg-white border-y border-rule" id="search" aria-label="Buscador de propiedades">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-8">
            <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">02 · Búsqueda</p>
            <h2 class="text-3xl font-serif font-bold">Encuentra tu propiedad ideal</h2>
        </div>

        <form id="searchForm" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3" role="search" aria-label="Filtros de búsqueda">
            <select name="type" class="px-4 py-3 border border-rule rounded-lg bg-white" aria-label="Tipo de propiedad">
                <option value="">Tipo</option>
                <option value="venta">Venta</option>
                <option value="renta">Renta</option>
                <option value="desarrollo">Desarrollo</option>
            </select>

            <select name="country" class="px-4 py-3 border border-rule rounded-lg bg-white" aria-label="País">
                <option value="MX" <?php if (($country ?? 'MX') === 'MX') echo 'selected'; ?>>México</option>
                <option value="CO" <?php if (($country ?? '') === 'CO') echo 'selected'; ?>>Colombia</option>
                <option value="CL" <?php if (($country ?? '') === 'CL') echo 'selected'; ?>>Chile</option>
            </select>

            <input type="number" name="min_price" placeholder="Precio mínimo"
                   class="px-4 py-3 border border-rule rounded-lg" aria-label="Precio mínimo">

            <input type="number" name="max_sqm" placeholder="m² máximo"
                   class="px-4 py-3 border border-rule rounded-lg" aria-label="Metros cuadrados máximo">

            <button type="submit"
                    class="px-6 py-3 bg-ink text-paper font-bold rounded-lg hover:bg-accent transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                Buscar
            </button>
        </form>

        <!-- Resultados AJAX -->
        <div id="searchResults" role="region" aria-live="polite" aria-label="Resultados de búsqueda"
             class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
        </div>
        <div id="searchLoader" aria-live="polite" class="mt-8 text-center text-muted hidden">
            <span class="inline-block w-6 h-6 border-2 border-gold border-t-transparent rounded-full animate-spin mr-2" aria-hidden="true"></span>
            Buscando propiedades…
        </div>
        <p id="searchEmpty" class="mt-8 text-center text-muted hidden">No se encontraron propiedades con esos filtros.</p>
    </div>
</section>

<!-- ══════════════════════════════════
     3. CAROUSEL — Propiedades destacadas
     ══════════════════════════════════ -->
<section class="py-20 bg-paper" id="destacadas" aria-label="Propiedades destacadas">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-end justify-between mb-12">
            <div>
                <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">03 · Destacadas</p>
                <h2 class="text-4xl font-serif font-bold">Propiedades Premium en <?php echo htmlspecialchars($countryName); ?></h2>
            </div>
            <div class="flex gap-2" role="group" aria-label="Controles del carrusel">
                <button id="prevSlide" aria-label="Anterior propiedad"
                        class="w-10 h-10 flex items-center justify-center border border-rule rounded-full hover:bg-ink hover:text-paper transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                    ‹
                </button>
                <button id="nextSlide" aria-label="Siguiente propiedad"
                        class="w-10 h-10 flex items-center justify-center border border-rule rounded-full hover:bg-ink hover:text-paper transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
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
                    <div class="bg-white border border-rule rounded-xl overflow-hidden hover:shadow-xl transition h-full flex flex-col">
                        <div class="aspect-[4/3] bg-gradient-to-br from-muted/20 to-rule overflow-hidden">
                            <img src="<?php echo htmlspecialchars($imgUrl); ?>"
                                 alt="<?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad destacada'); ?>"
                                 class="w-full h-full object-cover"
                                 loading="lazy"
                                 onerror="this.src='/images/property-fallback.svg'">
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-xl font-serif font-bold mb-1"><?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad'); ?></h3>
                            <p class="text-muted text-sm mb-4"><?php echo htmlspecialchars($prop['city'] ?? 'Ubicación'); ?></p>
                            <div class="flex gap-4 mb-4 text-sm flex-wrap">
                                <?php if ($prop['bedrooms'] ?? 0): ?>
                                <span><strong><?php echo (int)$prop['bedrooms']; ?></strong> Hab.</span>
                                <?php endif; ?>
                                <?php if ($prop['bathrooms'] ?? 0): ?>
                                <span><strong><?php echo (int)$prop['bathrooms']; ?></strong> Baños</span>
                                <?php endif; ?>
                                <?php if ($prop['sqm'] ?? 0): ?>
                                <span><strong><?php echo number_format($prop['sqm'], 0); ?></strong> m²</span>
                                <?php endif; ?>
                            </div>
                            <div class="mt-auto border-t border-rule pt-4">
                                <p class="text-2xl font-serif font-bold text-gold">
                                    <?php echo number_format($prop['price'] ?? 0, 0, '.', ','); ?>
                                    <span class="text-sm text-muted font-sans font-normal"><?php echo htmlspecialchars($prop['currency'] ?? $currency ?? 'MXN'); ?></span>
                                </p>
                            </div>
                            <a href="/venta?id=<?php echo (int)($prop['id'] ?? 0); ?>"
                               class="block mt-4 text-center py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Dots navigation -->
        <div class="flex justify-center gap-2 mt-6" role="tablist" aria-label="Navegación del carrusel">
            <?php foreach ($featured_properties as $idx => $prop): ?>
            <button role="tab"
                    aria-selected="<?php echo $idx === 0 ? 'true' : 'false'; ?>"
                    aria-controls="slide-<?php echo $idx; ?>"
                    data-slide="<?php echo $idx; ?>"
                    class="carousel-dot w-2 h-2 rounded-full transition <?php echo $idx === 0 ? 'bg-gold w-4' : 'bg-rule'; ?>"
                    aria-label="Ir a la propiedad <?php echo $idx + 1; ?>">
            </button>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-center text-muted py-12">No hay propiedades destacadas disponibles.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ══════════════════════════════════
     4. MAPA LEAFLET — Clusters por ciudad
     ══════════════════════════════════ -->
<section class="py-20 bg-ink text-paper" id="mapa" aria-label="Mapa de propiedades">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-10">
            <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">04 · Mapa</p>
            <h2 class="text-4xl font-serif font-bold">Propiedades por ubicación</h2>
            <p class="text-paper/60 mt-2">Explora propiedades disponibles en los tres mercados de HAVRE ESTATES.</p>
        </div>
        <div id="propertyMap" class="rounded-xl overflow-hidden border border-white/10"
             style="height:480px;" role="application" aria-label="Mapa interactivo de propiedades">
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     5. CONTADORES ANIMADOS
     ══════════════════════════════════ -->
<section class="py-20 bg-white" id="metricas" aria-label="Métricas de la empresa">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1 text-center">05 · Métricas</p>
        <h2 class="text-4xl font-serif font-bold text-center mb-14">Números que hablan</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center" id="statsGrid">
            <div class="stat-block">
                <p class="text-5xl font-serif font-black text-gold mb-2"
                   data-target="450" data-suffix="+" aria-label="450 propiedades listadas">0</p>
                <p class="text-muted font-mono text-sm uppercase tracking-wider">Propiedades Listadas</p>
            </div>
            <div class="stat-block">
                <p class="text-5xl font-serif font-black text-gold mb-2"
                   data-target="12000" data-suffix="+" aria-label="12000 clientes satisfechos">0</p>
                <p class="text-muted font-mono text-sm uppercase tracking-wider">Clientes Satisfechos</p>
            </div>
            <div class="stat-block">
                <p class="text-5xl font-serif font-black text-gold mb-2"
                   data-target="15" data-suffix=" años" aria-label="15 años en el mercado">0</p>
                <p class="text-muted font-mono text-sm uppercase tracking-wider">En el Mercado</p>
            </div>
            <div class="stat-block">
                <p class="text-5xl font-serif font-black text-gold mb-2"
                   data-target="3" data-suffix=" países" aria-label="3 países de operación">0</p>
                <p class="text-muted font-mono text-sm uppercase tracking-wider">Mercados Activos</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     6. TESTIMONIOS — schema Review
     ══════════════════════════════════ -->
<section class="py-20 bg-paper" id="testimonios" aria-label="Testimonios de clientes">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">06 · Testimonios</p>
        <h2 class="text-4xl font-serif font-bold mb-12">Lo que dicen nuestros clientes</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $testimonials = $testimonials ?? [
                ['author'=>'María Fernández','title'=>'Compradora, CDMX','rating'=>5,'body'=>'El proceso fue increíblemente ágil. Encontramos el penthouse perfecto en menos de 3 semanas.'],
                ['author'=>'Andrés Velásquez','title'=>'Inversionista, Bogotá','rating'=>5,'body'=>'La atención es de primer nivel y la plataforma me permitió comparar propiedades en tiempo real.'],
                ['author'=>'Valentina Lagos','title'=>'Arrendataria, Santiago','rating'=>5,'body'=>'Excelente servicio. El chat en tiempo real con los agentes marcó la diferencia.'],
            ];
            ?>
            <?php foreach ($testimonials as $t): ?>
            <article class="bg-white border border-rule rounded-xl p-6 flex flex-col" itemscope itemtype="https://schema.org/Review">
                <div class="flex gap-1 mb-4" aria-label="Calificación <?php echo (int)$t['rating']; ?> de 5 estrellas">
                    <?php for ($s = 0; $s < ($t['rating'] ?? 5); $s++): ?>
                    <span class="text-gold" aria-hidden="true">★</span>
                    <?php endfor; ?>
                </div>
                <blockquote class="text-sm text-ink/80 leading-relaxed flex-1 mb-4" itemprop="reviewBody">
                    "<?php echo htmlspecialchars($t['body']); ?>"
                </blockquote>
                <footer>
                    <p class="font-semibold font-serif" itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <span itemprop="name"><?php echo htmlspecialchars($t['author']); ?></span>
                    </p>
                    <p class="text-xs text-muted"><?php echo htmlspecialchars($t['title']); ?></p>
                </footer>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     7. NEWSLETTER (existente)
     ══════════════════════════════════ -->
<section class="py-16 bg-white border-t border-rule" aria-label="Suscripción al newsletter">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-8">
            <p class="text-gold font-mono text-xs tracking-widest uppercase mb-2">07 · Newsletter</p>
            <h2 class="text-3xl font-serif font-bold mb-3">Recibe Nuevas Propiedades Premium</h2>
            <p class="text-muted">Actualizaciones semanales por país, tipo de propiedad y rangos de precio.</p>
        </div>

        <?php if (($newsletter_status ?? '') === 'ok'): ?>
            <div role="alert" class="mb-4 p-3 border border-green-300 bg-green-50 text-green-800 rounded-lg text-sm">Suscripción completada con éxito.</div>
        <?php elseif (($newsletter_status ?? '') === 'invalid_email'): ?>
            <div role="alert" class="mb-4 p-3 border border-red-300 bg-red-50 text-red-700 rounded-lg text-sm">Correo inválido. Intenta de nuevo.</div>
        <?php elseif (($newsletter_status ?? '') === 'rate_limited'): ?>
            <div role="alert" class="mb-4 p-3 border border-amber-300 bg-amber-50 text-amber-800 rounded-lg text-sm">Demasiados intentos. Espera antes de reintentar.</div>
        <?php elseif (($newsletter_status ?? '') === 'csrf_error'): ?>
            <div role="alert" class="mb-4 p-3 border border-red-300 bg-red-50 text-red-700 rounded-lg text-sm">Sesión inválida. Recarga la página.</div>
        <?php elseif (($newsletter_status ?? '') === 'server_error'): ?>
            <div role="alert" class="mb-4 p-3 border border-red-300 bg-red-50 text-red-700 rounded-lg text-sm">No se pudo registrar la suscripción en este momento.</div>
        <?php endif; ?>

        <form action="/newsletter/subscribe" method="POST"
              class="grid grid-cols-1 md:grid-cols-3 gap-3 bg-paper border border-rule rounded-xl p-4">
            <input type="hidden" name="csrf_token"
                   value="<?php echo htmlspecialchars($newsletter_csrf_token ?? ''); ?>">
            <input type="text" name="name" placeholder="Nombre (opcional)"
                   class="px-4 py-3 border border-rule rounded-lg md:col-span-1">
            <input type="email" name="email" required placeholder="tu@email.com"
                   class="px-4 py-3 border border-rule rounded-lg md:col-span-1">
            <button type="submit"
                    class="px-4 py-3 bg-ink text-paper rounded-lg font-semibold hover:bg-accent transition md:col-span-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                Suscribirme
            </button>
            <!-- Honeypot anti-spam -->
            <div class="hidden" aria-hidden="true">
                <label for="website">No llenar</label>
                <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
            </div>
        </form>
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
