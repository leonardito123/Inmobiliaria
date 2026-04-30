<?php
/**
 * Venta Landing Page — 7 secciones del reto
 *
 * Variables: $properties, $pagination, $filters, $country_code, $currency, $seo_tags
 */
$canonicalBase = rtrim(getenv('APP_URL') ?: 'http://localhost:8000', '/');

function escHtml(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>

<!-- ══════════════════════════════════
     1. HERO — Parallax nativo CSS
     ══════════════════════════════════ -->
<section class="relative min-h-[60vh] flex items-end pb-20 overflow-hidden" aria-label="Hero Venta">
    <!-- Parallax layer (CSS, sin JS) -->
    <div class="absolute inset-0 bg-[url('/images/hero-venta-bg.svg')] bg-cover bg-center bg-fixed opacity-20" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-ink via-accent/70 to-ink" aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 text-paper">
        <nav aria-label="Breadcrumb" class="mb-6">
            <ol class="flex gap-2 text-xs font-mono text-paper/50" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" itemprop="item" class="hover:text-gold"><span itemprop="name">Inicio</span></a>
                    <meta itemprop="position" content="1">
                </li>
                <li aria-hidden="true">›</li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gold">Venta</span>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </nav>
        <p class="text-gold font-mono text-xs tracking-[0.25em] uppercase mb-3">01 · Propiedades en Venta</p>
        <h1 class="text-5xl md:text-6xl font-serif font-black leading-tight mb-4 max-w-3xl">
            Invierte en Propiedades <span class="text-gold italic">Premium</span>
        </h1>
        <p class="text-paper/70 text-lg max-w-2xl">
            Venta, preventa y oportunidades de inversión en <?php echo escHtml($country_code ?? 'MX'); ?> con paginación cursor y filtros en URL.
        </p>
    </div>
</section>

<!-- ══════════════════════════════════
     2. FILTROS AVANZADOS — URL state
     ══════════════════════════════════ -->
<section class="bg-white border-b border-rule sticky top-0 z-40 shadow-sm" id="filtros" aria-label="Filtros de propiedades">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <form id="filterForm" method="GET" action="/venta" role="search" aria-label="Filtrar propiedades">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                <div>
                    <label for="f_city" class="block text-xs font-semibold text-muted mb-1 uppercase tracking-wide">Ciudad</label>
                    <input id="f_city" type="text" name="city"
                           placeholder="CDMX, Bogotá…"
                           value="<?php echo escHtml($filters['city'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-rule rounded text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                </div>
                <div>
                    <label for="f_beds" class="block text-xs font-semibold text-muted mb-1 uppercase tracking-wide">Habitaciones</label>
                    <select id="f_beds" name="bedrooms" class="w-full px-3 py-2 border border-rule rounded text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gold">
                        <option value="">Todas</option>
                        <?php foreach ([1,2,3,4] as $n): ?>
                        <option value="<?php echo $n; ?>" <?php echo ($filters['bedrooms'] ?? '') == $n ? 'selected' : ''; ?>><?php echo $n; ?>+</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="f_pmin" class="block text-xs font-semibold text-muted mb-1 uppercase tracking-wide">Precio Mín</label>
                    <input id="f_pmin" type="number" name="price_min" placeholder="0"
                           value="<?php echo (int)($filters['price_min'] ?? 0) ?: ''; ?>"
                           min="0" class="w-full px-3 py-2 border border-rule rounded text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                </div>
                <div>
                    <label for="f_pmax" class="block text-xs font-semibold text-muted mb-1 uppercase tracking-wide">Precio Máx</label>
                    <input id="f_pmax" type="number" name="price_max" placeholder="Sin límite"
                           value="<?php echo (int)($filters['price_max'] ?? 0) ?: ''; ?>"
                           min="0" class="w-full px-3 py-2 border border-rule rounded text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                </div>
                <div>
                    <label for="f_sqm" class="block text-xs font-semibold text-muted mb-1 uppercase tracking-wide">m² mín</label>
                    <input id="f_sqm" type="number" name="sqm_min" placeholder="0"
                           value="<?php echo (int)($filters['sqm_min'] ?? 0) ?: ''; ?>"
                           min="0" class="w-full px-3 py-2 border border-rule rounded text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 bg-ink text-paper text-sm font-bold rounded hover:bg-accent transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                        Filtrar
                    </button>
                    <a href="/venta" class="py-2 px-3 border border-rule text-muted text-sm rounded hover:bg-paper transition" aria-label="Limpiar filtros">✕</a>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- ══════════════════════════════════
     3. GRID PRINCIPAL + COMPARADOR
     ══════════════════════════════════ -->
<section class="py-14 bg-paper" id="listado" aria-label="Listado de propiedades">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex items-center justify-between mb-8">
            <p class="text-sm text-muted font-mono">
                <?php echo count($properties ?? []); ?> propiedad(es) encontrada(s)
            </p>
            <!-- Comparador toggle -->
            <button id="toggleCompare"
                    aria-expanded="false"
                    class="text-xs font-mono border border-rule px-4 py-2 rounded hover:bg-ink hover:text-paper transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                Comparar propiedades (0/3)
            </button>
        </div>

        <?php if (!empty($properties)): ?>
        <div id="propertiesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($properties as $prop): ?>
            <article class="property-card bg-white border border-rule rounded-xl overflow-hidden hover:shadow-xl transition flex flex-col"
                     data-id="<?php echo (int)$prop['id']; ?>"
                     data-title="<?php echo escHtml($prop['meta_title'] ?? ''); ?>"
                     data-price="<?php echo (float)($prop['price'] ?? 0); ?>"
                     data-currency="<?php echo escHtml($prop['currency'] ?? $currency ?? 'MXN'); ?>"
                     data-beds="<?php echo (int)($prop['bedrooms'] ?? 0); ?>"
                     data-baths="<?php echo (int)($prop['bathrooms'] ?? 0); ?>"
                     data-sqm="<?php echo (float)($prop['sqm'] ?? 0); ?>"
                     itemscope itemtype="https://schema.org/RealEstateListing">

                <!-- Imagen -->
                <div class="aspect-[4/3] bg-gradient-to-br from-muted/10 to-rule overflow-hidden relative">
                    <img src="/images/properties/<?php echo escHtml($prop['slug'] ?? 'default'); ?>.svg"
                         alt="<?php echo escHtml($prop['meta_title'] ?? 'Propiedad en venta'); ?>"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.src='/images/property-fallback.svg'">
                    <?php if ($prop['featured'] ?? false): ?>
                    <span class="absolute top-3 left-3 bg-gold text-ink text-xs font-bold px-2 py-1 rounded">DESTACADO</span>
                    <?php endif; ?>
                    <!-- Compare checkbox -->
                    <label class="absolute top-3 right-3 cursor-pointer compare-label hidden"
                           aria-label="Añadir al comparador">
                        <input type="checkbox" class="compare-cb sr-only" data-id="<?php echo (int)$prop['id']; ?>">
                        <span class="w-6 h-6 rounded border-2 border-paper bg-ink/60 flex items-center justify-center text-paper text-xs compare-icon">+</span>
                    </label>
                </div>

                <!-- Info -->
                <div class="p-5 flex flex-col flex-1">
                    <h2 class="font-serif font-bold text-lg mb-1" itemprop="name">
                        <?php echo escHtml($prop['meta_title'] ?? 'Propiedad'); ?>
                    </h2>
                    <p class="text-muted text-sm mb-3" itemprop="description">
                        <?php echo escHtml($prop['city'] ?? ''); ?>
                    </p>
                    <div class="flex gap-4 text-sm mb-3 flex-wrap">
                        <?php if ($prop['bedrooms'] ?? 0): ?><span><strong><?php echo (int)$prop['bedrooms']; ?></strong> hab.</span><?php endif; ?>
                        <?php if ($prop['bathrooms'] ?? 0): ?><span><strong><?php echo (int)$prop['bathrooms']; ?></strong> baños</span><?php endif; ?>
                        <?php if ($prop['sqm'] ?? 0): ?><span><strong><?php echo number_format($prop['sqm'], 0); ?></strong> m²</span><?php endif; ?>
                    </div>
                    <div class="mt-auto border-t border-rule pt-4">
                        <p class="text-2xl font-serif font-bold text-gold" itemprop="price">
                            <?php echo number_format($prop['price'] ?? 0, 0, '.', ','); ?>
                            <span class="text-sm font-sans font-normal text-muted"><?php echo escHtml($prop['currency'] ?? $currency ?? 'MXN'); ?></span>
                        </p>
                    </div>
                    <button class="open-modal mt-4 w-full py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-ink"
                            data-id="<?php echo (int)$prop['id']; ?>">
                        Ver Detalles
                    </button>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Load more cursor-based -->
        <?php if ($pagination['has_more'] ?? false): ?>
        <div class="flex justify-center mt-12">
            <button id="loadMoreBtn"
                    data-cursor="<?php echo escHtml($pagination['next_cursor'] ?? ''); ?>"
                    data-filters="<?php echo escHtml(json_encode($filters ?? [])); ?>"
                    class="px-10 py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                Cargar más propiedades
            </button>
        </div>
        <?php endif; ?>
        <?php else: ?>
        <div class="text-center py-20">
            <p class="text-2xl font-serif font-bold mb-3">Sin resultados</p>
            <p class="text-muted mb-6">Ajusta los filtros o limpia la búsqueda.</p>
            <a href="/venta" class="px-8 py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition">Limpiar filtros</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ══════════════════════════════════
     4. COMPARADOR SIDE-BY-SIDE (máx 3)
     ══════════════════════════════════ -->
<aside id="comparePanel"
       role="complementary"
       aria-label="Comparador de propiedades"
       aria-hidden="true"
       class="fixed bottom-0 left-0 right-0 bg-white border-t-4 border-gold shadow-2xl z-50 translate-y-full transition-transform duration-300"
       style="max-height:70vh; overflow-y:auto;">
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-serif font-bold text-xl">Comparador de propiedades</h2>
            <button id="closeCompare" aria-label="Cerrar comparador" class="text-muted hover:text-ink text-2xl leading-none focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">×</button>
        </div>
        <div id="compareGrid" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Rellenado por JS -->
        </div>
    </div>
</aside>

<!-- ══════════════════════════════════
     5. MODAL — Detalle de propiedad + JSON-LD
     ══════════════════════════════════ -->
<div id="propertyModal"
     role="dialog"
     aria-modal="true"
     aria-label="Detalle de propiedad"
     aria-hidden="true"
     class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-ink/70 backdrop-blur-sm" id="modalOverlay"></div>
    <div class="relative max-w-2xl mx-auto my-16 bg-white rounded-xl shadow-2xl overflow-hidden mx-4">
        <button id="closeModal"
                aria-label="Cerrar detalle"
                class="absolute top-4 right-4 text-muted hover:text-ink text-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">×</button>
        <div id="modalContent" class="p-8">
            <!-- Contenido dinámico vía JS -->
        </div>
    </div>
</div>

<!-- ══════════════════════════════════
     6. CALCULADORA DE HIPOTECA (Alpine.js)
     ══════════════════════════════════ -->
<section class="py-20 bg-ink text-paper" id="hipoteca" aria-label="Calculadora de hipoteca">
    <div class="max-w-4xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">06 · Calculadora</p>
        <h2 class="text-4xl font-serif font-bold mb-10">Simula tu financiamiento</h2>

        <div x-data="{
            precio: 3000000,
            enganche: 20,
            plazo: 20,
            tasa: 10.5,
            get enganchemx()   { return this.precio * this.enganche / 100; },
            get prestamo()     { return this.precio - this.enganchemx; },
            get mensualidad()  {
                const r = (this.tasa / 100) / 12;
                const n = this.plazo * 12;
                if (r === 0) return this.prestamo / n;
                return this.prestamo * r * Math.pow(1+r,n) / (Math.pow(1+r,n) - 1);
            },
            get totalPagar()   { return this.mensualidad * this.plazo * 12; },
            fmt(n) { return Math.round(n).toLocaleString('es-MX'); }
        }" class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <!-- Inputs -->
            <div class="space-y-6">
                <div>
                    <label class="block text-paper/70 text-sm mb-2">Precio de la propiedad: <strong class="text-gold" x-text="'$' + fmt(precio)"></strong></label>
                    <input type="range" x-model.number="precio" min="500000" max="20000000" step="100000"
                           class="w-full accent-gold" aria-label="Precio de la propiedad">
                </div>
                <div>
                    <label class="block text-paper/70 text-sm mb-2">Enganche: <strong class="text-gold" x-text="enganche + '%'"></strong> (<span x-text="'$' + fmt(enganchemx)"></span>)</label>
                    <input type="range" x-model.number="enganche" min="10" max="50" step="1"
                           class="w-full accent-gold" aria-label="Porcentaje de enganche">
                </div>
                <div>
                    <label class="block text-paper/70 text-sm mb-2">Plazo: <strong class="text-gold" x-text="plazo + ' años'"></strong></label>
                    <input type="range" x-model.number="plazo" min="5" max="30" step="1"
                           class="w-full accent-gold" aria-label="Plazo en años">
                </div>
                <div>
                    <label class="block text-paper/70 text-sm mb-2">Tasa anual: <strong class="text-gold" x-text="tasa + '%'"></strong></label>
                    <input type="range" x-model.number="tasa" min="5" max="20" step="0.1"
                           class="w-full accent-gold" aria-label="Tasa de interés anual">
                </div>
            </div>

            <!-- Resultados -->
            <div class="bg-white/10 rounded-xl p-6 flex flex-col justify-center gap-6">
                <div>
                    <p class="text-paper/50 text-xs uppercase tracking-widest font-mono mb-1">Mensualidad estimada</p>
                    <p class="text-5xl font-serif font-black text-gold" aria-live="polite" x-text="'$' + fmt(mensualidad)"></p>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-paper/50 text-xs uppercase tracking-wider font-mono mb-1">Préstamo</p>
                        <p class="font-bold text-lg" x-text="'$' + fmt(prestamo)"></p>
                    </div>
                    <div>
                        <p class="text-paper/50 text-xs uppercase tracking-wider font-mono mb-1">Total a pagar</p>
                        <p class="font-bold text-lg" x-text="'$' + fmt(totalPagar)"></p>
                    </div>
                </div>
                <p class="text-paper/30 text-xs">Cálculo referencial. Consulta con tu institución financiera.</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     7. CTA FLOTANTE — scroll-trigger
     ══════════════════════════════════ -->
<div id="floatingCta"
     role="complementary"
     aria-label="Contactar agente"
     class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-2 translate-y-20 opacity-0 transition-all duration-500">
    <div class="bg-white border border-rule rounded-xl shadow-xl p-4 w-64 text-sm">
        <p class="font-serif font-bold mb-1">¿Te interesa alguna propiedad?</p>
        <p class="text-muted text-xs mb-3">Nuestros agentes están disponibles ahora.</p>
        <a href="/contacto"
           class="block w-full text-center py-2 bg-gold text-ink font-bold rounded hover:bg-gold/90 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
            Hablar con un agente
        </a>
    </div>
    <button id="closeCta" aria-label="Cerrar" class="bg-white border border-rule rounded-full w-8 h-8 flex items-center justify-center text-muted hover:text-ink text-sm shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">×</button>
</div>

<script>
(function () {
    'use strict';

    // ── HELPERS ──
    function escHtml(str) {
        const d = document.createElement('div');
        d.appendChild(document.createTextNode(str));
        return d.innerHTML;
    }

    // ── FILTROS — sync URL state con history API ───────────────────
    const filterForm = document.getElementById('filterForm');
    filterForm?.addEventListener('submit', function (e) {
        e.preventDefault();
        const params = new URLSearchParams(new FormData(filterForm));
        // Limpiar parámetros vacíos
        for (const [k, v] of [...params.entries()]) {
            if (!v) params.delete(k);
        }
        const newUrl = '/venta?' + params.toString();
        window.history.pushState({}, '', newUrl);
        window.location.href = newUrl;
    });

    window.addEventListener('popstate', function () { window.location.reload(); });

    // ── LOAD MORE (cursor-based) ───────────────────────────────────
    const loadBtn = document.getElementById('loadMoreBtn');
    loadBtn?.addEventListener('click', async function () {
        const cursor  = this.dataset.cursor;
        const filters = JSON.parse(this.dataset.filters || '{}');
        const params  = new URLSearchParams({ cursor, ...filters });

        this.disabled    = true;
        this.textContent = 'Cargando…';

        try {
            const r    = await fetch('/venta/load-more?' + params, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await r.json();

            if (!data.properties?.length) { this.textContent = 'Sin más propiedades'; return; }

            const grid = document.getElementById('propertiesGrid');
            data.properties.forEach(function (p) {
                const art = document.createElement('article');
                art.className = 'property-card bg-white border border-rule rounded-xl overflow-hidden hover:shadow-xl transition flex flex-col';
                art.dataset.id       = p.id;
                art.dataset.title    = p.meta_title || '';
                art.dataset.price    = p.price || 0;
                art.dataset.currency = p.currency || 'MXN';
                art.dataset.beds     = p.bedrooms || 0;
                art.dataset.baths    = p.bathrooms || 0;
                art.dataset.sqm      = p.sqm || 0;
                art.innerHTML =
                    '<div class="aspect-[4/3] bg-rule overflow-hidden">' +
                        '<img src="/images/properties/' + escHtml(p.slug || 'default') + '.svg" ' +
                             'alt="' + escHtml(p.meta_title || 'Propiedad') + '" ' +
                             'class="w-full h-full object-cover" loading="lazy" ' +
                             'onerror="this.src=\'/images/property-fallback.svg\'">' +
                    '</div>' +
                    '<div class="p-5 flex flex-col flex-1">' +
                        '<h2 class="font-serif font-bold text-lg mb-1">' + escHtml(p.meta_title || '') + '</h2>' +
                        '<p class="text-muted text-sm mb-3">' + escHtml(p.city || '') + '</p>' +
                        '<div class="mt-auto border-t border-rule pt-4">' +
                            '<p class="text-2xl font-serif font-bold text-gold">' +
                                Number(p.price || 0).toLocaleString('es-MX', { maximumFractionDigits: 0 }) +
                                ' <span class="text-sm font-sans font-normal text-muted">' + escHtml(p.currency || 'MXN') + '</span>' +
                            '</p>' +
                        '</div>' +
                        '<button class="open-modal mt-4 w-full py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition text-sm" data-id="' + (p.id | 0) + '">Ver Detalles</button>' +
                    '</div>';
                grid.appendChild(art);
                bindModalBtn(art.querySelector('.open-modal'));
                bindCompareLabel(art);
            });

            if (data.has_more && data.next_cursor) {
                this.dataset.cursor = data.next_cursor;
                this.disabled       = false;
                this.textContent    = 'Cargar más propiedades';
                const url = new URL(window.location.href);
                url.searchParams.set('cursor', data.next_cursor);
                window.history.pushState({ cursor: data.next_cursor }, '', url.toString());
            } else {
                this.textContent = 'No hay más propiedades';
            }
        } catch (_) {
            this.disabled    = false;
            this.textContent = 'Error. Reintentar';
        }
    });

    // ── MODAL ─────────────────────────────────────────────────────
    const modal       = document.getElementById('propertyModal');
    const modalContent = document.getElementById('modalContent');

    function openModal(propData) {
        modalContent.innerHTML =
            '<h2 class="text-2xl font-serif font-bold mb-2">' + escHtml(propData.title) + '</h2>' +
            '<p class="text-muted text-sm mb-4">' + escHtml(propData.city || '') + '</p>' +
            '<div class="grid grid-cols-3 gap-4 mb-6 text-sm">' +
                '<div class="text-center p-3 bg-paper rounded border border-rule"><strong>' + propData.beds + '</strong><br>Hab.</div>' +
                '<div class="text-center p-3 bg-paper rounded border border-rule"><strong>' + propData.baths + '</strong><br>Baños</div>' +
                '<div class="text-center p-3 bg-paper rounded border border-rule"><strong>' + Number(propData.sqm).toLocaleString('es-MX') + '</strong><br>m²</div>' +
            '</div>' +
            '<p class="text-3xl font-serif font-black text-gold mb-6">' +
                Number(propData.price).toLocaleString('es-MX', { maximumFractionDigits: 0 }) + ' ' + escHtml(propData.currency) +
            '</p>' +
            '<a href="/contacto" class="block w-full text-center py-3 bg-gold text-ink font-bold rounded hover:bg-gold/90 transition">Solicitar información</a>';

        // Inject JSON-LD Product schema
        let ldScript = document.getElementById('modalLd');
        if (!ldScript) { ldScript = document.createElement('script'); ldScript.id = 'modalLd'; ldScript.type = 'application/ld+json'; document.head.appendChild(ldScript); }
        ldScript.textContent = JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'RealEstateListing',
            name: propData.title,
            price: propData.price,
            priceCurrency: propData.currency,
            numberOfBedrooms: propData.beds,
        });

        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        document.getElementById('closeModal').focus();
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.getElementById('closeModal')?.addEventListener('click', closeModal);
    document.getElementById('modalOverlay')?.addEventListener('click', closeModal);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });

    function bindModalBtn(btn) {
        if (!btn) return;
        btn.addEventListener('click', function () {
            const card = this.closest('.property-card');
            if (!card) return;
            openModal({
                id:       card.dataset.id,
                title:    card.dataset.title,
                price:    parseFloat(card.dataset.price),
                currency: card.dataset.currency,
                beds:     parseInt(card.dataset.beds, 10),
                baths:    parseInt(card.dataset.baths, 10),
                sqm:      parseFloat(card.dataset.sqm),
                city:     card.querySelector('.text-muted')?.textContent || '',
            });
        });
    }

    document.querySelectorAll('.open-modal').forEach(bindModalBtn);

    // ── COMPARADOR (máx 3) ────────────────────────────────────────
    const comparePanel  = document.getElementById('comparePanel');
    const compareGrid   = document.getElementById('compareGrid');
    const toggleCompare = document.getElementById('toggleCompare');
    const closeCompare  = document.getElementById('closeCompare');
    const selected      = new Map(); // id → dataset

    function updateComparePanel() {
        toggleCompare.setAttribute('aria-expanded', selected.size > 0 ? 'true' : 'false');
        toggleCompare.textContent = 'Comparar propiedades (' + selected.size + '/3)';

        if (!selected.size) {
            comparePanel.classList.add('translate-y-full');
            comparePanel.setAttribute('aria-hidden', 'true');
            return;
        }

        comparePanel.classList.remove('translate-y-full');
        comparePanel.setAttribute('aria-hidden', 'false');

        compareGrid.innerHTML = '';
        selected.forEach(function (d) {
            const col = document.createElement('div');
            col.className = 'bg-paper border border-rule rounded-xl p-4 text-sm';
            col.innerHTML =
                '<p class="font-serif font-bold mb-2">' + escHtml(d.title) + '</p>' +
                '<p class="text-muted text-xs mb-2">' + escHtml(d.city || '') + '</p>' +
                '<p class="text-gold font-bold text-xl mb-2">' + Number(d.price).toLocaleString('es-MX', { maximumFractionDigits: 0 }) + ' ' + escHtml(d.currency) + '</p>' +
                '<div class="grid grid-cols-3 gap-2 text-center text-xs">' +
                    '<div class="p-2 bg-white rounded border"><strong>' + d.beds + '</strong><br>Hab.</div>' +
                    '<div class="p-2 bg-white rounded border"><strong>' + d.baths + '</strong><br>Baños</div>' +
                    '<div class="p-2 bg-white rounded border"><strong>' + Number(d.sqm).toLocaleString('es-MX') + '</strong><br>m²</div>' +
                '</div>';
            compareGrid.appendChild(col);
        });
    }

    function bindCompareLabel(card) {
        const cb = card.querySelector('.compare-cb');
        const label = card.querySelector('.compare-label');
        if (!cb || !label) return;
        cb.addEventListener('change', function () {
            const id = this.dataset.id;
            if (this.checked) {
                if (selected.size >= 3) { this.checked = false; alert('Máximo 3 propiedades en el comparador.'); return; }
                selected.set(id, { ...card.dataset, city: card.querySelector('.text-muted')?.textContent || '' });
                card.querySelector('.compare-icon').textContent = '✓';
            } else {
                selected.delete(id);
                card.querySelector('.compare-icon').textContent = '+';
            }
            updateComparePanel();
        });
    }

    toggleCompare.addEventListener('click', function () {
        const active = this.getAttribute('aria-expanded') === 'true';
        if (active) {
            comparePanel.classList.add('translate-y-full');
        } else if (selected.size) {
            comparePanel.classList.remove('translate-y-full');
        }
        this.setAttribute('aria-expanded', String(!active && !!selected.size));
        // Show compare checkboxes
        document.querySelectorAll('.compare-label').forEach(function (l) { l.classList.toggle('hidden'); });
    });

    closeCompare.addEventListener('click', function () {
        comparePanel.classList.add('translate-y-full');
        comparePanel.setAttribute('aria-hidden', 'true');
        toggleCompare.setAttribute('aria-expanded', 'false');
        document.querySelectorAll('.compare-label').forEach(function (l) { l.classList.add('hidden'); });
    });

    document.querySelectorAll('.property-card').forEach(bindCompareLabel);

    // ── CTA FLOTANTE — scroll trigger ─────────────────────────────
    const floatingCta = document.getElementById('floatingCta');
    let ctaDismissed  = false;

    document.getElementById('closeCta')?.addEventListener('click', function () {
        ctaDismissed = true;
        floatingCta.style.display = 'none';
    });

    window.addEventListener('scroll', function () {
        if (ctaDismissed || !floatingCta) return;
        if (window.scrollY > 600) {
            floatingCta.style.transform = 'translateY(0)';
            floatingCta.style.opacity   = '1';
        } else {
            floatingCta.style.transform = 'translateY(5rem)';
            floatingCta.style.opacity   = '0';
        }
    }, { passive: true });
})();
</script>
