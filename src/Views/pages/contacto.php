<?php
/**
 * Contacto Landing Page — 7 secciones del reto
 *
 * Variables: $chat_csrf_token, $recaptcha_enabled, $recaptcha_site_key,
 *            $agents (array from Agent::getActive), $country_code
 */
function escC(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

// Agentes por defecto si el modelo no está disponible
$agentsList = $agents ?? [
    ['id' => 1, 'name' => 'Sofía Ramírez',  'job_title' => 'Directora Ventas',   'email' => 'sofia@havre-estates.com',   'phone' => '+52 55 4169 8259', 'languages' => ['es', 'en'], 'specialties' => ['residencial', 'lujo']],
    ['id' => 2, 'name' => 'Carlos Mendoza', 'job_title' => 'Agente Inversiones',  'email' => 'carlos@havre-estates.com',  'phone' => '+52 55 4169 8260', 'languages' => ['es'],        'specialties' => ['inversión', 'comercial']],
    ['id' => 3, 'name' => 'Laura Vega',     'job_title' => 'Especialista Renta',  'email' => 'laura@havre-estates.com',   'phone' => '+52 55 4169 8261', 'languages' => ['es', 'fr'],  'specialties' => ['renta', 'vacacional']],
];

$offices = [
    ['city' => 'Ciudad de México', 'address' => 'Paseo de la Reforma 296, Juárez', 'lat' => 19.4284, 'lng' => -99.1733],
    ['city' => 'Medellín',          'address' => 'El Poblado, Cra. 43A #7-50',       'lat' => 6.2088,  'lng' => -75.5695],
    ['city' => 'Santiago',          'address' => 'Las Condes, Av. Apoquindo 4600',    'lat' => -33.4125,'lng' => -70.5740],
];

$prensa = [
    ['name' => 'Forbes México',   'url' => 'https://forbes.com.mx',          'w' => 80,  'year' => 2024],
    ['name' => 'Expansión',       'url' => 'https://expansion.mx',           'w' => 100, 'year' => 2024],
    ['name' => 'El Economista',   'url' => 'https://eleconomista.com.mx',    'w' => 120, 'year' => 2023],
    ['name' => 'El País',         'url' => 'https://elpais.com',             'w' => 70,  'year' => 2023],
];

// JSON-LD para cada agente (Person schema)
$personSchemas = array_map(fn($a) => [
    '@context'      => 'https://schema.org',
    '@type'         => 'Person',
    'name'          => $a['name'],
    'jobTitle'      => $a['job_title'] ?? '',
    'email'         => $a['email']    ?? '',
    'telephone'     => $a['phone']    ?? '',
    'knowsLanguage' => is_array($a['languages'] ?? null) ? $a['languages'] : [],
    'worksFor'      => ['@type' => 'Organization', 'name' => 'Havre Estates'],
], $agentsList);
?>

<!-- ══════════════════════════════════
     JSON-LD — Agentes (Person)
     ══════════════════════════════════ -->
<?php foreach ($personSchemas as $ps): ?>
<script type="application/ld+json"><?php echo json_encode($ps, JSON_UNESCAPED_UNICODE); ?></script>
<?php endforeach; ?>

<!-- ══════════════════════════════════
     1. HERO EDITORIAL — Tipografía animada
     ══════════════════════════════════ -->
<style>
@keyframes fade-up { from { opacity:0; transform:translateY(1.5rem); } to { opacity:1; transform:translateY(0); } }
.anim-word { display:inline-block; animation:fade-up .6s ease both; }
</style>

<section class="relative min-h-[65vh] flex items-end pb-20 overflow-hidden bg-ink" aria-label="Hero Contacto">
    <!-- Tipografía editorial de fondo -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none" aria-hidden="true">
        <span class="text-[18vw] font-serif font-black text-white/[0.03] leading-none tracking-tighter">HAVRE</span>
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-ink/30 to-ink/95" aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 text-paper">
        <p class="text-gold font-mono text-xs tracking-[0.25em] uppercase mb-3 anim-word" style="animation-delay:0.1s">01 · Contacto</p>
        <h1 class="font-serif font-black leading-tight mb-6 text-5xl md:text-7xl max-w-4xl">
            <?php $words = ['Asesoría', 'inmobiliaria', 'en', 'tiempo', 'real'];
            foreach ($words as $i => $w): ?>
            <span class="anim-word" style="animation-delay:<?php echo 0.2 + $i * 0.1; ?>s"><?php echo escC($w); ?> </span>
            <?php endforeach; ?>
        </h1>
        <p class="text-paper/60 text-lg max-w-2xl anim-word" style="animation-delay:0.8s">
            Chat SSE en vivo, red de agentes especializados y oficinas en 3 países. Sin tiempos de espera.
        </p>
    </div>
</section>

<!-- ══════════════════════════════════
     2. CANALES DE ATENCIÓN
     ══════════════════════════════════ -->
<section class="py-14 bg-paper border-b border-rule" aria-label="Canales de atención">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">02 · Canales</p>
        <h2 class="text-3xl font-serif font-bold mb-8">Cómo contactarnos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php
            $channels = [
                ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                  'title' => 'Ventas Premium', 'value' => '+52 55 4169 8259', 'href' => 'tel:+5255416982591'],
                ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                  'title' => 'Inversionistas', 'value' => 'invest@havre-estates.com', 'href' => 'mailto:invest@havre-estates.com'],
                ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                  'title' => 'WhatsApp', 'value' => 'Atención 24/7', 'href' => 'https://wa.me/5255416982591'],
                ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                  'title' => 'Oficinas', 'value' => 'CDMX · Medellín · Santiago', 'href' => '#mapa-oficinas'],
            ];
            foreach ($channels as $ch): ?>
            <a href="<?php echo escC($ch['href']); ?>"
               class="p-5 border border-rule rounded-xl hover:border-gold hover:shadow-md transition group bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                <svg class="w-8 h-8 text-gold mb-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo escC($ch['icon']); ?>"/>
                </svg>
                <p class="font-semibold text-sm"><?php echo escC($ch['title']); ?></p>
                <p class="text-muted text-xs mt-1"><?php echo escC($ch['value']); ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     3. GRID AGENTES + Person schema HTML
     ══════════════════════════════════ -->
<section class="py-20 bg-white" id="agentes" aria-label="Nuestros agentes">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">03 · Equipo</p>
        <h2 class="text-3xl font-serif font-bold mb-10">Agentes especializados</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($agentsList as $agent): ?>
            <article class="bg-paper border border-rule rounded-xl p-6 hover:shadow-lg transition"
                     itemscope itemtype="https://schema.org/Person">
                <!-- Avatar -->
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-gold to-accent flex items-center justify-center text-paper font-serif font-bold text-xl mb-4" aria-hidden="true">
                    <?php echo mb_substr($agent['name'] ?? 'A', 0, 1); ?>
                </div>
                <h3 class="font-serif font-bold text-lg mb-0.5" itemprop="name"><?php echo escC($agent['name'] ?? ''); ?></h3>
                <p class="text-muted text-sm mb-3" itemprop="jobTitle"><?php echo escC($agent['job_title'] ?? ''); ?></p>
                <div class="space-y-1 text-sm">
                    <?php if ($agent['email'] ?? ''): ?>
                    <p><a href="mailto:<?php echo escC($agent['email']); ?>" class="text-accent hover:underline focus:outline-none focus-visible:ring-1 focus-visible:ring-accent" itemprop="email"><?php echo escC($agent['email']); ?></a></p>
                    <?php endif; ?>
                    <?php if ($agent['phone'] ?? ''): ?>
                    <p><a href="tel:<?php echo escC(preg_replace('/\s+/', '', $agent['phone'])); ?>" class="text-muted hover:text-ink" itemprop="telephone"><?php echo escC($agent['phone']); ?></a></p>
                    <?php endif; ?>
                </div>
                <?php if (!empty($agent['languages']) && is_array($agent['languages'])): ?>
                <div class="mt-3 flex gap-1 flex-wrap">
                    <?php foreach ($agent['languages'] as $lang): ?>
                    <span class="text-xs font-mono bg-rule px-2 py-0.5 rounded" itemprop="knowsLanguage"><?php echo escC(strtoupper($lang)); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     4. MAPA LEAFLET — Oficinas
     ══════════════════════════════════ -->
<section class="py-14 bg-paper" id="mapa-oficinas" aria-label="Mapa de oficinas">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">04 · Ubicaciones</p>
        <h2 class="text-3xl font-serif font-bold mb-8">Nuestras oficinas</h2>
        <div id="officesMap" class="w-full rounded-xl overflow-hidden border border-rule" style="height:420px;" role="application" aria-label="Mapa interactivo de oficinas">
            <!-- Leaflet map mounted by JS -->
        </div>
        <!-- Datos de oficinas para JS (JSON seguro) -->
        <script id="officesData" type="application/json">
        <?php echo json_encode(array_map(fn($o) => [
            'city'    => $o['city'],
            'address' => $o['address'],
            'lat'     => $o['lat'],
            'lng'     => $o['lng'],
        ], $offices), JSON_UNESCAPED_UNICODE); ?>
        </script>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <?php foreach ($offices as $office): ?>
            <div class="bg-white border border-rule rounded-xl p-4">
                <p class="font-serif font-bold"><?php echo escC($office['city']); ?></p>
                <p class="text-muted text-sm mt-1"><?php echo escC($office['address']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     5. CHAT SSE (mantenido del original)
     ══════════════════════════════════ -->
<section class="py-14 bg-white" id="chat-section" aria-label="Chat en tiempo real">
    <div class="max-w-3xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">05 · Chat</p>
        <h2 class="text-3xl font-serif font-bold mb-6">Chat en tiempo real</h2>

        <div class="bg-white border border-rule rounded-xl p-6 shadow-sm">
            <div id="chatBox" class="h-72 overflow-y-auto border border-rule rounded-lg p-3 bg-paper text-sm space-y-2" role="log" aria-live="polite" aria-label="Mensajes del chat"></div>

            <form id="chatForm" class="mt-4 space-y-3" novalidate>
                <input type="hidden" name="csrf_token" value="<?php echo escC($chat_csrf_token ?? ''); ?>">
                <input type="hidden" name="recaptcha_token" id="recaptchaToken" value="">
                <!-- Honeypot -->
                <div class="hidden" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="chatName" class="block text-xs font-semibold text-muted mb-1">Tu nombre</label>
                        <input id="chatName" name="name" type="text" required placeholder="Ana García"
                               class="w-full px-3 py-2 border border-rule rounded text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                    </div>
                    <div class="col-span-1 hidden sm:block"></div>
                </div>
                <div>
                    <label for="chatMessage" class="block text-xs font-semibold text-muted mb-1">Mensaje</label>
                    <textarea id="chatMessage" name="message" rows="3" required placeholder="Escribe tu consulta…"
                              class="w-full px-3 py-2 border border-rule rounded text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold"></textarea>
                </div>
                <button type="submit"
                        class="w-full py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                    Enviar mensaje →
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════
     6. MANIFIESTO DE MARCA — scroll-reveal
     ══════════════════════════════════ -->
<section class="py-24 bg-ink text-paper overflow-hidden" id="manifiesto" aria-label="Manifiesto de marca">
    <div class="max-w-4xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-4 opacity-0 reveal-item">06 · Manifiesto</p>
        <?php
        $manifesto_lines = [
            'Creemos que cada hogar cuenta una historia.',
            'Que una inversión bien hecha transforma vidas.',
            'Que la transparencia es la base de la confianza.',
            'Que el lujo es una experiencia, no solo un precio.',
        ];
        foreach ($manifesto_lines as $i => $line): ?>
        <p class="text-3xl md:text-5xl font-serif font-bold leading-snug mb-6 opacity-0 reveal-item" style="transition-delay:<?php echo $i * 0.15; ?>s">
            <?php echo escC($line); ?>
        </p>
        <?php endforeach; ?>
        <p class="text-paper/40 text-sm font-mono mt-10 opacity-0 reveal-item" style="transition-delay:0.6s">
            — Havre Estates · <?php echo date('Y'); ?>
        </p>
    </div>
</section>

<!-- ══════════════════════════════════
     7. PRENSA Y MENCIONES
     ══════════════════════════════════ -->
<section class="py-14 bg-paper border-t border-rule" id="prensa" aria-label="Prensa y menciones">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-gold font-mono text-xs tracking-widest uppercase mb-1">07 · Prensa</p>
        <h2 class="text-2xl font-serif font-bold mb-8">Nos han mencionado en</h2>
        <div class="flex flex-wrap items-center gap-10">
            <?php foreach ($prensa as $p): ?>
            <a href="<?php echo escC($p['url']); ?>" target="_blank" rel="noopener noreferrer"
               class="group text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded"
               aria-label="<?php echo escC($p['name']); ?> — <?php echo (int)$p['year']; ?>">
                <!-- Logo SVG placeholder -->
                <svg viewBox="0 0 120 36" style="width:<?php echo (int)$p['w']; ?>px" class="text-muted group-hover:text-ink transition" aria-hidden="true">
                    <rect x="0" y="8" width="120" height="20" rx="2" fill="currentColor" opacity="0.15"/>
                    <text x="60" y="23" text-anchor="middle" font-size="12" font-weight="bold" fill="currentColor"><?php echo escC($p['name']); ?></text>
                </svg>
                <p class="text-xs text-muted mt-1 font-mono"><?php echo (int)$p['year']; ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($recaptcha_enabled) && !empty($recaptcha_site_key)): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo urlencode((string)$recaptcha_site_key); ?>"></script>
<?php endif; ?>

<script>
(function () {
    'use strict';

    function escHtml(str) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(String(str)));
        return d.innerHTML;
    }

    // ── CHAT SSE ──────────────────────────────────────────────────
    var chatBox    = document.getElementById('chatBox');
    var chatForm   = document.getElementById('chatForm');
    var chatName   = document.getElementById('chatName');
    var chatMsg    = document.getElementById('chatMessage');
    var rcToken    = document.getElementById('recaptchaToken');
    var rcEnabled  = <?php echo !empty($recaptcha_enabled) ? 'true' : 'false'; ?>;
    var rcKey      = <?php echo json_encode($recaptcha_site_key ?? ''); ?>;
    var lastTs     = 0;

    function addChatItem(item) {
        var row = document.createElement('div');
        row.className = 'p-2 bg-white border border-rule rounded text-sm';
        row.innerHTML = '<strong>' + escHtml(item.name || 'Visitante') + '</strong>: ' + escHtml(item.message || '');
        chatBox?.appendChild(row);
        if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
        if (item.ts && Number(item.ts) > lastTs) lastTs = Number(item.ts);
    }

    function connectStream() {
        var es = new EventSource('/contacto/stream?since=' + lastTs);
        es.addEventListener('message', function (e) {
            try { addChatItem(JSON.parse(e.data)); } catch (_) {}
        });
        es.onerror = function () { es.close(); setTimeout(connectStream, 3000); };
    }

    if (chatBox) connectStream();

    chatForm?.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (rcEnabled && window.grecaptcha && rcKey) {
            try { rcToken.value = await grecaptcha.execute(rcKey, { action: 'contact_send' }); } catch (_) {}
        }
        var fd = new FormData(chatForm);
        try {
            var r   = await fetch('/contacto/send', { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            var pay = await r.json();
            if (pay.ok && pay.item) {
                addChatItem(pay.item);
                chatMsg.value = '';
                var csrfInput = chatForm.querySelector('[name="csrf_token"]');
                if (csrfInput && pay.csrf_token) csrfInput.value = pay.csrf_token;
            }
        } catch (_) {}
    });

    // ── MAPA LEAFLET — OFICINAS ───────────────────────────────────
    var mapEl    = document.getElementById('officesMap');
    var dataEl   = document.getElementById('officesData');
    if (mapEl && dataEl && window.L) {
        var offices = JSON.parse(dataEl.textContent || '[]');
        var map = L.map(mapEl, { scrollWheelZoom: false, zoomControl: true });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 18,
        }).addTo(map);

        var bounds = [];
        offices.forEach(function (o) {
            var marker = L.marker([o.lat, o.lng]).addTo(map);
            marker.bindPopup('<strong>' + escHtml(o.city) + '</strong><br>' + escHtml(o.address));
            bounds.push([o.lat, o.lng]);
        });
        if (bounds.length) map.fitBounds(bounds, { padding: [40, 40] });
    }

    // ── SCROLL-REVEAL (manifiesto) ────────────────────────────────
    var reveals = document.querySelectorAll('.reveal-item');
    if (!reveals.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
            if (en.isIntersecting) {
                en.target.style.opacity   = '1';
                en.target.style.transform = 'translateY(0)';
                io.unobserve(en.target);
            }
        });
    }, { threshold: 0.2 });

    reveals.forEach(function (el) {
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        el.style.transform  = 'translateY(1.5rem)';
        io.observe(el);
    });
})();
</script>
