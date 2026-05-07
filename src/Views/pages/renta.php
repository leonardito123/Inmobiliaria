<?php
/**
 * Renta Landing Page — 7 secciones del reto
 *
 * Variables: $properties, $filters, $country_code, $currency
 */
function escR(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

function resolveRentaCardImage(array $prop): string {
    $slug = str_replace('ñ', 'n', (string)($prop['slug'] ?? 'default'));
    $jpg = '/images/properties/' . $slug . '.jpg';

    if (file_exists(ROOT_PATH . '/public' . $jpg)) {
        return $jpg;
    }

    $title = mb_strtolower((string)($prop['meta_title'] ?? ''), 'UTF-8');
    $title = strtr($title, [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n',
    ]);

    $map = [
        ['keys' => ['roma', 'loft', 'studio', 'laureles'], 'img' => '/images/properties/renta-loft-roma-mx.jpg'],
        ['keys' => ['poblado', 'apartamento', 'apto', 'departamento', 'depto'], 'img' => '/images/properties/renta-poblado-co.jpg'],
        ['keys' => ['casa', 'residencial', 'villa', 'family'], 'img' => '/images/properties/casa-residencial-mx.jpg'],
        ['keys' => ['lomas', 'penthouse', 'reforma'], 'img' => '/images/properties/penthouse-reforma-mx.jpg'],
        ['keys' => ['vitacura', 'nunoa'], 'img' => '/images/properties/apto-vitacura-cl.jpg'],
    ];

    foreach ($map as $rule) {
        foreach ($rule['keys'] as $key) {
            if (str_contains($title, $key)) {
                return $rule['img'];
            }
        }
    }

    return '/images/properties/casa-lomas-mx.jpg';
}

$faqs = [
    ['q' => '¿Cuál es el período mínimo de renta?',    'a' => 'El mínimo es de 30 días para renta mensual, o 3 noches para estadías cortas en propiedades vacacionales.'],
    ['q' => '¿Qué incluye la renta?',                  'a' => 'Incluye mantenimiento de áreas comunes, seguridad 24/7, internet, agua y gas según el contrato negociado.'],
    ['q' => '¿Puedo pagar con tarjeta de crédito?',    'a' => 'Sí, aceptamos Visa, Mastercard y transferencia bancaria. El cargo de comisión lo absorbe la plataforma.'],
    ['q' => '¿Hay depósito de garantía?',              'a' => 'Sí, equivale a 1-2 meses de renta según la propiedad. Se devuelve íntegro al finalizar el contrato sin daños.'],
    ['q' => '¿Puedo llevar mascotas?',                 'a' => 'Depende de la política de cada propiedad. Filtra por "Pet-friendly" en el buscador para ver opciones disponibles.'],
];

$experiences = [
    ['icon' => 'M12 3v1m0 16v1M4.22 4.22l.71.71M18.36 18.36l.71.71M1 12h1M21 12h1M4.22 19.78l.71-.71M18.36 5.64l.71-.71', 'title' => 'Tour fotográfico', 'desc' => 'Sesión profesional en tu nueva propiedad.', 'image' => '/images/renta-experiencias/tour-fotografico.jpg'],
    ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'title' => 'Recorrido VIP', 'desc' => 'Agente exclusivo disponible con agenda flexible.', 'image' => '/images/renta-experiencias/recorrido-vip.jpg'],
    ['icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'title' => 'Guía de vecindario', 'desc' => 'Mapa curado con restaurantes, mercados y parques.', 'image' => '/images/renta-experiencias/guia-vecindario.jpg'],
    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Conexión con comunidad', 'desc' => 'Grupos locales y eventos de bienvenida.', 'image' => '/images/renta-experiencias/conexion-comunidad.jpg'],
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
            ['alt' => 'Loft moderno en Roma Norte',   'src' => 'renta-loft-roma-mx'],
            ['alt' => 'Departamento en El Poblado',   'src' => 'renta-poblado-co'],
            ['alt' => 'Casa residencial con amenidades', 'src' => 'casa-residencial-mx'],
        ];
        foreach ($slides as $i => $slide): ?>
        <figure class="slide absolute inset-0 transition-opacity duration-700 <?php echo $i === 0 ? 'opacity-100' : 'opacity-0'; ?>">
            <picture>
                <img src="/images/properties/<?php echo escR($slide['src']); ?>.jpg"
                     alt="<?php echo escR($slide['alt']); ?>"
                     class="w-full h-full object-cover"
                     onerror="this.onerror=null;this.src='/images/properties/<?php echo escR($slide['src']); ?>.svg'"
                     <?php echo $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
            </picture>
        </figure>
        <?php endforeach; ?>
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-ink/20 via-ink/40 to-ink/80" aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 text-paper">
        <p class="text-gold font-mono text-xs tracking-[0.25em] uppercase mb-3 anim-copy" style="animation-delay:0.1s;">01 · Renta Premium</p>
        <h1 class="font-serif font-black leading-[0.94] mb-4 max-w-4xl"
            style="font-size:clamp(3rem,7vw,6rem);text-shadow:0 8px 30px rgba(0,0,0,.45);">
            <span class="anim-word" style="animation-delay:0.18s;">Tu</span>
            <span class="anim-word" style="animation-delay:0.26s;">próximo</span>
            <span class="anim-word" style="animation-delay:0.34s;">hogar,</span><br>
            <span class="anim-word text-gold italic" style="animation-delay:0.46s;">sin</span>
            <span class="anim-word text-gold italic" style="animation-delay:0.56s;">compromiso</span>
        </h1>
        <p class="text-paper/82 text-base md:text-lg max-w-2xl leading-relaxed mb-8 anim-copy" style="animation-delay:0.68s;">
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
<section class="py-16 bg-paper border-b border-rule text-ink" id="temporadas" aria-label="Precios por temporada">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-[0.28em] uppercase mb-1">02 · Temporadas</p>
        <h2 class="text-3xl font-serif font-black uppercase tracking-[0.03em] mb-8">Precios dinámicos según temporada</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10 items-stretch">
            <div class="lg:col-span-2 rounded-2xl overflow-hidden relative min-h-[260px] border border-black/8 shadow-[0_16px_40px_rgba(15,15,15,0.06)]">
                <img src="/images/renta-secciones/temporadas-luxury-stay.jpg"
                     alt="Estancia premium para temporada de renta"
                     class="absolute inset-0 w-full h-full object-cover"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='/images/property-fallback.svg'">
                <div class="absolute inset-0 bg-gradient-to-r from-black/78 via-black/45 to-black/20"></div>
                <div class="relative z-10 h-full flex flex-col justify-end p-6 md:p-8 text-paper">
                    <p class="font-mono text-[10px] uppercase tracking-[0.28em] text-gold/80 mb-2">Selección flexible</p>
                    <h3 class="font-serif font-black uppercase tracking-[0.03em] mb-3" style="font-size:clamp(1.3rem,2.8vw,2.2rem);">Tarifas que se ajustan a la temporada y al estilo de estancia</h3>
                    <p class="max-w-xl text-paper/70 text-sm leading-relaxed">Mantén claridad de precio en baja, media y alta temporada con una visual más alineada al tono premium del proyecto.</p>
                </div>
            </div>

            <div class="lg:col-span-1 grid grid-cols-1 gap-4 self-start">
                <?php foreach ($temporadas as $t): ?>
                <div class="bg-white border border-black/8 rounded-2xl p-5 min-h-[152px] shadow-[0_12px_32px_rgba(15,15,15,0.05)]">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <span class="font-serif font-bold text-[1.75rem] leading-none <?php echo escR($t['color']); ?>"><?php echo escR($t['name']); ?></span>
                            <p class="text-[10px] text-muted mt-3 font-mono tracking-[0.16em] uppercase"><?php echo escR($t['months']); ?></p>
                        </div>
                        <span class="shrink-0 text-[10px] font-mono bg-[#f3ecda] text-[#6e5a18] px-2.5 py-1 rounded-full tracking-[0.18em] uppercase"><?php echo escR($t['badge']); ?></span>
                    </div>
                    <div class="flex items-end justify-between gap-4 border-t border-black/8 pt-4">
                        <div>
                            <p class="text-[10px] text-muted uppercase tracking-[0.18em] mb-1">Desde</p>
                            <p class="text-[2rem] leading-none font-serif font-black text-gold" data-base="25000" data-mult="<?php echo $t['mult']; ?>">
                                $<?php echo number_format(25000 * $t['mult'], 0, '.', ','); ?>
                            </p>
                        </div>
                        <span class="text-[11px] font-sans font-normal text-muted shrink-0"><?php echo escR($currency ?? 'MXN'); ?>/mes</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Selector dinámico Alpine.js -->
        <div x-data="{
            precio_base: 25000,
            meses: 1,
            temporada: 1.0,
            get total() { return Math.round(this.precio_base * this.temporada * this.meses); },
            fmt(n) { return n.toLocaleString('es-MX'); }
        }" class="mt-2 mx-auto max-w-5xl rounded-2xl border border-ink/10 bg-ink text-paper overflow-hidden shadow-[0_18px_48px_rgba(15,15,15,0.18)]">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-6 md:p-8 border-b lg:border-b-0 lg:border-r border-white/10">
                    <p class="font-serif font-bold text-xl mb-6">Calcula tu renta</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4">
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
                </div>
                <div class="relative p-6 md:p-8 bg-white/[0.03] flex flex-col justify-end min-h-[260px]">
                    <img src="/images/renta-secciones/reserva-privada.jpg"
                         alt="Interior premium para cálculo de renta"
                         class="absolute inset-0 w-full h-full object-cover opacity-30"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='/images/property-fallback.svg'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/55 to-black/20"></div>
                    <div class="relative z-10">
                    <p class="text-paper/50 text-xs uppercase tracking-[0.2em] mb-2">Total estimado</p>
                    <p class="text-5xl md:text-6xl font-serif font-black text-gold leading-none" aria-live="polite" x-text="'$' + fmt(total)"></p>
                    <p class="mt-4 text-paper/45 text-xs uppercase tracking-[0.16em]">Moneda referencial <?php echo escR($currency ?? 'MXN'); ?> · Sujeto a temporada</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     3. FORMULARIO MULTISTEP (3 pasos)
     ══════════════════════════════════ -->
<section class="py-20 bg-white text-ink" id="multistep" aria-label="Formulario de reserva en 3 pasos">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-[0.28em] uppercase mb-1">03 · Reservar</p>
        <h2 class="text-3xl font-serif font-black uppercase tracking-[0.03em] mb-10">Solicita tu visita en 3 pasos</h2>

        <div x-data="{
            step: 1,
            visitDate: '',
            visitTime: '',
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
            <div class="flex items-center gap-2 mb-10 max-w-2xl mx-auto" role="progressbar" :aria-valuenow="step" aria-valuemin="1" aria-valuemax="3">
                <template x-for="n in 3" :key="n">
                    <div class="flex items-center gap-2 flex-1">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-[11px] font-mono font-bold border transition"
                             :class="step >= n ? 'bg-ink text-paper border-ink shadow-[0_8px_18px_rgba(15,15,15,0.18)]' : 'bg-white text-muted border-black/10'"
                             :aria-current="step === n ? 'step' : undefined"
                             x-text="n"></div>
                        <div class="flex-1 h-px transition" :class="step > n ? 'bg-ink' : 'bg-black/10'" x-show="n < 3"></div>
                    </div>
                </template>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 bg-white border border-black/8 rounded-2xl overflow-hidden shadow-[0_16px_40px_rgba(15,15,15,0.06)]">
                <div class="relative min-h-[220px] lg:min-h-full lg:col-span-5 order-2 lg:order-1">
                    <img src="/images/renta-secciones/agenda-visita.jpg"
                         alt="Agenda una visita privada"
                         class="absolute inset-0 w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='/images/property-fallback.svg'">
                    <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-black/78 via-black/45 to-black/20"></div>
                    <div class="relative z-10 h-full flex flex-col justify-end p-5 md:p-6 text-paper">
                        <p class="font-mono text-[10px] uppercase tracking-[0.28em] text-gold/80 mb-2">Reserva guiada</p>
                        <h3 class="font-serif font-black uppercase tracking-[0.03em] mb-2" style="font-size:clamp(1.05rem,2.1vw,1.55rem);">Coordina una visita privada con fechas y preferencias claras</h3>
                        <p class="text-paper/70 text-sm leading-relaxed max-w-sm">Agenda el recorrido con una experiencia más directa y ordenada.</p>
                    </div>
                </div>

                <div class="lg:col-span-7 p-6 md:p-8 lg:p-10 order-1 lg:order-2">
                <!-- PASO 1: Fecha de visita -->
                <div x-show="step === 1" x-transition>
                    <h3 class="font-serif font-bold text-xl mb-2">Selecciona la fecha de tu visita</h3>
                    <p class="text-muted text-sm mb-6">Elige el día en que te gustaría agendar el recorrido con un agente.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="ms_visitdate" class="block text-sm font-semibold text-muted mb-2">Fecha de la visita</label>
                            <input id="ms_visitdate" type="date" x-model="visitDate"
                                   :min="new Date().toISOString().split('T')[0]"
                                   class="w-full px-4 py-3 border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-gold"
                                   required>
                        </div>
                        <div>
                            <label for="ms_visittime" class="block text-sm font-semibold text-muted mb-2">Hora preferida</label>
                            <input id="ms_visittime" type="time" x-model="visitTime"
                                   min="09:00" max="19:00"
                                   class="w-full px-4 py-3 border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-gold"
                                   required>
                        </div>
                    </div>
                    <button @click="next()" :disabled="!visitDate || !visitTime"
                            class="inline-flex items-center justify-center min-w-[180px] px-8 py-3 bg-ink text-paper font-bold rounded-full hover:bg-accent transition disabled:opacity-40 focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
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
                                        class="w-10 h-10 rounded-full border border-black/10 text-xl font-bold hover:bg-black/5 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink"
                                        aria-label="Reducir huéspedes">−</button>
                                <span class="text-3xl font-serif font-bold w-12 text-center" x-text="guests" id="ms_guests" aria-live="polite"></span>
                                <button type="button" @click="if(guests < 12) guests++"
                                        class="w-10 h-10 rounded-full border border-black/10 text-xl font-bold hover:bg-black/5 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink"
                                        aria-label="Aumentar huéspedes">+</button>
                            </div>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="pets" class="w-5 h-5 accent-gold">
                            <span class="text-sm font-semibold">¿Viajan con mascotas?</span>
                        </label>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button @click="prev()" class="px-6 py-3 border border-black/10 rounded-full font-bold hover:bg-black/5 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">← Atrás</button>
                        <button @click="next()" class="inline-flex items-center justify-center min-w-[180px] px-8 py-3 bg-ink text-paper font-bold rounded-full hover:bg-accent transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">Siguiente →</button>
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
                                       class="w-full px-4 py-3 border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-gold"
                                       placeholder="Ana García">
                            </div>
                            <div>
                                <label for="ms_email" class="block text-sm font-semibold text-muted mb-2">Correo electrónico *</label>
                                <input id="ms_email" type="email" x-model="email" required
                                       class="w-full px-4 py-3 border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-gold"
                                       placeholder="ana@ejemplo.com">
                            </div>
                            <div>
                                <label for="ms_phone" class="block text-sm font-semibold text-muted mb-2">Teléfono</label>
                                <input id="ms_phone" type="tel" x-model="phone"
                                       class="w-full px-4 py-3 border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-gold"
                                       placeholder="+52 55 0000 0000">
                            </div>
                            <!-- Resumen -->
                            <div class="bg-[#faf6ee] border border-black/8 rounded-xl p-4 text-sm">
                                <p class="font-semibold mb-2">Resumen de solicitud</p>
                                <p class="text-muted">Fecha de visita: <strong x-text="visitDate"></strong> · <strong x-text="visitTime"></strong></p>
                                <p class="text-muted">Huéspedes: <strong x-text="guests"></strong> <span x-show="pets">· Con mascotas</span></p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="button" @click="prev()" class="px-6 py-3 border border-black/10 rounded-full font-bold hover:bg-black/5 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">← Atrás</button>
                                <button type="submit" :disabled="!name || !email"
                                    class="flex-1 min-w-[180px] py-3 bg-gold text-ink font-bold rounded-full hover:bg-gold/90 transition disabled:opacity-40 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                                    Solicitar visita →
                                </button>
                            </div>
                        </form>
                    </template>
                </div>
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
            <article class="group rounded-2xl overflow-hidden border border-white/10 bg-white/[0.03] hover:bg-white/[0.05] transition-all duration-300 hover:-translate-y-1">
                <div class="relative aspect-[4/5] overflow-hidden">
                    <img src="<?php echo escR($exp['image']); ?>"
                         alt="<?php echo escR($exp['title']); ?>"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='/images/property-fallback.svg'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 h-[2px] bg-gold scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100"></div>
                    <div class="absolute top-4 left-4 flex items-center justify-center w-11 h-11 rounded-full border border-white/20 bg-black/45 backdrop-blur-sm text-gold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo escR($exp['icon']); ?>"/>
                        </svg>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 p-5">
                        <p class="font-mono text-[10px] uppercase tracking-[0.24em] text-gold/80 mb-2">Experiencia incluida</p>
                        <h3 class="font-serif font-bold text-xl mb-2 leading-tight"><?php echo escR($exp['title']); ?></h3>
                        <p class="text-paper/70 text-sm leading-relaxed"><?php echo escR($exp['desc']); ?></p>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     5. PROPIEDADES DISPONIBLES + CALENDARIO
     ══════════════════════════════════ -->
<section class="py-14 bg-paper text-ink" id="listado-renta" aria-label="Propiedades en renta disponibles">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-[0.28em] uppercase mb-1">05 · Disponibilidad</p>
        <h2 class="text-3xl font-serif font-black uppercase tracking-[0.03em] mb-10">Propiedades disponibles en <?php echo escR($country_code ?? 'MX'); ?></h2>
        <div style="display:flex;flex-wrap:wrap;gap:2rem;align-items:flex-start;">
            <!-- Cards: crecen para llenar el espacio -->
            <div style="flex:1;min-width:280px;">
                <?php if (empty($properties)): ?>
                <div class="bg-white border border-black/8 rounded-2xl p-10 text-center shadow-[0_14px_40px_rgba(15,15,15,0.05)]">
                    <p class="font-serif font-bold text-xl mb-3">Sin propiedades disponibles</p>
                    <div class="w-12 h-px bg-gold mx-auto mb-4"></div>
                    <p class="text-muted">Sin propiedades de renta en este país.</p>
                </div>
                <?php else: ?>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
                    <?php foreach ($properties as $prop):
                        $cardImg = resolveRentaCardImage($prop);
                    ?>
                    <article class="group rounded-2xl overflow-hidden border border-black/10 bg-white shadow-[0_12px_40px_rgba(15,15,15,0.06)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_18px_55px_rgba(15,15,15,0.12)]"
                             itemscope itemtype="https://schema.org/Accommodation">
                        <div class="relative overflow-hidden" style="aspect-ratio:16/10;">
                            <img src="<?php echo escR($cardImg); ?>"
                                 alt="<?php echo escR($prop['meta_title'] ?? 'Propiedad en renta'); ?>"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                 loading="lazy"
                                 onerror="this.onerror=null;this.src='/images/property-fallback.svg'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 h-[2px] bg-gold scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500"></div>
                            <div class="absolute top-4 left-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-black/45 px-3 py-1 text-[10px] font-mono uppercase tracking-[0.24em] text-gold/90 backdrop-blur-sm">
                                Renta premium
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between gap-3 text-paper">
                                <div>
                                    <p class="font-mono text-[10px] uppercase tracking-[0.24em] text-paper/70 mb-1"><?php echo escR($prop['city'] ?? ''); ?></p>
                                    <h3 class="font-serif font-bold text-xl leading-tight" itemprop="name"><?php echo escR($prop['meta_title'] ?? 'Propiedad en renta'); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 md:p-6">
                            <div class="flex flex-wrap gap-2 mb-5 text-[11px] text-[#4b463c] font-mono uppercase tracking-[0.14em]">
                                <span class="rounded-full bg-[#f4efe4] px-3 py-1"><?php echo (int)($prop['bedrooms'] ?? 0); ?> hab.</span>
                                <span class="rounded-full bg-[#f4efe4] px-3 py-1"><?php echo (int)($prop['bathrooms'] ?? 0); ?> baños</span>
                                <span class="rounded-full bg-[#f4efe4] px-3 py-1"><?php echo (int)($prop['sqm'] ?? 0); ?> m²</span>
                            </div>
                            <div class="flex items-end justify-between gap-4 border-t border-black/8 pt-5">
                                <p class="text-2xl font-serif font-bold text-gold" itemprop="price">
                                $<?php echo number_format((float)($prop['price'] ?? 0), 0, '.', ','); ?>
                                <span class="text-xs font-sans font-normal text-muted"><?php echo escR($currency ?? 'MXN'); ?>/mes</span>
                                </p>
                                <a href="#multistep" class="inline-flex items-center justify-center min-w-[140px] px-5 py-3 border border-ink text-ink rounded-full font-mono text-[10px] tracking-[0.24em] uppercase hover:bg-ink hover:text-paper transition focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                                    Solicitar visita
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Calendario: columna lateral fija -->
            <div style="width:100%;max-width:320px;flex-shrink:0;" class="bg-white border border-black/8 rounded-2xl overflow-hidden shadow-[0_14px_40px_rgba(15,15,15,0.05)]">
                <div class="relative overflow-hidden" style="aspect-ratio:16/8;">
                    <img src="/images/renta-secciones/agenda-visita.jpg"
                         alt="Agenda una visita a una propiedad en renta"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='/images/property-fallback.svg'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/35 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5 text-paper">
                        <h3 class="text-xl font-serif font-bold mb-1">Calendario de visitas</h3>
                        <p class="text-[11px] text-paper/70 uppercase tracking-[0.14em]">Elige una fecha para tu recorrido.</p>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-4">
                        <button id="prevMonth" class="px-3 py-1 border border-black/10 rounded-full text-sm hover:bg-black/5 transition focus:outline-none" aria-label="Mes anterior">‹</button>
                        <h4 id="calendarTitle" class="font-semibold text-sm uppercase tracking-[0.12em]"></h4>
                        <button id="nextMonth" class="px-3 py-1 border border-black/10 rounded-full text-sm hover:bg-black/5 transition focus:outline-none" aria-label="Mes siguiente">›</button>
                    </div>
                    <div class="grid grid-cols-7 text-xs text-center text-muted mb-2 gap-1">
                        <span>Lu</span><span>Ma</span><span>Mi</span><span>Ju</span><span>Vi</span><span>Sa</span><span>Do</span>
                    </div>
                    <div id="calendarGrid" class="grid grid-cols-7 gap-1"></div>
                    <div class="mt-4 border-t border-black/8 pt-4 text-sm space-y-1">
                        <p><strong>Seleccionado:</strong> <span id="checkInLabel" class="text-muted">Sin seleccionar</span></p>
                        <button id="clearDates" class="mt-2 px-4 py-2 border border-black/10 rounded-full text-xs hover:bg-black/5 transition">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     6. FAQ — acordeón CSS (details/summary)
     ══════════════════════════════════ -->
<section class="py-20 bg-black border-t border-white/5 text-paper" id="faq" aria-label="Preguntas frecuentes sobre renta">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="text-gold font-mono text-[10px] tracking-[0.3em] uppercase mb-2">06 · FAQ</p>
            <h2 class="font-serif font-black uppercase tracking-[0.04em] mb-4" style="font-size:clamp(1.5rem,3vw,2.4rem);">Preguntas frecuentes</h2>
            <p class="max-w-2xl mx-auto text-paper/50 text-sm leading-relaxed">Resolvemos las dudas más comunes sobre periodos, depósitos, servicios y condiciones de renta para que tomes una decisión con mayor claridad.</p>
            <div class="w-16 h-px bg-gold mx-auto mt-6"></div>
        </div>

        <div class="rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.04] to-transparent p-3 md:p-4">
            <div class="space-y-3">
                <?php foreach ($faqs as $i => $faq): ?>
                <details class="group rounded-xl border border-white/10 bg-black/30 overflow-hidden" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary class="flex items-center justify-between gap-4 px-5 md:px-6 py-5 cursor-pointer list-none select-none transition hover:bg-white/[0.03] focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-gold"
                             aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>">
                        <div class="flex items-center gap-4">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full border border-white/15 bg-white/[0.03] text-gold font-mono text-[10px] tracking-[0.2em]">0<?php echo $i + 1; ?></span>
                            <span class="font-serif font-bold text-lg leading-tight text-paper"><?php echo escR($faq['q']); ?></span>
                        </div>
                        <span class="flex items-center justify-center w-10 h-10 rounded-full border border-white/10 bg-white/[0.02] text-paper/60 group-open:text-gold transition-colors shrink-0">
                            <svg class="w-4 h-4 transition-transform duration-300 group-open:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                    </summary>
                    <div class="px-5 md:px-6 pb-6 pt-1 border-t border-white/8 text-paper/60 text-sm leading-relaxed">
                        <div class="pl-14 md:pl-[3.5rem]">
                            <?php echo escR($faq['a']); ?>
                        </div>
                    </div>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     7. FILTROS + CTA BOTTOM
     ══════════════════════════════════ -->
<section class="py-14 bg-black border-t border-white/5" aria-label="Filtrar propiedades en renta">
    <div class="max-w-7xl mx-auto px-6">
        <div class="rounded-2xl border border-white/12 bg-gradient-to-b from-white/[0.04] to-transparent p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-6">
                <div>
                    <p class="font-mono text-[10px] tracking-[0.28em] uppercase text-gold/80 mb-2">07 · Filtros rápidos</p>
                    <h2 class="font-serif font-black text-paper uppercase tracking-[0.04em]" style="font-size:clamp(1.1rem,2.2vw,1.5rem);">Encuentra tu renta ideal</h2>
                </div>
                <a href="/renta" class="inline-flex items-center justify-center px-5 py-2.5 border border-white/15 text-paper/60 text-[10px] font-mono tracking-[0.22em] uppercase hover:border-gold/50 hover:text-gold transition">Limpiar filtros</a>
            </div>

            <form method="GET" action="/renta" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" role="search">
                <input name="city" type="text"
                       value="<?php echo escR($filters['city'] ?? ''); ?>"
                       placeholder="Ciudad"
                       class="px-4 py-3 bg-white/5 border border-white/15 rounded-lg text-paper text-sm placeholder:text-paper/30 focus:outline-none focus:ring-1 focus:ring-gold"
                       aria-label="Filtrar por ciudad">

                <select name="bedrooms" class="px-4 py-3 bg-white/5 border border-white/15 rounded-lg text-paper text-sm focus:outline-none focus:ring-1 focus:ring-gold" aria-label="Filtrar por habitaciones">
                    <option value="" class="bg-ink text-paper">Habitaciones</option>
                    <?php foreach ([1,2,3,4] as $n): ?>
                    <option value="<?php echo $n; ?>" class="bg-ink text-paper" <?php echo ($filters['bedrooms'] ?? '') == $n ? 'selected' : ''; ?>><?php echo $n; ?>+</option>
                    <?php endforeach; ?>
                </select>

                <input name="price_max" type="number"
                       value="<?php echo (int)($filters['price_max'] ?? 0) ?: ''; ?>"
                       placeholder="Renta máxima"
                       class="px-4 py-3 bg-white/5 border border-white/15 rounded-lg text-paper text-sm placeholder:text-paper/30 focus:outline-none focus:ring-1 focus:ring-gold"
                       min="0" aria-label="Renta máxima">

                <button type="submit" class="py-3 border border-gold/60 text-gold text-[10px] font-mono tracking-[0.25em] uppercase rounded-lg hover:bg-gold hover:text-ink transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                    Aplicar filtros
                </button>
            </form>
        </div>
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
        if (!slides.length) return;
        slides[current].classList.replace('opacity-100', 'opacity-0');
        if (dots[current]) {
            dots[current].classList.remove('opacity-100', 'scale-125');
            dots[current].classList.add('opacity-40');
            dots[current].setAttribute('aria-selected', 'false');
        }

        current = (idx + slides.length) % slides.length;

        slides[current].classList.replace('opacity-0', 'opacity-100');
        if (dots[current]) {
            dots[current].classList.remove('opacity-40');
            dots[current].classList.add('opacity-100', 'scale-125');
            dots[current].setAttribute('aria-selected', 'true');
        }
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

    if (!title || !grid) return;

    const now = new Date();
    let yr = now.getFullYear(), mo = now.getMonth();
    let selected = null;

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
            const isSel   = sameDay(dateObj, selected);

            btn.className = [
                'h-8 w-full rounded text-xs transition focus:outline-none',
                past   ? 'opacity-30 cursor-not-allowed text-muted' : 'hover:bg-gold/30',
                isSel  ? 'bg-gold text-ink font-bold' : '',
            ].join(' ');
            btn.disabled = past;
            btn.setAttribute('aria-label', dateObj.toLocaleDateString('es-MX'));

            btn.addEventListener('click', function () {
                selected = dateObj;
                checkInLbl.textContent = fmt(selected);
                render();
            });
            grid.appendChild(btn);
        }
    }

    prevBtn.addEventListener('click', function () { mo--; if (mo < 0) { mo = 11; yr--; } render(); });
    nextBtn.addEventListener('click', function () { mo++; if (mo > 11) { mo = 0;  yr++; } render(); });
    clearBtn.addEventListener('click', function () {
        selected = null;
        checkInLbl.textContent = 'Sin seleccionar';
        render();
    });

    render();
})();
</script>
