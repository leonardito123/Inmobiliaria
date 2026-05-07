<?php
/**
 * Desarrollos Landing Page — 7 secciones del reto
 *
 * Variables: $developments, $city, $currency, $country_code
 */
function escD(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

// Fecha objetivo de entrega (Countdown)
$deliveryDate = '2027-03-15';

$amenidades = [
    ['icon' => 'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z M9 22V12h6v10',          'label' => 'Club Residencial'],
    ['icon' => 'M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zM8 12h4m0 0h4m-4 0V8m0 4v4', 'label' => 'Alberca Infinita'],
    ['icon' => 'M3 7h18M3 12h18M3 17h18',                                                'label' => 'Coworking 24/7'],
    ['icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Terraza Jardín'],
    ['icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'label' => 'Spa & Wellness'],
    ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'label' => 'Seguridad 24/7'],
];
?>

<!-- ══════════════════════════════════
     1. HERO — Partículas CSS puro (sin JS)
     ══════════════════════════════════ -->
<section class="relative min-h-[72vh] flex items-end pb-20 overflow-hidden bg-ink" aria-label="Hero Desarrollos">
    <!-- Imagen de fondo -->
    <div class="absolute inset-0" aria-hidden="true">
        <img src="/images/hero/desarrollos-hero.jpg"
             alt=""
             class="w-full h-full object-cover"
             loading="eager">
    </div>

    <!-- Overlay degradado -->
    <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/60 to-ink/20" aria-hidden="true"></div>

    <!-- Plano SVG de fondo decorativo (sutil) -->
    <div class="absolute inset-0 opacity-[0.06]" aria-hidden="true">
        <svg viewBox="0 0 800 600" class="w-full h-full" preserveAspectRatio="xMidYMid slice">
            <rect x="50" y="50" width="200" height="300" fill="none" stroke="#c9a84c" stroke-width="1"/>
            <rect x="300" y="80" width="180" height="260" fill="none" stroke="#c9a84c" stroke-width="1"/>
            <rect x="530" y="100" width="220" height="240" fill="none" stroke="#c9a84c" stroke-width="1"/>
            <line x1="50" y1="400" x2="750" y2="400" stroke="#c9a84c" stroke-width="0.5"/>
            <line x1="250" y1="50" x2="250" y2="550" stroke="#c9a84c" stroke-width="0.5"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 text-paper">
        <nav aria-label="Breadcrumb" class="mb-6">
            <ol class="flex gap-2 text-xs font-mono text-paper/40" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" itemprop="item" class="hover:text-gold"><span itemprop="name">Inicio</span></a>
                    <meta itemprop="position" content="1">
                </li>
                <li aria-hidden="true">›</li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gold">Desarrollos</span>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </nav>
        <p id="desarrollosHeroKicker" class="text-gold font-mono text-xs tracking-[0.25em] uppercase mb-3 anim-copy" style="animation-delay:0.1s;text-shadow:0 2px 10px rgba(0,0,0,0.45);">01 · Nuevos Desarrollos</p>
        <h1 id="desarrollosHeroTitle" class="font-serif font-black leading-[0.94] mb-4 max-w-4xl" style="font-size:clamp(3rem,7vw,6rem);text-shadow:0 4px 18px rgba(0,0,0,0.45);">
            <span class="anim-word" style="animation-delay:0.18s;">Arquitectura</span>
            <span class="anim-word" style="animation-delay:0.28s;">de</span>
            <span class="anim-word text-gold italic" style="animation-delay:0.4s;">nueva</span><br>
            <span class="anim-word text-gold italic" style="animation-delay:0.52s;">generación</span>
        </h1>
        <p id="desarrollosHeroDescription" class="text-paper/85 text-base md:text-lg max-w-2xl leading-relaxed mb-8 anim-copy" style="animation-delay:0.66s;text-shadow:0 2px 10px rgba(0,0,0,0.4);">
            Preventa, construcción y entrega en <?php echo escD($country_code ?? 'MX'); ?>. Plano interactivo, conteo regresivo y formulario de interés.
        </p>
    </div>
</section>

<!-- ══════════════════════════════════
     2. COUNTDOWN TIMER — entrega
     ══════════════════════════════════ -->
<section class="py-14 bg-gold text-ink" id="countdown" aria-label="Conteo regresivo para entrega">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <p class="font-mono text-xs tracking-widest uppercase mb-2 opacity-70">02 · Próxima Entrega</p>
        <h2 class="text-3xl font-serif font-bold mb-8">Torre Insignia — Entrega estimada <?php echo date('d/m/Y', strtotime($deliveryDate)); ?></h2>

        <div id="countdownDisplay" class="grid grid-cols-4 gap-4 max-w-lg mx-auto" role="timer" aria-label="Cuenta regresiva para entrega">
            <?php foreach (['days' => 'Días', 'hours' => 'Horas', 'minutes' => 'Minutos', 'seconds' => 'Segundos'] as $key => $label): ?>
            <div class="bg-ink text-paper rounded-xl p-4">
                <p class="text-4xl font-serif font-black countdown-num" id="cd_<?php echo $key; ?>">--</p>
                <p class="text-xs font-mono opacity-60 mt-1"><?php echo $label; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     3. PLANO INTERACTIVO + SCROLL-DRIVEN ANIMATIONS
     ══════════════════════════════════ -->
<section class="py-14 bg-paper text-ink" id="masterplan" aria-label="Plano interactivo del desarrollo">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1 scroll-reveal">03 · Masterplan</p>
        <h2 class="text-3xl font-serif font-bold mb-10 scroll-reveal">Plano interactivo del conjunto</h2>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- SVG plano -->
            <div class="lg:col-span-3 bg-white border border-rule rounded-xl p-6 scroll-reveal">
                <svg viewBox="0 0 640 420" class="w-full border border-rule rounded-lg bg-slate-50" role="img" aria-label="Plano interactivo del desarrollo" id="masterplanSvg">
                    <rect x="20" y="20" width="600" height="380" fill="#f6f7f8" stroke="#d6d9df"/>
                    <!-- Torres clicables -->
                    <rect x="60"  y="80"  width="120" height="180" class="tower cursor-pointer transition-opacity hover:opacity-80 focus:opacity-80" tabindex="0"
                          data-name="Torre A" data-status="Preventa" data-price="Desde $4,200,000" fill="#2c5f8a"
                          role="button" aria-label="Torre A — Preventa"/>
                    <rect x="220" y="60"  width="120" height="200" class="tower cursor-pointer transition-opacity hover:opacity-80 focus:opacity-80" tabindex="0"
                          data-name="Torre B" data-status="Construcción" data-price="Desde $5,600,000" fill="#b8942a"
                          role="button" aria-label="Torre B — Construcción"/>
                    <rect x="380" y="100" width="120" height="160" class="tower cursor-pointer transition-opacity hover:opacity-80 focus:opacity-80" tabindex="0"
                          data-name="Torre C" data-status="Entrega 2027" data-price="Desde $6,200,000" fill="#c0392b"
                          role="button" aria-label="Torre C — Entrega 2027"/>
                    <rect x="540" y="120" width="60"  height="140" class="tower cursor-pointer transition-opacity hover:opacity-80 focus:opacity-80" tabindex="0"
                          data-name="Amenidades" data-status="Operativo" data-price="Club y piscina" fill="#1f2937"
                          role="button" aria-label="Amenidades — Operativo"/>
                    <!-- Labels -->
                    <text x="95"  y="175" fill="#fff" font-size="16" font-weight="bold" pointer-events="none">A</text>
                    <text x="255" y="175" fill="#fff" font-size="16" font-weight="bold" pointer-events="none">B</text>
                    <text x="415" y="185" fill="#fff" font-size="16" font-weight="bold" pointer-events="none">C</text>
                    <text x="545" y="195" fill="#fff" font-size="12" pointer-events="none">CLUB</text>
                </svg>
                <div id="towerInfo" class="mt-4 p-4 border border-rule rounded-lg bg-paper text-sm" aria-live="polite">
                    Haz clic en una torre para ver detalles.
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Timeline fases -->
                <div class="bg-white border border-rule rounded-xl p-6 scroll-reveal">
                    <h3 class="text-xl font-serif font-bold mb-5">Línea de tiempo</h3>
                    <ol class="space-y-3 text-sm">
                        <?php
                        $phases = [
                            ['done' => true,  'title' => 'Fase 1', 'desc' => 'Cimentación completada'],
                            ['done' => true,  'title' => 'Fase 2', 'desc' => 'Estructura Torres A y B'],
                            ['done' => false, 'title' => 'Fase 3', 'desc' => 'Fachadas y acabados premium'],
                            ['done' => false, 'title' => 'Fase 4', 'desc' => 'Entrega y escrituración'],
                        ];
                        foreach ($phases as $ph): ?>
                        <li class="flex items-start gap-3 p-3 rounded border <?php echo $ph['done'] ? 'border-green-200 bg-green-50' : 'border-rule bg-paper'; ?>">
                            <span class="mt-0.5 text-lg"><?php echo $ph['done'] ? '✓' : '○'; ?></span>
                            <div>
                                <p class="font-semibold"><?php echo escD($ph['title']); ?></p>
                                <p class="text-muted text-xs"><?php echo escD($ph['desc']); ?></p>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ol>
                </div>

                <!-- Inventario -->
                <div class="bg-white border border-rule rounded-xl p-6 scroll-reveal">
                    <h3 class="text-xl font-serif font-bold mb-4">Inventario disponible</h3>
                    <?php if (empty($developments)): ?>
                    <p class="text-sm text-muted">Sin desarrollos registrados con ese filtro.</p>
                    <?php else: ?>
                    <ul class="space-y-3 text-sm">
                        <?php foreach ($developments as $dev): ?>
                        <li class="p-3 rounded border border-rule bg-paper hover:bg-white transition">
                            <p class="font-semibold"><?php echo escD($dev['meta_title'] ?? 'Desarrollo'); ?></p>
                            <p class="text-muted text-xs"><?php echo escD($dev['city'] ?? ''); ?> · <?php echo escD($currency ?? 'MXN'); ?></p>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     4. GALERÍA 360° — CSS perspective
     ══════════════════════════════════ -->
<section class="py-20 bg-ink text-paper overflow-hidden" id="galeria360" aria-label="Galería 360°">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1 scroll-reveal">04 · Vista 360°</p>
        <h2 class="text-3xl font-serif font-bold mb-12 scroll-reveal">Explora el espacio en 360°</h2>

        <div id="cube360Wrap" class="relative flex items-center justify-center overflow-hidden rounded-2xl" style="height:400px;perspective:1600px;perspective-origin:50% 28%;">
            <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
                 style="background:radial-gradient(circle at center, rgba(201,168,76,0.2) 0%, rgba(201,168,76,0.08) 24%, rgba(10,10,10,0) 62%);"></div>
            <!-- Carrusel 3D CSS puro -->
            <div id="cube360" class="relative" style="width:240px;height:240px;transform-style:preserve-3d;transform:rotateX(30deg) rotateY(-32deg);transition:transform 0.8s cubic-bezier(.4,0,.2,1);">
                <?php
                $cubeDepth = 120;
                $cube_faces = [
                    ['rot' => 'rotateY(0deg) translateZ(' . $cubeDepth . 'px)',   'img' => '/images/venta-interiores/interior-premium.jpg',    'label' => 'Sala',     'isImage' => true,  'shade' => 0.22],
                    ['rot' => 'rotateY(90deg) translateZ(' . $cubeDepth . 'px)',  'img' => '/images/venta-interiores/interior-penthouse.jpg',  'label' => 'Cocina',   'isImage' => true,  'shade' => 0.56],
                    ['rot' => 'rotateY(180deg) translateZ(' . $cubeDepth . 'px)', 'img' => '/images/venta-interiores/interior-loft.jpg',       'label' => 'Recámara', 'isImage' => true,  'shade' => 0.7],
                    ['rot' => 'rotateY(270deg) translateZ(' . $cubeDepth . 'px)', 'img' => '/images/hero/desarrollos-terraza.jpg',            'label' => 'Terraza',  'isImage' => true,  'shade' => 0.5],
                    ['rot' => 'rotateX(90deg) translateZ(' . $cubeDepth . 'px)',  'bg'  => 'linear-gradient(180deg, rgba(216,188,96,.9), rgba(86,67,24,.96))', 'label' => 'Techo', 'isImage' => false],
                    ['rot' => 'rotateX(-90deg) translateZ(' . $cubeDepth . 'px)', 'bg'  => 'linear-gradient(180deg, rgba(14,14,14,.98), rgba(34,28,18,.98))',   'label' => 'Base',  'isImage' => false],
                ];
                foreach ($cube_faces as $face): ?>
                <div class="absolute inset-0 overflow-hidden border border-gold/20 flex items-end"
                     style="transform:<?php echo $face['rot']; ?>;<?php echo !empty($face['isImage']) ? 'background-image:url(\'' . escD($face['img']) . '\');background-size:cover;background-position:center;background-repeat:no-repeat;' : 'background:' . $face['bg'] . ';'; ?>backface-visibility:hidden;box-shadow:inset 0 0 0 1px rgba(255,255,255,.05);">
                    <div class="absolute inset-0" style="background:<?php echo !empty($face['isImage']) ? 'linear-gradient(to top, rgba(8,8,8,' . $face['shade'] . ') 0%, rgba(8,8,8,' . max(0.08, $face['shade'] - 0.16) . ') 50%, rgba(8,8,8,0.04) 100%)' : 'linear-gradient(to top, rgba(8,8,8,0.28) 0%, rgba(8,8,8,0.06) 100%)'; ?>;"></div>
                    <?php if (!empty($face['isImage'])): ?>
                    <span class="relative z-10 m-3 inline-flex items-center rounded-full border border-white/20 bg-black/35 px-3 py-1 font-serif font-bold text-sm text-paper"><?php echo escD($face['label']); ?></span>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Controles 360 -->
        <div class="flex justify-center gap-4 mt-8">
            <button id="cube360Prev" class="px-5 py-2 border border-white/20 text-paper rounded hover:bg-white/10 transition text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-gold" aria-label="Cara anterior">‹ Anterior</button>
            <button id="cube360Next" class="px-5 py-2 border border-white/20 text-paper rounded hover:bg-white/10 transition text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-gold" aria-label="Cara siguiente">Siguiente ›</button>
        </div>
        <p class="text-center text-paper/55 text-xs mt-4 font-mono tracking-[0.14em] uppercase">Vista conceptual — recorridos reales disponibles previo cita</p>
    </div>
</section>

<!-- ══════════════════════════════════
     5. AMENIDADES — Iconos SVG animados
     ══════════════════════════════════ -->
<section class="py-20 bg-white text-ink" id="amenidades" aria-label="Amenidades del desarrollo">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1 scroll-reveal">05 · Amenidades</p>
        <h2 class="text-3xl font-serif font-bold mb-12 scroll-reveal">Amenidades de clase mundial</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
            <?php foreach ($amenidades as $am): ?>
            <div class="group text-center p-5 border border-rule rounded-xl hover:border-gold hover:shadow-lg transition scroll-reveal">
                <div class="flex items-center justify-center mb-3">
                    <svg class="w-10 h-10 text-gold transition-transform duration-300 group-hover:scale-125 group-hover:rotate-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo escD($am['icon']); ?>"/>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-ink"><?php echo escD($am['label']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     6. FORMULARIO DE INTERÉS (Lead scoring)
     ══════════════════════════════════ -->
<section class="py-20 bg-paper border-t border-rule text-ink" id="formulario-interes" aria-label="Formulario de interés">
    <div class="max-w-2xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">06 · Registro</p>
        <h2 class="text-3xl font-serif font-bold mb-8">Regístra tu interés</h2>

        <form id="leadForm" method="POST" action="/desarrollos/lead" class="space-y-5 bg-white border border-rule rounded-xl p-8 shadow-sm">
            <?php if (function_exists('csrf_token')): ?>
            <input type="hidden" name="_token" value="<?php echo escD(csrf_token()); ?>">
            <?php endif; ?>
            <!-- Honeypot -->
            <input type="text" name="website" tabindex="-1" autocomplete="off" class="sr-only" aria-hidden="true">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="lead_name" class="block text-sm font-semibold text-muted mb-2">Nombre *</label>
                    <input id="lead_name" type="text" name="name" required
                           class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold"
                           placeholder="Tu nombre">
                </div>
                <div>
                    <label for="lead_email" class="block text-sm font-semibold text-muted mb-2">Correo *</label>
                    <input id="lead_email" type="email" name="email" required
                           class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold"
                           placeholder="tu@correo.com">
                </div>
            </div>
            <div>
                <label for="lead_phone" class="block text-sm font-semibold text-muted mb-2">Teléfono</label>
                <input id="lead_phone" type="tel" name="phone"
                       class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold"
                       placeholder="+52 55 0000 0000">
            </div>
            <div>
                <label for="lead_tower" class="block text-sm font-semibold text-muted mb-2">Torre de interés</label>
                <select id="lead_tower" name="property_id"
                        class="w-full px-4 py-3 border border-rule rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-gold">
                    <option value="">Selecciona una torre</option>
                    <option value="1">Torre A — Desde $4,200,000</option>
                    <option value="2">Torre B — Desde $5,600,000</option>
                    <option value="3">Torre C — Desde $6,200,000</option>
                </select>
            </div>
            <div>
                <label for="lead_msg" class="block text-sm font-semibold text-muted mb-2">Mensaje</label>
                <textarea id="lead_msg" name="message" rows="3"
                          class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold resize-none"
                          placeholder="¿Cuándo deseas visitar el showroom?"></textarea>
            </div>
            <!-- Lead score indicator (calculado en cliente, verificado en servidor) -->
            <div id="scoreBar" class="hidden">
                <p class="text-xs text-muted font-mono mb-1">Perfil completado: <span id="scoreVal">0</span>%</p>
                <div class="h-1.5 bg-rule rounded-full overflow-hidden"><div id="scoreTrack" class="h-full bg-gold rounded-full transition-all" style="width:0%"></div></div>
            </div>
            <button type="submit"
                    class="w-full py-4 bg-ink text-paper font-bold rounded hover:bg-accent transition text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                Solicitar información →
            </button>
        </form>
    </div>
</section>

<!-- ══════════════════════════════════
     7. FILTRO DE CIUDAD + CTA
     ══════════════════════════════════ -->
<section class="py-10 bg-ink text-paper" aria-label="Filtrar desarrollos por ciudad">
    <div class="max-w-4xl mx-auto px-6 flex flex-col sm:flex-row items-center gap-4">
        <form method="GET" action="/desarrollos" class="flex gap-3 flex-1 w-full" role="search">
            <input name="city" type="text"
                   value="<?php echo escD($city ?? ''); ?>"
                   placeholder="Filtrar por ciudad"
                   class="flex-1 px-4 py-3 rounded bg-white/10 border border-white/20 text-paper text-sm placeholder:text-paper/40 focus:outline-none focus:ring-1 focus:ring-gold"
                   aria-label="Ciudad">
            <button type="submit" class="px-6 py-3 bg-gold text-ink font-bold rounded hover:bg-gold/90 transition text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                Filtrar
            </button>
        </form>
        <a href="#formulario-interes" class="px-6 py-3 border border-gold text-gold font-bold rounded hover:bg-gold hover:text-ink transition text-sm whitespace-nowrap focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
            Agendar showroom →
        </a>
    </div>
</section>

<script>
(function () {
    'use strict';

    // ── COUNTDOWN TIMER ───────────────────────────────────────────
    var target = new Date('<?php echo escD($deliveryDate); ?>T00:00:00');
    function pad(n) { return String(n).padStart(2, '0'); }
    function tickCd() {
        var now  = new Date();
        var diff = Math.max(0, target - now);
        var s    = Math.floor(diff / 1000);
        var m    = Math.floor(s / 60);
        var h    = Math.floor(m / 60);
        var d    = Math.floor(h / 24);
        var el = function (id, v) { var e = document.getElementById(id); if (e) e.textContent = pad(v); };
        el('cd_days',    d);
        el('cd_hours',   h % 24);
        el('cd_minutes', m % 60);
        el('cd_seconds', s % 60);
        if (diff > 0) requestAnimationFrame(tickCd);
    }
    if (document.getElementById('cd_days')) requestAnimationFrame(tickCd);

    // ── PLANO INTERACTIVO ─────────────────────────────────────────
    var towers  = document.querySelectorAll('.tower');
    var infoBox = document.getElementById('towerInfo');

    towers.forEach(function (t) {
        function activate() {
            if (!infoBox) return;
            infoBox.innerHTML =
                '<strong>' + (t.dataset.name || '') + '</strong> — ' + (t.dataset.status || '') +
                '<br><span class="text-gold font-bold">' + (t.dataset.price || '') + '</span>';
        }
        t.addEventListener('click',  activate);
        t.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); activate(); } });
    });

    // ── GALERÍA 360° ──────────────────────────────────────────────
    var cube  = document.getElementById('cube360');
    var cubeWrap = document.getElementById('cube360Wrap');
    var angle = -45;
    var cubeTimer = null;
    function renderCube() {
        if (cube) cube.style.transform = 'rotateX(30deg) rotateY(' + angle + 'deg)';
    }
    function stopCubeAuto() {
        if (cubeTimer) {
            clearInterval(cubeTimer);
            cubeTimer = null;
        }
    }
    function startCubeAuto() {
        if (!cube || cubeTimer) return;
        cubeTimer = setInterval(function () {
            if (cubeWrap && cubeWrap.matches(':hover')) return;
            if (cubeWrap && cubeWrap.contains(document.activeElement)) return;
            angle += 90;
            renderCube();
        }, 4200);
    }
    renderCube();
    document.getElementById('cube360Next')?.addEventListener('click', function () { angle += 90; renderCube(); });
    document.getElementById('cube360Prev')?.addEventListener('click', function () { angle -= 90; renderCube(); });
    startCubeAuto();

    // ── LEAD SCORE INDICATOR ──────────────────────────────────────
    var form      = document.getElementById('leadForm');
    var scoreBar  = document.getElementById('scoreBar');
    var scoreVal  = document.getElementById('scoreVal');
    var scoreTrk  = document.getElementById('scoreTrack');

    if (form && scoreBar) {
        scoreBar.classList.remove('hidden');
        var weights = { name: 10, email: 20, phone: 30, property_id: 20, message: 20 };
        form.addEventListener('input', function () {
            var total = 0;
            var fd    = new FormData(form);
            Object.keys(weights).forEach(function (k) {
                if ((fd.get(k) || '').toString().trim()) total += weights[k];
            });
            scoreVal.textContent  = total;
            scoreTrk.style.width  = total + '%';
        });
    }
})();
</script>
