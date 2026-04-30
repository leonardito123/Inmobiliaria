<div class="min-h-screen bg-paper text-ink">
    <section class="relative py-16 bg-gradient-to-br from-ink to-accent text-paper overflow-hidden">
        <div class="absolute -top-20 -right-16 w-64 h-64 rounded-full bg-gold/20 blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-6 relative">
            <p class="text-gold uppercase text-sm tracking-widest mb-3">Masterplan Interactivo</p>
            <h1 class="text-5xl font-serif font-bold mb-4">Desarrollos de Nueva Generacion</h1>
            <p class="max-w-3xl text-paper/80">Visualiza torres, fases y unidades disponibles en un plano interactivo. Selecciona un bloque para ver su estatus.</p>
        </div>
    </section>

    <section class="py-10 bg-white border-b border-rule">
        <div class="max-w-7xl mx-auto px-6">
            <form method="GET" class="flex flex-col md:flex-row gap-3">
                <input name="city" value="<?php echo htmlspecialchars($city); ?>" placeholder="Filtrar por ciudad" class="px-4 py-3 border border-rule rounded-lg w-full md:w-96" />
                <button class="px-6 py-3 bg-ink text-paper rounded-lg font-semibold">Aplicar</button>
            </form>
        </div>
    </section>

    <section class="py-14 bg-paper">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3 bg-white border border-rule rounded-xl p-6">
                <h2 class="text-2xl font-serif font-bold mb-3">Plano General</h2>
                <p class="text-sm text-muted mb-4">Haz clic en cada torre para ver disponibilidad y rango de precios.</p>

                <svg viewBox="0 0 640 420" class="w-full border border-rule rounded-lg bg-slate-50" role="img" aria-label="Plano interactivo de desarrollo">
                    <rect x="20" y="20" width="600" height="380" fill="#f6f7f8" stroke="#d6d9df" />
                    <rect x="60" y="80" width="120" height="180" class="tower" data-name="Torre A" data-status="Preventa" data-price="Desde $4,200,000" fill="#2c5f8a" />
                    <rect x="220" y="60" width="120" height="200" class="tower" data-name="Torre B" data-status="Construccion" data-price="Desde $5,600,000" fill="#b8942a" />
                    <rect x="380" y="100" width="120" height="160" class="tower" data-name="Torre C" data-status="Entrega 2027" data-price="Desde $6,200,000" fill="#c0392b" />
                    <rect x="540" y="120" width="60" height="140" class="tower" data-name="Amenidades" data-status="Operativo" data-price="Club y piscina" fill="#1f2937" />

                    <text x="95" y="170" fill="#fff" font-size="16">A</text>
                    <text x="255" y="170" fill="#111" font-size="16">B</text>
                    <text x="415" y="185" fill="#fff" font-size="16">C</text>
                    <text x="548" y="195" fill="#fff" font-size="12">CLUB</text>
                </svg>

                <div id="towerInfo" class="mt-4 p-4 border border-rule rounded-lg bg-slate-50 text-sm">
                    Selecciona un bloque del plano para ver detalles.
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-rule rounded-xl p-6">
                    <h3 class="text-xl font-serif font-bold mb-4">Linea de Tiempo</h3>
                    <ol class="space-y-3 text-sm">
                        <li class="p-3 rounded bg-slate-50 border border-rule"><strong>Fase 1:</strong> Cimentacion completada</li>
                        <li class="p-3 rounded bg-slate-50 border border-rule"><strong>Fase 2:</strong> Estructura Torre A y B</li>
                        <li class="p-3 rounded bg-slate-50 border border-rule"><strong>Fase 3:</strong> Fachadas y acabados premium</li>
                        <li class="p-3 rounded bg-slate-50 border border-rule"><strong>Fase 4:</strong> Entrega y escrituracion</li>
                    </ol>
                </div>

                <div class="bg-white border border-rule rounded-xl p-6">
                    <h3 class="text-xl font-serif font-bold mb-4">Inventario Disponible</h3>
                    <?php if (empty($developments)): ?>
                        <p class="text-sm text-muted">No hay desarrollos registrados con ese filtro.</p>
                    <?php else: ?>
                        <ul class="space-y-3 text-sm">
                            <?php foreach ($developments as $item): ?>
                                <li class="p-3 rounded border border-rule bg-slate-50">
                                    <p class="font-semibold"><?php echo htmlspecialchars($item['meta_title'] ?? 'Desarrollo'); ?></p>
                                    <p class="text-muted"><?php echo htmlspecialchars($item['city'] ?? 'Ciudad'); ?> · <?php echo htmlspecialchars($currency); ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
(function () {
    const towers = document.querySelectorAll('.tower');
    const info = document.getElementById('towerInfo');
    if (!towers.length || !info) {
        return;
    }

    towers.forEach(function (tower) {
        tower.style.cursor = 'pointer';

        tower.addEventListener('mouseenter', function () {
            tower.setAttribute('opacity', '0.85');
        });

        tower.addEventListener('mouseleave', function () {
            tower.setAttribute('opacity', '1');
        });

        tower.addEventListener('click', function () {
            const name = tower.getAttribute('data-name') || 'Bloque';
            const status = tower.getAttribute('data-status') || 'N/A';
            const price = tower.getAttribute('data-price') || 'N/A';

            info.innerHTML = '<strong>' + name + '</strong><br>Estatus: ' + status + '<br>Referencia: ' + price;
        });
    });
})();
</script>
