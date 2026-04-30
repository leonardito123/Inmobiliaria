<div class="min-h-screen bg-paper text-ink">
    <section class="bg-ink text-paper py-16">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-gold text-sm uppercase tracking-widest mb-3">Renta Premium</p>
            <h1 class="text-5xl font-serif font-bold mb-4">Encuentra Tu Espacio Ideal</h1>
            <p class="text-paper/80 max-w-3xl">
                Selecciona fechas con nuestro calendario interactivo y explora propiedades en renta con disponibilidad inmediata.
            </p>
        </div>
    </section>

    <section class="py-8 border-b border-rule bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input name="city" value="<?php echo htmlspecialchars($filters['city']); ?>" placeholder="Ciudad" class="px-4 py-3 border border-rule rounded-lg" />
                <select name="bedrooms" class="px-4 py-3 border border-rule rounded-lg">
                    <option value="0">Habitaciones</option>
                    <option value="1" <?php echo $filters['bedrooms'] === 1 ? 'selected' : ''; ?>>1+</option>
                    <option value="2" <?php echo $filters['bedrooms'] === 2 ? 'selected' : ''; ?>>2+</option>
                    <option value="3" <?php echo $filters['bedrooms'] === 3 ? 'selected' : ''; ?>>3+</option>
                    <option value="4" <?php echo $filters['bedrooms'] === 4 ? 'selected' : ''; ?>>4+</option>
                </select>
                <input name="price_max" type="number" value="<?php echo (int) $filters['price_max']; ?>" placeholder="Renta maxima" class="px-4 py-3 border border-rule rounded-lg" />
                <button class="px-6 py-3 bg-accent text-paper rounded-lg font-semibold">Aplicar Filtros</button>
            </form>
        </div>
    </section>

    <section class="py-12 bg-paper">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 bg-white border border-rule rounded-xl p-6 h-fit">
                <h2 class="text-2xl font-serif font-bold mb-4">Calendario de Visitas</h2>
                <p class="text-sm text-muted mb-4">Selecciona llegada y salida para programar recorrido.</p>

                <div class="flex items-center justify-between mb-4">
                    <button id="prevMonth" class="px-3 py-1 border border-rule rounded">Anterior</button>
                    <h3 id="calendarTitle" class="font-semibold"></h3>
                    <button id="nextMonth" class="px-3 py-1 border border-rule rounded">Siguiente</button>
                </div>

                <div class="grid grid-cols-7 text-xs text-center text-muted mb-2">
                    <span>Lu</span><span>Ma</span><span>Mi</span><span>Ju</span><span>Vi</span><span>Sa</span><span>Do</span>
                </div>
                <div id="calendarGrid" class="grid grid-cols-7 gap-1"></div>

                <div class="mt-6 border-t border-rule pt-4 text-sm">
                    <p><strong>Llegada:</strong> <span id="checkInLabel">Sin seleccionar</span></p>
                    <p><strong>Salida:</strong> <span id="checkOutLabel">Sin seleccionar</span></p>
                    <button id="clearDates" class="mt-3 px-4 py-2 border border-rule rounded">Limpiar fechas</button>
                </div>
            </div>

            <div class="lg:col-span-2">
                <h2 class="text-3xl font-serif font-bold mb-6">Disponibles en <?php echo htmlspecialchars($country_code); ?></h2>

                <?php if (empty($properties)): ?>
                    <div class="bg-white border border-rule rounded-xl p-10 text-center">
                        <p class="text-muted">Aun no hay propiedades de renta en este pais. Puedes insertar mas datos semilla.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($properties as $property): ?>
                            <article class="bg-white border border-rule rounded-xl overflow-hidden shadow-sm">
                                <div class="h-44 bg-gradient-to-br from-accent to-ink flex items-center justify-center text-paper font-bold text-xl">
                                    <?php echo htmlspecialchars($property['city']); ?>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-xl font-serif font-bold mb-2"><?php echo htmlspecialchars($property['meta_title'] ?? 'Propiedad en renta'); ?></h3>
                                    <p class="text-sm text-muted mb-4"><?php echo htmlspecialchars($property['meta_desc'] ?? ''); ?></p>
                                    <div class="flex gap-3 text-sm mb-4">
                                        <span><?php echo (int) ($property['bedrooms'] ?? 0); ?> hab.</span>
                                        <span><?php echo (int) ($property['bathrooms'] ?? 0); ?> banos</span>
                                        <span><?php echo (int) ($property['sqm'] ?? 0); ?> m2</span>
                                    </div>
                                    <p class="text-2xl font-bold text-gold mb-4">$<?php echo number_format((float) ($property['price'] ?? 0), 0, '.', ','); ?> <?php echo htmlspecialchars($currency); ?>/mes</p>
                                    <button class="w-full py-2 bg-ink text-paper rounded-lg">Solicitar visita</button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<script>
(function () {
    const title = document.getElementById('calendarTitle');
    const grid = document.getElementById('calendarGrid');
    const prevBtn = document.getElementById('prevMonth');
    const nextBtn = document.getElementById('nextMonth');
    const clearBtn = document.getElementById('clearDates');
    const checkInLabel = document.getElementById('checkInLabel');
    const checkOutLabel = document.getElementById('checkOutLabel');

    if (!title || !grid || !prevBtn || !nextBtn || !clearBtn) {
        return;
    }

    const now = new Date();
    let currentYear = now.getFullYear();
    let currentMonth = now.getMonth();
    let checkIn = null;
    let checkOut = null;

    function fmtDate(dateObj) {
        return dateObj.toLocaleDateString('es-MX', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function resetLabels() {
        checkInLabel.textContent = checkIn ? fmtDate(checkIn) : 'Sin seleccionar';
        checkOutLabel.textContent = checkOut ? fmtDate(checkOut) : 'Sin seleccionar';
    }

    function isSameDay(a, b) {
        return a && b && a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
    }

    function renderCalendar() {
        const monthName = new Date(currentYear, currentMonth, 1).toLocaleDateString('es-MX', { month: 'long', year: 'numeric' });
        title.textContent = monthName.charAt(0).toUpperCase() + monthName.slice(1);

        grid.innerHTML = '';

        const firstDay = new Date(currentYear, currentMonth, 1);
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        let startWeekDay = firstDay.getDay();
        startWeekDay = startWeekDay === 0 ? 7 : startWeekDay;

        for (let i = 1; i < startWeekDay; i += 1) {
            const pad = document.createElement('div');
            pad.className = 'h-10';
            grid.appendChild(pad);
        }

        for (let day = 1; day <= daysInMonth; day += 1) {
            const dateObj = new Date(currentYear, currentMonth, day);
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = String(day);
            btn.className = 'h-10 rounded border border-rule text-sm hover:bg-accent hover:text-paper transition';

            const isPast = dateObj < new Date(now.getFullYear(), now.getMonth(), now.getDate());
            if (isPast) {
                btn.disabled = true;
                btn.className = 'h-10 rounded border border-rule text-xs text-muted opacity-50 cursor-not-allowed';
            }

            if (isSameDay(dateObj, checkIn)) {
                btn.className = 'h-10 rounded bg-ink text-paper text-sm';
            }
            if (isSameDay(dateObj, checkOut)) {
                btn.className = 'h-10 rounded bg-gold text-ink text-sm';
            }

            btn.addEventListener('click', function () {
                if (!checkIn || (checkIn && checkOut)) {
                    checkIn = dateObj;
                    checkOut = null;
                } else if (dateObj >= checkIn) {
                    checkOut = dateObj;
                } else {
                    checkIn = dateObj;
                    checkOut = null;
                }
                resetLabels();
                renderCalendar();
            });

            grid.appendChild(btn);
        }
    }

    prevBtn.addEventListener('click', function () {
        currentMonth -= 1;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear -= 1;
        }
        renderCalendar();
    });

    nextBtn.addEventListener('click', function () {
        currentMonth += 1;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear += 1;
        }
        renderCalendar();
    });

    clearBtn.addEventListener('click', function () {
        checkIn = null;
        checkOut = null;
        resetLabels();
        renderCalendar();
    });

    resetLabels();
    renderCalendar();
})();
</script>
