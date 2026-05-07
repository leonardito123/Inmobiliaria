<?php
/**
 * Venta Landing Page — Diseño consistente con HAVRE ESTATES
 *
 * Variables: $properties, $pagination, $filters, $country_code, $currency, $seo_tags
 */
$canonicalBase = rtrim(getenv('APP_URL') ?: 'http://localhost:8000', '/');

function escHtml(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

$countryLabel = match($country_code ?? 'MX') {
    'CO' => 'Colombia',
    'CL' => 'Chile',
    default => 'México',
};

function resolveVentaReferenceImage(string $title): string {
    $t = mb_strtolower($title, 'UTF-8');
    $t = strtr($t, [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n',
    ]);
    $referenceMap = [
        ['keys' => ['reforma', 'penthouse', ' ph ', 'roof', 'atico'], 'img' => '/images/venta-referencias/luxury-penthouse.jpg'],
        ['keys' => ['roma', 'laureles', 'loft', 'studio'], 'img' => '/images/venta-referencias/modern-loft.jpg'],
        ['keys' => ['lomas', 'casa', 'residencial', 'villa'], 'img' => '/images/venta-referencias/family-house.jpg'],
        ['keys' => ['nunoa', 'vitacura', 'depto', 'departamento', 'apto', 'apartamento'], 'img' => '/images/venta-referencias/urban-apartment.jpg'],
        ['keys' => ['polanco', 'andes', 'torre', 'edificio', 'desarrollo', 'investment'], 'img' => '/images/venta-referencias/investment-building.jpg'],
    ];

    foreach ($referenceMap as $rule) {
        foreach ($rule['keys'] as $k) {
            if (str_contains($t, $k)) {
                return $rule['img'];
            }
        }
    }

    return '/images/venta-referencias/premium-interior.jpg';
}

function resolveVentaInteriorImage(string $title): string {
    $t = mb_strtolower($title, 'UTF-8');
    $t = strtr($t, [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n',
    ]);
    $referenceMap = [
        ['keys' => ['reforma', 'penthouse', ' ph ', 'roof', 'atico'], 'img' => '/images/venta-interiores/interior-penthouse.jpg'],
        ['keys' => ['roma', 'laureles', 'loft', 'studio'], 'img' => '/images/venta-interiores/interior-loft.jpg'],
        ['keys' => ['lomas', 'casa', 'residencial', 'villa'], 'img' => '/images/venta-interiores/interior-family.jpg'],
        ['keys' => ['nunoa', 'vitacura', 'depto', 'departamento', 'apto', 'apartamento'], 'img' => '/images/venta-interiores/interior-apartment.jpg'],
        ['keys' => ['polanco', 'andes', 'torre', 'edificio', 'desarrollo', 'investment'], 'img' => '/images/venta-interiores/interior-investment.jpg'],
    ];

    foreach ($referenceMap as $rule) {
        foreach ($rule['keys'] as $k) {
            if (str_contains($t, $k)) {
                return $rule['img'];
            }
        }
    }

    return '/images/venta-interiores/interior-premium.jpg';
}
?>

<!-- 1. HERO -->
<section class="relative min-h-[58vh] flex items-end pb-20 overflow-hidden bg-ink" aria-label="Hero Venta" id="ventaHero">
    <!-- Carrusel de fondo -->
    <div class="absolute inset-0" id="ventaCarousel" aria-hidden="true">
        <?php
        $ventaSlides = [
            ['img' => '/images/hero/cdmx-hero-2.jpg', 'alt' => 'Propiedades premium en venta — CDMX noche'],
            ['img' => '/images/hero/cdmx-hero-1.jpg', 'alt' => 'Skyline de Ciudad de México al atardecer'],
            ['img' => '/images/hero/cdmx-hero-3.jpg', 'alt' => 'Arquitectura moderna para inversión'],
            ['img' => '/images/hero/cdmx-hero-4.jpg', 'alt' => 'Desarrollos y penthouses con plusvalía'],
        ];
        foreach ($ventaSlides as $vi => $vs):
        ?>
        <div class="venta-slide absolute inset-0 transition-opacity duration-1000 <?php echo $vi === 0 ? 'opacity-100' : 'opacity-0'; ?>">
            <img src="<?php echo $vs['img']; ?>" alt="<?php echo escHtml($vs['alt']); ?>"
                 class="w-full h-full object-cover opacity-40"
                 <?php echo $vi === 0 ? 'loading="eager"' : 'loading="lazy"'; ?>>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="absolute inset-0 bg-gradient-to-br from-black/90 via-black/60 to-black/80" aria-hidden="true"></div>
    <div class="absolute top-0 right-0 w-1/2 h-2/3 bg-amber-900/20 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 w-full">
        <nav aria-label="Breadcrumb" class="mb-8">
            <ol class="flex gap-2 text-[11px] font-mono text-paper/40 tracking-[0.15em]"
                itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" itemprop="item" class="hover:text-gold transition-colors"><span itemprop="name">INICIO</span></a>
                    <meta itemprop="position" content="1">
                </li>
                <li aria-hidden="true" class="text-paper/20">›</li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gold">VENTA</span>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </nav>
        <p class="font-mono text-[11px] tracking-[0.28em] uppercase text-gold/90 mb-5 flex items-center gap-3">
            <span>01 · Propiedades en Venta</span>
            <span class="text-gold/40" aria-hidden="true">·</span>
            <span class="border border-gold/40 px-3 py-0.5 text-paper/80 tracking-[0.12em]"><?php echo escHtml($countryLabel); ?></span>
        </p>
        <h1 class="font-serif font-black uppercase tracking-[0.03em] leading-[0.92] text-paper mb-6"
            style="font-size:clamp(2.4rem,6vw,5rem);text-shadow:0 8px 30px rgba(0,0,0,.8);">
            Propiedades<br><span class="text-gold">Premium en Venta</span>
        </h1>
        <div class="w-20 h-px bg-gold mb-6" aria-hidden="true"></div>
        <p class="text-paper/55 text-sm max-w-xl leading-relaxed font-light">
            Selección exclusiva de viviendas, penthouses y desarrollos con plusvalía en <?php echo escHtml($countryLabel); ?>.
        </p>
    </div>
</section>

<!-- 2. FILTROS dark theme -->
<section class="bg-black border-b border-white/8 sticky top-0 z-40" id="filtros" aria-label="Filtros">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-4">
        <form id="filterForm" method="GET" action="/venta" role="search" aria-label="Filtrar propiedades">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 items-end">
                <div>
                    <label for="f_city" class="block font-mono text-[9px] tracking-[0.3em] uppercase text-paper/40 mb-1.5">Ciudad</label>
                    <input id="f_city" type="text" name="city" placeholder="CDMX, Bogotá…"
                           value="<?php echo escHtml($filters['city'] ?? ''); ?>"
                           class="w-full px-3 py-2 bg-white/5 border border-white/12 text-paper text-xs placeholder:text-paper/25 focus:outline-none focus:border-gold/50 transition">
                </div>
                <div>
                    <label for="f_beds" class="block font-mono text-[9px] tracking-[0.3em] uppercase text-paper/40 mb-1.5">Recámaras</label>
                    <select id="f_beds" name="bedrooms"
                            class="w-full px-3 py-2 bg-white/5 border border-white/12 text-paper text-xs focus:outline-none focus:border-gold/50 transition appearance-none">
                        <option value="" class="bg-ink">Todas</option>
                        <?php foreach ([1,2,3,4] as $n): ?>
                        <option value="<?php echo $n; ?>" class="bg-ink" <?php echo ($filters['bedrooms'] ?? '') == $n ? 'selected' : ''; ?>><?php echo $n; ?>+</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="f_pmin" class="block font-mono text-[9px] tracking-[0.3em] uppercase text-paper/40 mb-1.5">Precio Mín</label>
                    <input id="f_pmin" type="number" name="price_min" placeholder="0"
                           value="<?php echo (int)($filters['price_min'] ?? 0) ?: ''; ?>" min="0"
                           class="w-full px-3 py-2 bg-white/5 border border-white/12 text-paper text-xs placeholder:text-paper/25 focus:outline-none focus:border-gold/50 transition">
                </div>
                <div>
                    <label for="f_pmax" class="block font-mono text-[9px] tracking-[0.3em] uppercase text-paper/40 mb-1.5">Precio Máx</label>
                    <input id="f_pmax" type="number" name="price_max" placeholder="Sin límite"
                           value="<?php echo (int)($filters['price_max'] ?? 0) ?: ''; ?>" min="0"
                           class="w-full px-3 py-2 bg-white/5 border border-white/12 text-paper text-xs placeholder:text-paper/25 focus:outline-none focus:border-gold/50 transition">
                </div>
                <div>
                    <label for="f_sqm" class="block font-mono text-[9px] tracking-[0.3em] uppercase text-paper/40 mb-1.5">m² mín</label>
                    <input id="f_sqm" type="number" name="sqm_min" placeholder="0"
                           value="<?php echo (int)($filters['sqm_min'] ?? 0) ?: ''; ?>" min="0"
                           class="w-full px-3 py-2 bg-white/5 border border-white/12 text-paper text-xs placeholder:text-paper/25 focus:outline-none focus:border-gold/50 transition">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 py-2 border border-gold/60 text-gold text-[10px] font-mono tracking-[0.25em] uppercase hover:bg-gold hover:text-ink transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                        Filtrar
                    </button>
                    <a href="/venta" class="py-2 px-3 border border-white/15 text-paper/40 text-xs font-mono hover:border-white/40 hover:text-paper/80 transition" aria-label="Limpiar filtros">✕</a>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- 3. GRID PROPIEDADES -->
<section class="py-20 bg-ink text-paper" id="listado" aria-label="Listado de propiedades">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-12">
            <div>
                <h2 class="font-serif font-black uppercase tracking-[0.06em] mb-1"
                    style="font-size:clamp(1.3rem,2.5vw,2rem);">Propiedades Disponibles</h2>
                <p class="font-mono text-[11px] tracking-[0.2em] text-paper/40 uppercase">
                    <?php echo count($properties ?? []); ?> resultado(s) en <?php echo escHtml($countryLabel); ?>
                </p>
            </div>
            <button id="toggleCompare" aria-expanded="false"
                    class="border border-white/15 text-paper/50 text-[10px] font-mono tracking-[0.25em] uppercase px-5 py-2.5 hover:border-gold/50 hover:text-gold transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                Comparar (0/3)
            </button>
        </div>

        <?php if (!empty($properties)): ?>
        <div id="propertiesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
            <?php foreach ($properties as $idx => $prop):
                $slug    = (string)($prop['slug'] ?? 'default');
                $title   = (string)($prop['meta_title'] ?? 'Propiedad');
                $imgSlug = str_replace('ñ', 'n', $slug);
                $imgJpg  = '/images/properties/' . $imgSlug . '.jpg';
                $imgSvg  = '/images/properties/' . $imgSlug . '.svg';
                $imgRef  = resolveVentaReferenceImage($title);
                $imgInterior = resolveVentaInteriorImage($title);
                $imgUrl  = file_exists(ROOT_PATH . '/public' . $imgJpg) ? $imgJpg : $imgRef;
            ?>
            <article class="venta-card bg-ink border border-white/8 overflow-hidden flex flex-col group opacity-0 translate-y-4"
                     style="transition:opacity .55s ease <?php echo $idx * 80; ?>ms,transform .55s ease <?php echo $idx * 80; ?>ms"
                     data-id="<?php echo (int)$prop['id']; ?>"
                     data-title="<?php echo escHtml($prop['meta_title'] ?? ''); ?>"
                     data-img="<?php echo escHtml($imgUrl); ?>"
                     data-interior="<?php echo escHtml($imgInterior); ?>"
                     data-price="<?php echo (float)($prop['price'] ?? 0); ?>"
                     data-currency="<?php echo escHtml($prop['currency'] ?? $currency ?? 'MXN'); ?>"
                     data-beds="<?php echo (int)($prop['bedrooms'] ?? 0); ?>"
                     data-baths="<?php echo (int)($prop['bathrooms'] ?? 0); ?>"
                     data-sqm="<?php echo (float)($prop['sqm'] ?? 0); ?>"
                     itemscope itemtype="https://schema.org/RealEstateListing">

                <div class="aspect-[4/3] overflow-hidden relative">
                    <img src="<?php echo escHtml($imgUrl); ?>"
                         alt="<?php echo escHtml($prop['meta_title'] ?? 'Propiedad en venta'); ?>"
                         class="w-full h-full object-cover opacity-85 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700"
                         loading="lazy"
                        onerror="this.onerror=null;this.src='<?php echo escHtml($imgRef); ?>'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 h-[2px] bg-gold w-0 group-hover:w-full transition-all duration-500 ease-out"></div>
                    <?php if ($prop['featured'] ?? false): ?>
                    <span class="absolute top-4 left-4 bg-gold text-ink text-[9px] font-mono font-bold tracking-[0.25em] uppercase px-3 py-1">DESTACADO</span>
                    <?php endif; ?>
                    <span class="absolute top-4 right-4 px-2.5 py-1 bg-black/60 backdrop-blur-sm text-gold text-[9px] font-mono tracking-[0.3em] uppercase translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 delay-100">
                        <?php echo escHtml($prop['city'] ?? ''); ?>
                    </span>
                    <label class="compare-label absolute bottom-4 right-4 cursor-pointer hidden" aria-label="Añadir al comparador">
                        <input type="checkbox" class="compare-cb sr-only" data-id="<?php echo (int)$prop['id']; ?>">
                        <span class="w-7 h-7 border border-paper/50 bg-black/70 backdrop-blur-sm flex items-center justify-center text-paper text-xs compare-icon hover:border-gold hover:text-gold transition-all">+</span>
                    </label>
                </div>

                <div class="flex flex-col flex-1 p-6 border-t border-white/5">
                    <p class="font-mono text-[9px] tracking-[0.3em] uppercase text-gold/80 mb-2 prop-city"><?php echo escHtml($prop['city'] ?? ''); ?></p>
                    <h2 class="font-serif font-black leading-tight mb-4 text-paper" style="font-size:clamp(1rem,2vw,1.25rem);" itemprop="name">
                        <?php echo escHtml($prop['meta_title'] ?? 'Propiedad'); ?>
                    </h2>
                    <div class="flex gap-5 text-[11px] font-mono text-paper/50 mb-5">
                        <?php if ($prop['bedrooms'] ?? 0): ?><span><?php echo (int)$prop['bedrooms']; ?> <span class="text-paper/30">rec.</span></span><?php endif; ?>
                        <?php if ($prop['bathrooms'] ?? 0): ?><span><?php echo (int)$prop['bathrooms']; ?> <span class="text-paper/30">baños</span></span><?php endif; ?>
                        <?php if ($prop['sqm'] ?? 0): ?><span><?php echo number_format((float)$prop['sqm'], 0); ?> <span class="text-paper/30">m²</span></span><?php endif; ?>
                    </div>
                    <div class="mt-auto border-t border-white/8 pt-5 mb-5">
                        <p class="font-serif font-black text-gold" style="font-size:clamp(1.4rem,2.5vw,1.9rem);" itemprop="price">
                            <?php echo number_format((float)($prop['price'] ?? 0), 0, '.', ','); ?>
                            <span class="text-[11px] text-paper/35 font-mono font-normal ml-1"><?php echo escHtml($prop['currency'] ?? $currency ?? 'MXN'); ?></span>
                        </p>
                    </div>
                    <button class="open-modal venta-btn relative overflow-hidden self-start px-7 py-3.5 border border-paper/25 text-paper text-[10px] font-mono tracking-[0.3em] uppercase hover:border-gold hover:text-gold transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold"
                            type="button">
                        <span class="relative z-10">VER DETALLES</span>
                        <span class="venta-shimmer absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/6 to-transparent" aria-hidden="true"></span>
                    </button>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <?php if ($pagination['has_more'] ?? false): ?>
        <div class="flex justify-center mt-16">
            <button id="loadMoreBtn"
                    data-cursor="<?php echo escHtml($pagination['next_cursor'] ?? ''); ?>"
                    data-filters="<?php echo escHtml(json_encode($filters ?? [])); ?>"
                    class="px-12 py-4 border border-paper/25 text-paper text-[10px] font-mono tracking-[0.3em] uppercase hover:border-gold hover:text-gold transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                Cargar más propiedades
            </button>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-24 border border-white/8">
            <p class="font-serif font-black uppercase tracking-[0.06em] text-paper mb-3" style="font-size:clamp(1.3rem,2.5vw,2rem);">Sin resultados</p>
            <div class="w-12 h-px bg-gold mx-auto mb-6"></div>
            <p class="text-paper/40 font-mono text-sm mb-8 tracking-wide">Ajusta los filtros o limpia la búsqueda.</p>
            <a href="/venta" class="px-10 py-3.5 border border-paper/25 text-paper text-[10px] font-mono tracking-[0.3em] uppercase hover:border-gold hover:text-gold transition-all duration-300">Limpiar filtros</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- 4. COMPARADOR dark -->
<aside id="comparePanel" role="complementary" aria-label="Comparador de propiedades" aria-hidden="true"
       class="fixed bottom-0 left-0 right-0 bg-black border-t-2 border-gold shadow-2xl z-50 text-paper translate-y-full transition-transform duration-300"
       style="max-height:70vh;overflow-y:auto;">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-serif font-black uppercase tracking-[0.06em]" style="font-size:clamp(1.1rem,2vw,1.5rem);">Comparador</h2>
            <button id="closeCompare" aria-label="Cerrar comparador" class="text-paper/40 hover:text-gold text-2xl leading-none focus:outline-none">×</button>
        </div>
        <div id="compareGrid" class="grid grid-cols-1 sm:grid-cols-3 gap-px bg-white/8"></div>
    </div>
</aside>

<!-- 5. MODAL dark -->
<div id="propertyModal" role="dialog" aria-modal="true" aria-label="Detalle de propiedad" aria-hidden="true" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" id="modalOverlay"></div>
    <div class="relative max-w-2xl mx-4 md:mx-auto mt-16 bg-ink border border-white/12 shadow-2xl overflow-hidden">
        <button id="closeModal" aria-label="Cerrar detalle" class="absolute top-5 right-5 text-paper/40 hover:text-gold text-2xl focus:outline-none transition-colors">×</button>
        <div id="modalContent" class="p-8 text-paper"></div>
    </div>
</div>

<!-- 6. CALCULADORA dark -->
<section class="py-24 bg-black text-paper border-t border-white/5" id="hipoteca" aria-label="Calculadora de hipoteca">
    <div class="max-w-6xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-14">
            <p class="font-mono text-[11px] tracking-[0.25em] uppercase text-gold/80 mb-4">06 · Herramienta</p>
            <h2 class="font-serif font-black uppercase tracking-[0.04em] mb-4" style="font-size:clamp(1.5rem,3vw,2.4rem);">
                Simula tu <span class="text-gold">Financiamiento</span>
            </h2>
            <div class="w-16 h-px bg-gold mx-auto"></div>
        </div>

        <div x-data="{
            precio:3000000,enganche:20,plazo:20,tasa:10.5,
            get enganchemx(){return this.precio*this.enganche/100;},
            get prestamo(){return this.precio-this.enganchemx;},
            get mensualidad(){const r=(this.tasa/100)/12,n=this.plazo*12;if(r===0)return this.prestamo/n;return this.prestamo*r*Math.pow(1+r,n)/(Math.pow(1+r,n)-1);},
            get totalPagar(){return this.mensualidad*this.plazo*12;},
            fmt(n){return Math.round(n).toLocaleString('es-MX');}
        }" class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-stretch">
            <div class="rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.03] to-transparent p-6 md:p-8 lg:p-10">
                <div class="space-y-7">
                    <div>
                        <label class="flex items-center justify-between gap-4 font-mono text-[10px] tracking-[0.18em] uppercase text-paper/55 mb-2.5">
                            <span>Precio</span>
                            <span class="text-gold" x-text="'$'+fmt(precio)"></span>
                        </label>
                        <input type="range" x-model.number="precio" min="500000" max="20000000" step="100000" class="w-full accent-gold" aria-label="Precio">
                    </div>
                    <div>
                        <label class="flex items-center justify-between gap-4 font-mono text-[10px] tracking-[0.18em] uppercase text-paper/55 mb-2.5">
                            <span>Enganche</span>
                            <span><span class="text-gold" x-text="enganche+'%'"></span> <span class="text-paper/35" x-text="'($'+fmt(enganchemx)+')'"></span></span>
                        </label>
                        <input type="range" x-model.number="enganche" min="10" max="50" step="1" class="w-full accent-gold" aria-label="Enganche">
                    </div>
                    <div>
                        <label class="flex items-center justify-between gap-4 font-mono text-[10px] tracking-[0.18em] uppercase text-paper/55 mb-2.5">
                            <span>Plazo</span>
                            <span class="text-gold" x-text="plazo+' años'"></span>
                        </label>
                        <input type="range" x-model.number="plazo" min="5" max="30" step="1" class="w-full accent-gold" aria-label="Plazo">
                    </div>
                    <div>
                        <label class="flex items-center justify-between gap-4 font-mono text-[10px] tracking-[0.18em] uppercase text-paper/55 mb-2.5">
                            <span>Tasa anual</span>
                            <span class="text-gold" x-text="tasa+'%'"></span>
                        </label>
                        <input type="range" x-model.number="tasa" min="5" max="20" step="0.1" class="w-full accent-gold" aria-label="Tasa">
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-6 md:p-8 lg:p-10 flex flex-col justify-between gap-6">
                <div>
                    <p class="font-mono text-[10px] tracking-[0.24em] uppercase text-paper/40 mb-2">Mensualidad estimada</p>
                    <p class="font-serif font-black text-gold leading-none" style="font-size:clamp(2.4rem,5vw,4rem);" aria-live="polite" x-text="'$'+fmt(mensualidad)"></p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="border border-white/10 p-4 md:p-5 rounded-lg bg-black/30">
                        <p class="font-mono text-[9px] tracking-[0.22em] uppercase text-paper/35 mb-1.5">Préstamo</p>
                        <p class="font-serif font-bold text-xl" x-text="'$'+fmt(prestamo)"></p>
                    </div>
                    <div class="border border-white/10 p-4 md:p-5 rounded-lg bg-black/30">
                        <p class="font-mono text-[9px] tracking-[0.22em] uppercase text-paper/35 mb-1.5">Total a pagar</p>
                        <p class="font-serif font-bold text-xl" x-text="'$'+fmt(totalPagar)"></p>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="font-mono text-[10px] text-paper/30 tracking-[0.08em] leading-relaxed">Cálculo referencial. Consulta con tu institución financiera.</p>
                    <a href="/contacto" class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-3.5 border border-gold/60 text-gold text-[10px] font-mono tracking-[0.28em] uppercase hover:bg-gold hover:text-ink transition-all duration-300">Solicitar asesoría</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. CTA FLOTANTE -->
<div id="floatingCta" role="complementary" aria-label="Contactar agente"
     class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-2 translate-y-20 opacity-0 transition-all duration-500">
    <div class="bg-ink border border-white/15 shadow-2xl p-5 w-64 text-sm text-paper">
        <p class="font-serif font-bold mb-1">¿Te interesa alguna?</p>
        <p class="font-mono text-[11px] text-paper/45 mb-4 tracking-wide leading-relaxed">Nuestros agentes disponibles ahora.</p>
        <a href="/contacto" class="block w-full text-center py-2.5 bg-gold text-ink text-[10px] font-mono tracking-[0.25em] uppercase hover:bg-gold/85 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">Hablar con un agente</a>
    </div>
    <button id="closeCta" aria-label="Cerrar" class="bg-ink border border-white/15 w-8 h-8 flex items-center justify-center text-paper/40 hover:text-gold text-sm shadow transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">×</button>
</div>

<style>
@keyframes venta-shimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(200%)} }
.venta-btn:hover .venta-shimmer { animation:venta-shimmer .65s ease forwards; }
.venta-card.is-visible { opacity:1!important; transform:translateY(0)!important; }
</style>

<script>
(function(){
    'use strict';

    function escHtml(str){var d=document.createElement('div');d.appendChild(document.createTextNode(str));return d.innerHTML;}
    function thematicImageByTitle(title){
        var t=(title||'').toLowerCase();
        if(t.normalize){t=t.normalize('NFD').replace(/[\u0300-\u036f]/g,'');}
        t=t.replace(/ñ/g,'n');
        if(/reforma|penthouse|\bph\b|roof|atico/.test(t)) return '/images/venta-referencias/luxury-penthouse.jpg';
        if(/roma|laureles|loft|studio/.test(t)) return '/images/venta-referencias/modern-loft.jpg';
        if(/lomas|casa|residencial|villa/.test(t)) return '/images/venta-referencias/family-house.jpg';
        if(/nunoa|vitacura|depto|departamento|apto|apartamento/.test(t)) return '/images/venta-referencias/urban-apartment.jpg';
        if(/polanco|andes|torre|edificio|desarrollo|investment/.test(t)) return '/images/venta-referencias/investment-building.jpg';
        return '/images/venta-referencias/premium-interior.jpg';
    }
    function thematicInteriorByTitle(title){
        var t=(title||'').toLowerCase();
        if(t.normalize){t=t.normalize('NFD').replace(/[\u0300-\u036f]/g,'');}
        t=t.replace(/ñ/g,'n');
        if(/reforma|penthouse|\bph\b|roof|atico/.test(t)) return '/images/venta-interiores/interior-penthouse.jpg';
        if(/roma|laureles|loft|studio/.test(t)) return '/images/venta-interiores/interior-loft.jpg';
        if(/lomas|casa|residencial|villa/.test(t)) return '/images/venta-interiores/interior-family.jpg';
        if(/nunoa|vitacura|depto|departamento|apto|apartamento/.test(t)) return '/images/venta-interiores/interior-apartment.jpg';
        if(/polanco|andes|torre|edificio|desarrollo|investment/.test(t)) return '/images/venta-interiores/interior-investment.jpg';
        return '/images/venta-interiores/interior-premium.jpg';
    }
    function toNum(v){
        var n=Number(v);
        return Number.isFinite(n) ? n : 0;
    }
    function fmtNum(v){
        return toNum(v).toLocaleString('es-MX',{maximumFractionDigits:0});
    }
    function safeText(v,fallback){
        var s=(v==null?'':String(v)).trim();
        return s || fallback;
    }

    // Fade-in on scroll
    var obs;
    if('IntersectionObserver' in window){
        obs=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('is-visible');obs.unobserve(e.target);}});},{threshold:0.1});
        document.querySelectorAll('.venta-card').forEach(function(el){obs.observe(el);});
    } else {
        document.querySelectorAll('.venta-card').forEach(function(el){el.classList.add('is-visible');});
    }

    // Filtros
    var filterForm=document.getElementById('filterForm');
    if(filterForm){filterForm.addEventListener('submit',function(e){e.preventDefault();var p=new URLSearchParams(new FormData(filterForm));[...p.entries()].forEach(function(kv){if(!kv[1])p.delete(kv[0]);});window.location.href='/venta?'+p.toString();});}
    window.addEventListener('popstate',function(){window.location.reload();});

    // Load more
    var loadBtn=document.getElementById('loadMoreBtn');
    if(loadBtn){loadBtn.addEventListener('click',async function(){
        var cursor=this.dataset.cursor,filters=JSON.parse(this.dataset.filters||'{}'),params=new URLSearchParams(Object.assign({cursor:cursor},filters));
        this.disabled=true;this.textContent='Cargando…';
        try{
            var r=await fetch('/venta/load-more?'+params,{headers:{'X-Requested-With':'XMLHttpRequest'}});
            var data=await r.json();
            if(!data.properties?.length){this.textContent='Sin más propiedades';return;}
            var grid=document.getElementById('propertiesGrid');
            data.properties.forEach(function(p){
                var art=document.createElement('article');
                art.className='venta-card bg-ink border border-white/8 overflow-hidden flex flex-col group opacity-0 translate-y-4';
                art.style.transition='opacity .55s ease,transform .55s ease';
                var thematicImg=thematicImageByTitle(p.meta_title||'');
                var interiorImg=thematicInteriorByTitle(p.meta_title||'');
                art.dataset.id=p.id;art.dataset.title=p.meta_title||'';art.dataset.price=p.price||0;
                art.dataset.currency=p.currency||'MXN';art.dataset.beds=p.bedrooms||0;art.dataset.baths=p.bathrooms||0;art.dataset.sqm=p.sqm||0;
                art.dataset.img=thematicImg;
                art.dataset.interior=interiorImg;
                var sl=(p.slug||'default').replace(/ñ/g,'n');
                art.innerHTML=
                    '<div class="aspect-[4/3] overflow-hidden relative">'+
                        '<img src="/images/properties/'+escHtml(sl)+'.jpg" alt="'+escHtml(p.meta_title||'Propiedad')+'" class="w-full h-full object-cover opacity-85 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700" loading="lazy" onerror="this.onerror=null;this.src=\''+escHtml(thematicImg)+'\'">'+
                        '<div class="absolute bottom-0 left-0 h-[2px] bg-gold w-0 group-hover:w-full transition-all duration-500"></div>'+
                    '</div>'+
                    '<div class="flex flex-col flex-1 p-6 border-t border-white/5">'+
                        '<p class="prop-city font-mono text-[9px] tracking-[0.3em] uppercase text-gold/80 mb-2">'+escHtml(p.city||'')+'</p>'+
                        '<h2 class="font-serif font-black leading-tight mb-4 text-paper">'+escHtml(p.meta_title||'')+'</h2>'+
                        '<div class="mt-auto border-t border-white/8 pt-5 mb-5"><p class="font-serif font-black text-gold" style="font-size:1.7rem">'+Number(p.price||0).toLocaleString('es-MX',{maximumFractionDigits:0})+' <span style="font-size:.65rem" class="text-paper/35 font-mono font-normal">'+escHtml(p.currency||'MXN')+'</span></p></div>'+
                        '<button class="open-modal venta-btn relative overflow-hidden self-start px-7 py-3.5 border border-paper/25 text-paper text-[10px] font-mono tracking-[0.3em] uppercase hover:border-gold hover:text-gold transition-all duration-300" type="button">'+
                            '<span class="relative z-10">VER DETALLES</span>'+
                            '<span class="venta-shimmer absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/6 to-transparent" aria-hidden="true"></span>'+
                        '</button>'+
                    '</div>';
                grid.appendChild(art);
                bindModalBtn(art.querySelector('.open-modal'));
                bindCompareLabel(art);
                obs&&obs.observe(art);
            });
            if(data.has_more&&data.next_cursor){this.dataset.cursor=data.next_cursor;this.disabled=false;this.textContent='Cargar más propiedades';}
            else{this.textContent='No hay más propiedades';}
        }catch(_){this.disabled=false;this.textContent='Error. Reintentar';}
    });}

    // Modal
    var modal=document.getElementById('propertyModal'),modalContent=document.getElementById('modalContent');
    function openModal(d){
        var title=safeText(d.title,'Propiedad premium');
        var city=safeText(d.city,'Ubicación por confirmar');
        var currency=safeText(d.currency,'MXN');
        var beds=toNum(d.beds),baths=toNum(d.baths),sqm=toNum(d.sqm),price=toNum(d.price);
        var interior=safeText(d.interior,'/images/venta-interiores/interior-premium.jpg');
        modalContent.innerHTML=
            '<div class="mb-6 border border-white/10 overflow-hidden">'+
                '<img src="'+escHtml(interior)+'" alt="Interior de '+escHtml(title)+'" class="w-full h-60 object-cover">'+
            '</div>'+
            '<div class="border-b border-white/10 pb-6 mb-6">'+
                '<p class="font-mono text-[10px] tracking-[0.3em] uppercase text-gold/80 mb-2">'+escHtml(city)+'</p>'+
                '<h2 class="font-serif font-black leading-tight text-paper" style="font-size:clamp(1.3rem,3vw,1.9rem)">'+escHtml(title)+'</h2>'+
            '</div>'+
            '<div class="grid grid-cols-3 gap-px bg-white/8 mb-7">'+
                '<div class="text-center p-4 bg-ink"><p class="font-mono text-[9px] tracking-[0.25em] uppercase text-paper/40 mb-1">Recámaras</p><p class="font-serif font-black text-2xl text-gold">'+fmtNum(beds)+'</p></div>'+
                '<div class="text-center p-4 bg-ink"><p class="font-mono text-[9px] tracking-[0.25em] uppercase text-paper/40 mb-1">Baños</p><p class="font-serif font-black text-2xl text-gold">'+fmtNum(baths)+'</p></div>'+
                '<div class="text-center p-4 bg-ink"><p class="font-mono text-[9px] tracking-[0.25em] uppercase text-paper/40 mb-1">m²</p><p class="font-serif font-black text-2xl text-gold">'+fmtNum(sqm)+'</p></div>'+
            '</div>'+
            '<p class="font-serif font-black text-gold mb-8" style="font-size:clamp(2rem,4vw,3rem)">'+fmtNum(price)+' <span style="font-size:.7rem" class="text-paper/35 font-mono font-normal">'+escHtml(currency)+'</span></p>'+
            '<a href="/contacto" class="block w-full text-center py-4 bg-gold text-ink text-[10px] font-mono tracking-[0.3em] uppercase hover:bg-gold/85 transition-all duration-300">Solicitar información</a>';
        var ld=document.getElementById('modalLd')||document.createElement('script');
        ld.id='modalLd';ld.type='application/ld+json';
        ld.textContent=JSON.stringify({'@context':'https://schema.org','@type':'RealEstateListing',name:title,price:price,priceCurrency:currency,numberOfBedrooms:beds});
        if(!document.getElementById('modalLd'))document.head.appendChild(ld);
        modal.classList.remove('hidden');modal.setAttribute('aria-hidden','false');
        document.body.style.overflow='hidden';document.getElementById('closeModal').focus();
    }
    function closeModal(){modal.classList.add('hidden');modal.setAttribute('aria-hidden','true');document.body.style.overflow='';}
    document.getElementById('closeModal')?.addEventListener('click',closeModal);
    document.getElementById('modalOverlay')?.addEventListener('click',closeModal);
    document.addEventListener('keydown',function(e){if(e.key==='Escape')closeModal();});
    function bindModalBtn(btn){
        if(!btn)return;
        btn.addEventListener('click',function(){
            var card=this.closest('.venta-card[data-id]');if(!card)return;
            openModal({title:card.dataset.title,price:card.dataset.price,currency:card.dataset.currency,beds:card.dataset.beds,baths:card.dataset.baths,sqm:card.dataset.sqm,interior:card.dataset.interior||thematicInteriorByTitle(card.dataset.title),city:card.querySelector('.prop-city')?.textContent?.trim()||''});
        });
    }
    document.querySelectorAll('.open-modal').forEach(bindModalBtn);

    // Comparador
    var comparePanel=document.getElementById('comparePanel'),compareGrid=document.getElementById('compareGrid'),toggleCompare=document.getElementById('toggleCompare'),closeCompare=document.getElementById('closeCompare'),selected=new Map();
    function updateComparePanel(){
        toggleCompare.textContent='Comparar ('+selected.size+'/3)';toggleCompare.setAttribute('aria-expanded',selected.size>0?'true':'false');
        if(!selected.size){comparePanel.classList.add('translate-y-full');comparePanel.setAttribute('aria-hidden','true');return;}
        comparePanel.classList.remove('translate-y-full');comparePanel.setAttribute('aria-hidden','false');
        compareGrid.innerHTML='';
        selected.forEach(function(d){
            var col=document.createElement('div');col.className='bg-ink p-5 text-sm';
            col.innerHTML='<p class="font-mono text-[9px] tracking-[0.3em] uppercase text-gold/70 mb-2">'+escHtml(d.city||'')+'</p>'+
                '<p class="font-serif font-bold text-paper mb-3">'+escHtml(d.title)+'</p>'+
                '<p class="font-serif font-black text-gold text-xl mb-4">'+Number(d.price).toLocaleString('es-MX',{maximumFractionDigits:0})+' <span class="text-[10px] text-paper/30 font-mono font-normal">'+escHtml(d.currency)+'</span></p>'+
                '<div class="grid grid-cols-3 gap-px bg-white/8 text-center text-[10px] font-mono">'+
                    '<div class="p-2 bg-ink text-paper/60">'+d.beds+'<br><span class="text-paper/30">rec</span></div>'+
                    '<div class="p-2 bg-ink text-paper/60">'+d.baths+'<br><span class="text-paper/30">baños</span></div>'+
                    '<div class="p-2 bg-ink text-paper/60">'+Number(d.sqm).toLocaleString('es-MX')+'<br><span class="text-paper/30">m²</span></div>'+
                '</div>';
            compareGrid.appendChild(col);
        });
    }
    function bindCompareLabel(card){
        var cb=card.querySelector('.compare-cb'),label=card.querySelector('.compare-label');if(!cb||!label)return;
        cb.addEventListener('change',function(){
            var id=this.dataset.id;
            if(this.checked){if(selected.size>=3){this.checked=false;alert('Máximo 3 propiedades.');return;}selected.set(id,Object.assign({},card.dataset,{city:card.querySelector('.prop-city')?.textContent?.trim()||''}));card.querySelector('.compare-icon').textContent='✓';}
            else{selected.delete(id);card.querySelector('.compare-icon').textContent='+';}
            updateComparePanel();
        });
    }
    document.querySelectorAll('.venta-card').forEach(bindCompareLabel);
    toggleCompare.addEventListener('click',function(){var a=this.getAttribute('aria-expanded')==='true';if(a)comparePanel.classList.add('translate-y-full');else if(selected.size)comparePanel.classList.remove('translate-y-full');this.setAttribute('aria-expanded',String(!a&&!!selected.size));document.querySelectorAll('.compare-label').forEach(function(l){l.classList.toggle('hidden');});});
    closeCompare.addEventListener('click',function(){comparePanel.classList.add('translate-y-full');comparePanel.setAttribute('aria-hidden','true');toggleCompare.setAttribute('aria-expanded','false');document.querySelectorAll('.compare-label').forEach(function(l){l.classList.add('hidden');});});

    // CTA Flotante
    var floatingCta=document.getElementById('floatingCta'),ctaDismissed=false;
    document.getElementById('closeCta')?.addEventListener('click',function(){ctaDismissed=true;if(floatingCta)floatingCta.style.display='none';});
    window.addEventListener('scroll',function(){if(ctaDismissed||!floatingCta)return;if(window.scrollY>600){floatingCta.style.transform='translateY(0)';floatingCta.style.opacity='1';}else{floatingCta.style.transform='translateY(5rem)';floatingCta.style.opacity='0';}},{passive:true});

    // Carrusel hero venta
    (function(){
        var ventaSlides = Array.from(document.querySelectorAll('.venta-slide'));
        var ventaCurrent = 0;
        function ventaGoTo(idx){
            if(!ventaSlides.length) return;
            ventaSlides[ventaCurrent].classList.remove('opacity-100');
            ventaSlides[ventaCurrent].classList.add('opacity-0');
            ventaCurrent = (idx + ventaSlides.length) % ventaSlides.length;
            ventaSlides[ventaCurrent].classList.remove('opacity-0');
            ventaSlides[ventaCurrent].classList.add('opacity-100');
        }
        if(ventaSlides.length > 1) setInterval(function(){ ventaGoTo(ventaCurrent + 1); }, 6000);
    })();

})();
</script>
