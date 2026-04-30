<?php
/**
 * Renta Landing Page — 7 secciones del reto
 *
 * Variables: $properties, $filters, $country_code, $currency
 */
function escR(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

$faqs = [
    ['q' => '¿Cuál es el período mínimo de renta?',    'a' => 'El mínimo es de 30 días para renta mensual, o 3 noches para estadías cortas en propiedades vacacionales.'],
    ['q' => '¿Qué incluye la renta?',                  'a' => 'Incluye mantenimiento de áreas comunes, seguridad 24/7, internet, agua y gas según el contrato negociado.'],
    ['q' => '¿Puedo pagar con tarjeta de crédito?',    'a' => 'Sí, aceptamos Visa, Mastercard y transferencia bancaria. El cargo de comisión lo absorbe la plataforma.'],
    ['q' => '¿Hay depósito de garantía?',              'a' => 'Sí, equivale a 1-2 meses de renta según la propiedad. Se devuelve íntegro al finalizar el contrato sin daños.'],
    ['q' => '¿Puedo llevar mascotas?',                 'a' => 'Depende de la política de cada propiedad. Filtra por "Pet-friendly" en el buscador para ver opciones disponibles.'],
];

$experiences = [
    ['icon' => 'M12 3v1m0 16v1M4.22 4.22l.71.71M18.36 18.36l.71.71M1 12h1M21 12h1M4.22 19.78l.71-.71M18.36 5.64l.71-.71', 'title' => 'Tour fotográfico', 'desc' => 'Sesión profesional en tu nueva propiedad.'],
    ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'title' => 'Recorrido VIP', 'desc' => 'Agente exclusivo disponible con agenda flexible.'],
    ['icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'title' => 'Guía de vecindario', 'desc' => 'Mapa curado con restaurantes, mercados y parques.'],
    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Conexión con comunidad', 'desc' => 'Grupos locales y eventos de bienvenida.'],
];

$temporadas = [
    ['name' => 'Baja',   'color' => 'text-emerald-600', 'months' => 'Feb – Abr · Sep – Oct', 'mult' => 1.0,  'badge' => 'Precio base'],
    ['name' => 'Media',  'color' => 'text-amber-500',   'months' => 'May – Jul · Nov',       'mult' => 1.15, 'badge' => '+15%'],
    ['name' => 'Alta',   'color' => 'text-rose-600',    'months' => 'Dic – Ene · Ago',       'mult' => 1.35, 'badge' => '+35%'],
];
?>

<!-- JSON-LD FAQPage -->
<script type="application/ld+json">
<?php echo json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'FAQPage',
    'mainEntity' => array_map(fn($f) => [
        '@type'          => 'Question',
        'name'           => $f['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
    ], $faqs),
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
</script>

<!-- ══════════════════════════════════
     1. HERO — Slideshow WebP/AVIF con <picture>
     ══════════════════════════════════ -->
<section class="relative min-h-[70vh] overflow-hidden flex items-end pb-20" aria-label="Hero Renta" id="heroSlideshow">
    <!-- Slides -->
    <div class="absolute inset-0" aria-hidden="true" id="slidesContainer">
        <?php
        $slides = [
            ['alt' => 'Penthouse en la ciudad', 'src' => 'renta-hero-1'],
            ['alt' => 'Loft moderno iluminado',  'src' => 'renta-hero-2'],
            ['alt' => 'Casa con jardín',         'src' => 'renta-hero-3'],
        ];
        foreach ($slides as $i => $slide): ?>
        <figure class="slide absolute inset-0 transition-opacity duration-700 <?php echo $i === 0 ? 'opacity-100' : 'opacity-0'; ?>">
            <picture>
                <source srcset="/images/slides/<?php echo escR($slide['src']); ?>.avif" type="image/avif">
                <source srcset="/images/slides/<?php echo escR($slide['src']); ?>.webp" type="image/webp">
                <img src="/images/slides/<?php echo escR($slide['src']); ?>.svg"
                     alt="<?php echo escR($slide['alt']); ?>"
                     class="w-full h-full object-cover"
                     <?php echo $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
            </picture>
        </figure>
        <?php endforeach; ?>
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-ink/20 via-ink/40 to-ink/80" aria-hidden="true"></div>

    <!-- Dots navigation -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-10" role="tablist" aria-label="Slides del hero">
        <?php foreach ($slides as $i => $_): ?>
        <button role="tab"
                aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                data-slide="<?php echo $i; ?>"
                class="slide-dot w-2 h-2 rounded-full bg-paper transition <?php echo $i === 0 ? 'opacity-100 scale-125' : 'opacity-40'; ?>"
                aria-label="Slide <?php echo $i + 1; ?>"></button>
        <?php endforeach; ?>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 text-paper">
        <p class="text-gold font-mono text-xs tracking-[0.25em] uppercase mb-3">01 · Renta Premium</p>
        <h1 class="text-5xl md:text-6xl font-serif font-black leading-tight mb-4 max-w-3xl">
            Tu próximo hogar, <span class="text-gold italic">sin compromiso</span>
        </h1>
        <p class="text-paper/70 text-lg max-w-xl mb-8">
            Renta mensual y vacacional en <?php echo escR($country_code ?? 'MX'); ?>. Selecciona fechas, elige huéspedes y reserva al instante.
        </p>
        <a href="#multistep" class="inline-block px-8 py-4 bg-gold text-ink font-bold rounded-full hover:bg-gold/90 transition text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-paper">
            Iniciar búsqueda →
        </a>
    </div>
</section>

<!-- ══════════════════════════════════
     2. PRECIOS DINÁMICOS POR TEMPORADA
     ══════════════════════════════════ -->
<section class="py-16 bg-paper border-b border-rule" id="temporadas" aria-label="Precios por temporada">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">02 · Temporadas</p>
        <h2 class="text-3xl font-serif font-bold mb-8">Precios dinámicos según temporada</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <?php foreach ($temporadas as $t): ?>
            <div class="bg-white border border-rule rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="font-serif font-bold text-xl <?php echo escR($t['color']); ?>"><?php echo escR($t['name']); ?></span>
                    <span class="text-xs font-mono bg-rule px-2 py-1 rounded"><?php echo escR($t['badge']); ?></span>
                </div>
                <p class="text-xs text-muted mb-4 font-mono"><?php echo escR($t['months']); ?></p>
                <p class="text-sm text-muted">Desde</p>
                <p class="text-3xl font-serif font-black text-gold mt-1" data-base="25000" data-mult="<?php echo $t['mult']; ?>">
                    $<?php echo number_format(25000 * $t['mult'], 0, '.', ','); ?>
                    <span class="text-xs font-sans font-normal text-muted"><?php echo escR($currency ?? 'MXN'); ?>/mes</span>
                </p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Selector dinámico Alpine.js -->
        <div x-data="{
            precio_base: 25000,
            meses: 1,
            temporada: 1.0,
            get total() { return Math.round(this.precio_base * this.temporada * this.meses); },
            fmt(n) { return n.toLocaleString('es-MX'); }
        }" class="bg-ink text-paper rounded-xl p-6 max-w-2xl">
            <p class="font-serif font-bold text-xl mb-6">Calcula tu renta</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-paper/50 text-xs uppercase tracking-wider mb-2">Precio base</label>
                    <input type="number" x-model.number="precio_base" min="5000" step="1000" class="w-full px-3 py-2 rounded bg-white/10 border border-white/20 text-paper text-sm focus:outline-none focus:ring-1 focus:ring-gold" aria-label="Precio base">
                </div>
                <div>
                    <label class="block text-paper/50 text-xs uppercase tracking-wider mb-2">Meses</label>
                    <input type="number" x-model.number="meses" min="1" max="24" class="w-full px-3 py-2 rounded bg-white/10 border border-white/20 text-paper text-sm focus:outline-none focus:ring-1 focus:ring-gold" aria-label="Número de meses">
                </div>
                <div>
                    <label class="block text-paper/50 text-xs uppercase tracking-wider mb-2">Temporada</label>
                    <select x-model.number="temporada" class="w-full px-3 py-2 rounded bg-white/10 border border-white/20 text-paper text-sm bg-ink focus:outline-none focus:ring-1 focus:ring-gold" aria-label="Temporada">
                        <option value="1.0">Baja (1×)</option>
                        <option value="1.15">Media (1.15×)</option>
                        <option value="1.35">Alta (1.35×)</option>
                    </select>
                </div>
            </div>
            <p class="text-paper/50 text-xs uppercase tracking-wider mb-1">Total estimado</p>
            <p class="text-5xl font-serif font-black text-gold" aria-live="polite" x-text="'$' + fmt(total)"></p>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     3. FORMULARIO MULTISTEP (3 pasos)
     ══════════════════════════════════ -->
<section class="py-20 bg-white" id="multistep" aria-label="Formulario de reserva en 3 pasos">
    <div class="max-w-3xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">03 · Reservar</p>
        <h2 class="text-3xl font-serif font-bold mb-10">Solicita tu visita en 3 pasos</h2>

        <div x-data="{
            step: 1,
            checkIn: '',
            checkOut: '',
            guests: 1,
            pets: false,
            name: '',
            email: '',
            phone: '',
            submitted: false,
            next() { if(this.step < 3) this.step++; },
            prev() { if(this.step > 1) this.step--; },
        }">
            <!-- Progress bar -->
            <div class="flex items-center gap-2 mb-10" role="progressbar" :aria-valuenow="step" aria-valuemin="1" aria-valuemax="3">
                <template x-for="n in 3" :key="n">
                    <div class="flex items-center gap-2 flex-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2 transition"
                             :class="step >= n ? 'bg-ink text-paper border-ink' : 'bg-white text-muted border-rule'"
                             :aria-current="step === n ? 'step' : undefined"
                             x-text="n"></div>
                        <div class="flex-1 h-0.5 transition" :class="step > n ? 'bg-ink' : 'bg-rule'" x-show="n < 3"></div>
                    </div>
                </template>
            </div>

            <div class="bg-white border border-rule rounded-xl p-8 shadow-sm">
                <!-- PASO 1: Fechas -->
                <div x-show="step === 1" x-transition>
                    <h3 class="font-serif font-bold text-xl mb-6">Selecciona tus fechas</h3>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="ms_checkin" class="block text-sm font-semibold text-muted mb-2">Fecha de entrada</label>
                            <input id="ms_checkin" type="date" x-model="checkIn"
                                   :min="new Date().toISOString().split('T')[0]"
                                   class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold"
                                   required>
                        </div>
                        <div>
                            <label for="ms_checkout" class="block text-sm font-semibold text-muted mb-2">Fecha de salida</label>
                            <input id="ms_checkout" type="date" x-model="checkOut"
                                   :min="checkIn || new Date().toISOString().split('T')[0]"
                                   class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold"
                                   required>
                        </div>
                    </div>
                    <button @click="next()" :disabled="!checkIn || !checkOut"
                            class="px-8 py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition disabled:opacity-40 focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                        Siguiente →
                    </button>
                </div>

                <!-- PASO 2: Huéspedes -->
                <div x-show="step === 2" x-transition>
                    <h3 class="font-serif font-bold text-xl mb-6">¿Cuántos huéspedes?</h3>
                    <div class="space-y-6 mb-8">
                        <div>
                            <label for="ms_guests" class="block text-sm font-semibold text-muted mb-2">Adultos y niños</label>
                            <div class="flex items-center gap-4">
                                <button type="button" @click="if(guests > 1) guests--"
                                        class="w-10 h-10 rounded-full border border-rule text-xl font-bold hover:bg-rule transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink"
                                        aria-label="Reducir huéspedes">−</button>
                                <span class="text-3xl font-serif font-bold w-12 text-center" x-text="guests" id="ms_guests" aria-live="polite"></span>
                                <button type="button" @click="if(guests < 12) guests++"
                                        class="w-10 h-10 rounded-full border border-rule text-xl font-bold hover:bg-rule transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink"
                                        aria-label="Aumentar huéspedes">+</button>
                            </div>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="pets" class="w-5 h-5 accent-gold">
                            <span class="text-sm font-semibold">¿Viajan con mascotas?</span>
                        </label>
                    </div>
                    <div class="flex gap-3">
                        <button @click="prev()" class="px-6 py-3 border border-rule rounded font-bold hover:bg-rule transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">← Atrás</button>
                        <button @click="next()" class="px-8 py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">Siguiente →</button>
                    </div>
                </div>

                <!-- PASO 3: Datos de contacto -->
                <div x-show="step === 3" x-transition>
                    <h3 class="font-serif font-bold text-xl mb-6">Tus datos</h3>
                    <template x-if="submitted">
                        <div class="text-center py-8">
                            <p class="text-5xl mb-4">✓</p>
                            <p class="text-xl font-serif font-bold mb-2">¡Solicitud enviada!</p>
                            <p class="text-muted text-sm">Un agente te contactará en menos de 2 horas.</p>
                        </div>
                    </template>
                    <template x-if="!submitted">
                        <form @submit.prevent="submitted = true" class="space-y-4">
                            <!-- Honeypot -->
                            <input type="text" name="website" tabindex="-1" autocomplete="off" class="sr-only" aria-hidden="true">
                            <div>
                                <label for="ms_name" class="block text-sm font-semibold text-muted mb-2">Nombre completo *</label>
                                <input id="ms_name" type="text" x-model="name" required
                                       class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold"
                                       placeholder="Ana García">
                            </div>
                            <div>
                                <label for="ms_email" class="block text-sm font-semibold text-muted mb-2">Correo electrónico *</label>
                                <input id="ms_email" type="email" x-model="email" required
                                       class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold"
                                       placeholder="ana@ejemplo.com">
                            </div>
                            <div>
                                <label for="ms_phone" class="block text-sm font-semibold text-muted mb-2">Teléfono</label>
                                <input id="ms_phone" type="tel" x-model="phone"
                                       class="w-full px-4 py-3 border border-rule rounded-lg focus:outline-none focus:ring-2 focus:ring-gold"
                                       placeholder="+52 55 0000 0000">
                            </div>
                            <!-- Resumen -->
                            <div class="bg-paper border border-rule rounded-lg p-4 text-sm">
                                <p class="font-semibold mb-2">Resumen de solicitud</p>
                                <p class="text-muted">Entrada: <strong x-text="checkIn"></strong> · Salida: <strong x-text="checkOut"></strong></p>
                                <p class="text-muted">Huéspedes: <strong x-text="guests"></strong> <span x-show="pets">· Con mascotas</span></p>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" @click="prev()" class="px-6 py-3 border border-rule rounded font-bold hover:bg-rule transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">← Atrás</button>
                                <button type="submit" :disabled="!name || !email"
                                        class="flex-1 py-3 bg-gold text-ink font-bold rounded hover:bg-gold/90 transition disabled:opacity-40 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                                    Solicitar visita →
                                </button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     4. EXPERIENCIAS INCLUIDAS
     ══════════════════════════════════ -->
<section class="py-20 bg-ink text-paper" aria-label="Experiencias incluidas">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">04 · Diferenciadores</p>
        <h2 class="text-3xl font-serif font-bold mb-12">Experiencias incluidas en tu renta</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($experiences as $exp): ?>
            <article class="p-6 border border-white/10 rounded-xl hover:bg-white/5 transition">
                <svg class="w-10 h-10 text-gold mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo escR($exp['icon']); ?>"/>
                </svg>
                <h3 class="font-serif font-bold text-lg mb-2"><?php echo escR($exp['title']); ?></h3>
                <p class="text-paper/60 text-sm"><?php echo escR($exp['desc']); ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     5. PROPIEDADES DISPONIBLES + CALENDARIO
     ══════════════════════════════════ -->
<section class="py-14 bg-paper" id="listado-renta" aria-label="Propiedades en renta disponibles">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">05 · Disponibilidad</p>
        <h2 class="text-3xl font-serif font-bold mb-10">Propiedades disponibles en <?php echo escR($country_code ?? 'MX'); ?></h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Calendario vanilla JS -->
            <div class="bg-white border border-rule rounded-xl p-6 h-fit">
                <h3 class="text-xl font-serif font-bold mb-4">Calendario de visitas</h3>
                <p class="text-xs text-muted mb-4">Selecciona llegada y salida para programar recorrido.</p>
                <div class="flex items-center justify-between mb-4">
                    <button id="prevMonth" class="px-3 py-1 border border-rule rounded text-sm hover:bg-rule transition focus:outline-none" aria-label="Mes anterior">‹</button>
                    <h4 id="calendarTitle" class="font-semibold text-sm"></h4>
                    <button id="nextMonth" class="px-3 py-1 border border-rule rounded text-sm hover:bg-rule transition focus:outline-none" aria-label="Mes siguiente">›</button>
                </div>
                <div class="grid grid-cols-7 text-xs text-center text-muted mb-2 gap-1">
                    <span>Lu</span><span>Ma</span><span>Mi</span><span>Ju</span><span>Vi</span><span>Sa</span><span>Do</span>
                </div>
                <div id="calendarGrid" class="grid grid-cols-7 gap-1"></div>
                <div class="mt-4 border-t border-rule pt-4 text-sm space-y-1">
                    <p><strong>Entrada:</strong> <span id="checkInLabel" class="text-muted">Sin seleccionar</span></p>
                    <p><strong>Salida:</strong> <span id="checkOutLabel" class="text-muted">Sin seleccionar</span></p>
                    <button id="clearDates" class="mt-2 px-4 py-2 border border-rule rounded text-xs hover:bg-rule transition">Limpiar fechas</button>
                </div>
            </div>

            <!-- Grid propiedades -->
            <div class="lg:col-span-2">
                <?php if (empty($properties)): ?>
                <div class="bg-white border border-rule rounded-xl p-10 text-center">
                    <p class="text-muted">Sin propiedades de renta en este país.</p>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php foreach ($properties as $prop): ?>
                    <article class="bg-white border border-rule rounded-xl overflow-hidden hover:shadow-xl transition"
                             itemscope itemtype="https://schema.org/Accommodation">
                        <picture>
                            <source srcset="/images/properties/<?php echo escR($prop['slug'] ?? 'default'); ?>.webp" type="image/webp">
                            <img src="/images/properties/<?php echo escR($prop['slug'] ?? 'default'); ?>.svg"
                                 alt="<?php echo escR($prop['meta_title'] ?? 'Propiedad en renta'); ?>"
                                 class="w-full aspect-[16/9] object-cover"
                                 loading="lazy">
                        </picture>
                        <div class="p-5">
                            <h3 class="font-serif font-bold text-lg mb-1" itemprop="name"><?php echo escR($prop['meta_title'] ?? 'Propiedad en renta'); ?></h3>
                            <p class="text-muted text-sm mb-3"><?php echo escR($prop['city'] ?? ''); ?></p>
                            <div class="flex gap-3 text-sm mb-4">
                                <span><?php echo (int)($prop['bedrooms'] ?? 0); ?> hab.</span>
                                <span><?php echo (int)($prop['bathrooms'] ?? 0); ?> baños</span>
                                <span><?php echo (int)($prop['sqm'] ?? 0); ?> m²</span>
                            </div>
                            <p class="text-2xl font-serif font-bold text-gold mb-4" itemprop="price">
                                $<?php echo number_format((float)($prop['price'] ?? 0), 0, '.', ','); ?>
                                <span class="text-xs font-sans font-normal text-muted"><?php echo escR($currency ?? 'MXN'); ?>/mes</span>
                            </p>
                            <a href="#multistep" class="block w-full text-center py-2 bg-ink text-paper rounded font-bold text-sm hover:bg-accent transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                                Solicitar visita
                            </a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     6. FAQ — acordeón CSS (details/summary)
     ══════════════════════════════════ -->
<section class="py-20 bg-white border-t border-rule" id="faq" aria-label="Preguntas frecuentes sobre renta">
    <div class="max-w-3xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">06 · FAQ</p>
        <h2 class="text-3xl font-serif font-bold mb-10">Preguntas frecuentes</h2>
        <div class="space-y-2">
            <?php foreach ($faqs as $i => $faq): ?>
            <details class="group border border-rule rounded-xl overflow-hidden" <?php echo $i === 0 ? 'open' : ''; ?>>
                <summary class="flex items-center justify-between px-6 py-4 cursor-pointer list-none font-semibold hover:bg-paper transition select-none focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-ink"
                         aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>">
                    <span><?php echo escR($faq['q']); ?></span>
                    <svg class="w-5 h-5 text-muted transition-transform duration-300 group-open:rotate-45 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </summary>
                <div class="px-6 pb-5 text-muted text-sm leading-relaxed border-t border-rule pt-4">
                    <?php echo escR($faq['a']); ?>
                </div>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     7. FILTROS + CTA BOTTOM
     ══════════════════════════════════ -->
<section class="py-10 bg-paper border-t border-rule" aria-label="Filtrar propiedades en renta">
    <div class="max-w-7xl mx-auto px-6">
        <form method="GET" action="/renta" class="grid grid-cols-1 sm:grid-cols-4 gap-4" role="search">
            <input name="city" type="text"
                   value="<?php echo escR($filters['city'] ?? ''); ?>"
                   placeholder="Ciudad"
                   class="px-4 py-3 border border-rule rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                   aria-label="Filtrar por ciudad">
            <select name="bedrooms" class="px-4 py-3 border border-rule rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gold" aria-label="Filtrar por habitaciones">
                <option value="">Habitaciones</option>
                <?php foreach ([1,2,3,4] as $n): ?>
                <option value="<?php echo $n; ?>" <?php echo ($filters['bedrooms'] ?? '') == $n ? 'selected' : ''; ?>><?php echo $n; ?>+</option>
                <?php endforeach; ?>
            </select>
            <input name="price_max" type="number"
                   value="<?php echo (int)($filters['price_max'] ?? 0) ?: ''; ?>"
                   placeholder="Renta máxima"
                   class="px-4 py-3 border border-rule rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                   min="0" aria-label="Renta máxima">
            <button type="submit" class="py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                Aplicar filtros
            </button>
        </form>
    </div>
</section>

<script>
(function () {
    'use strict';
    // ── HERO SLIDESHOW ────────────────────────────────────────────
    const slides = document.querySelectorAll('#slidesContainer .slide');
    const dots   = document.querySelectorAll('.slide-dot');
    let current  = 0;
    let timer    = null;

    function showSlide(idx) {
        slides[current].classList.replace('opacity-100', 'opacity-0');
        dots[current].classList.remove('opacity-100', 'scale-125');
        dots[current].classList.add('opacity-40');
        dots[current].setAttribute('aria-selected', 'false');

        current = (idx + slides.length) % slides.length;

        slides[current].classList.replace('opacity-0', 'opacity-100');
        dots[current].classList.remove('opacity-40');
        dots[current].classList.add('opacity-100', 'scale-125');
        dots[current].setAttribute('aria-selected', 'true');
    }

    function startTimer() { timer = setInterval(function () { showSlide(current + 1); }, 5000); }
    function stopTimer()  { clearInterval(timer); }

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () { stopTimer(); showSlide(i); startTimer(); });
    });

    const hero = document.getElementById('heroSlideshow');
    hero?.addEventListener('mouseenter', stopTimer);
    hero?.addEventListener('mouseleave', startTimer);

    if (slides.length > 1) startTimer();

    // ── CALENDARIO VANILLA JS ────────────────────────────────────
    const title        = document.getElementById('calendarTitle');
    const grid         = document.getElementById('calendarGrid');
    const prevBtn      = document.getElementById('prevMonth');
    const nextBtn      = document.getElementById('nextMonth');
    const clearBtn     = document.getElementById('clearDates');
    const checkInLbl   = document.getElementById('checkInLabel');
    const checkOutLbl  = document.getElementById('checkOutLabel');

    if (!title || !grid) return;

    const now = new Date();
    let yr = now.getFullYear(), mo = now.getMonth();
    let checkIn = null, checkOut = null;

    function fmt(d) { return d.toLocaleDateString('es-MX', { day: '2-digit', month: 'short', year: 'numeric' }); }
    function sameDay(a, b) { return a && b && a.toDateString() === b.toDateString(); }

    function render() {
        const firstDay = new Date(yr, mo, 1);
        const days     = new Date(yr, mo + 1, 0).getDate();
        title.textContent = firstDay.toLocaleDateString('es-MX', { month: 'long', year: 'numeric' })
            .replace(/^\w/, c => c.toUpperCase());
        grid.innerHTML = '';

        let dow = firstDay.getDay() || 7;
        for (let i = 1; i < dow; i++) {
            const e = document.createElement('div'); e.className = 'h-8'; grid.appendChild(e);
        }

        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
        for (let d = 1; d <= days; d++) {
            const dateObj = new Date(yr, mo, d);
            const btn     = document.createElement('button');
            btn.type      = 'button';
            btn.textContent = d;
            const past    = dateObj < today;
            const isIn    = sameDay(dateObj, checkIn);
            const isOut   = sameDay(dateObj, checkOut);
            const inRange = checkIn && checkOut && dateObj > checkIn && dateObj < checkOut;

            btn.className = [
                'h-8 w-full rounded text-xs transition focus:outline-none',
                past    ? 'opacity-30 cursor-not-allowed text-muted' : 'hover:bg-gold/30',
                isIn    ? 'bg-ink text-paper font-bold' : '',
                isOut   ? 'bg-gold text-ink font-bold' : '',
                inRange ? 'bg-gold/20' : '',
            ].join(' ');
            btn.disabled = past;
            btn.setAttribute('aria-label', dateObj.toLocaleDateString('es-MX'));

            btn.addEventListener('click', function () {
                if (!checkIn || (checkIn && checkOut)) { checkIn = dateObj; checkOut = null; }
                else if (dateObj >= checkIn)            { checkOut = dateObj; }
                else                                    { checkIn = dateObj; checkOut = null; }
                checkInLbl.textContent  = checkIn  ? fmt(checkIn)  : 'Sin seleccionar';
                checkOutLbl.textContent = checkOut ? fmt(checkOut) : 'Sin seleccionar';
                render();
            });
            grid.appendChild(btn);
        }
    }

    prevBtn.addEventListener('click', function () { mo--; if (mo < 0) { mo = 11; yr--; } render(); });
    nextBtn.addEventListener('click', function () { mo++; if (mo > 11) { mo = 0;  yr++; } render(); });
    clearBtn.addEventListener('click', function () {
        checkIn = null; checkOut = null;
        checkInLbl.textContent = 'Sin seleccionar';
        checkOutLbl.textContent = 'Sin seleccionar';
        render();
    });

    render();
})();
</script>
