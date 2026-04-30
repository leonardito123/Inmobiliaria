<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-slate-900 to-slate-800 text-white py-16">
        <div class="container mx-auto px-6">
            <h1 class="text-5xl font-bold mb-4">Propiedades en Venta</h1>
            <p class="text-xl text-slate-300">Descubre nuestras mejores opciones en <?php echo htmlspecialchars($country_code); ?></p>
        </div>
    </section>

    <!-- Filtros -->
    <section class="bg-slate-50 py-8 sticky top-0 z-40">
        <div class="container mx-auto px-6">
            <form id="filterForm" class="grid grid-cols-1 md:grid-cols-5 gap-4" method="GET">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ciudad</label>
                    <input 
                        type="text" 
                        name="city" 
                        placeholder="CDMX, Medellín..." 
                        value="<?php echo htmlspecialchars($filters['city']); ?>"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-accent"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Habitaciones</label>
                    <select name="bedrooms" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-accent">
                        <option value="0">Cualquiera</option>
                        <option value="1" <?php echo $filters['bedrooms'] == 1 ? 'selected' : ''; ?>>1+</option>
                        <option value="2" <?php echo $filters['bedrooms'] == 2 ? 'selected' : ''; ?>>2+</option>
                        <option value="3" <?php echo $filters['bedrooms'] == 3 ? 'selected' : ''; ?>>3+</option>
                        <option value="4" <?php echo $filters['bedrooms'] == 4 ? 'selected' : ''; ?>>4+</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Precio Mín</label>
                    <input 
                        type="number" 
                        name="price_min" 
                        placeholder="0"
                        value="<?php echo $filters['price_min']; ?>"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-accent"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Precio Máx</label>
                    <input 
                        type="number" 
                        name="price_max" 
                        placeholder="10000000"
                        value="<?php echo $filters['price_max']; ?>"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-accent"
                    >
                </div>

                <div class="flex items-end">
                    <button 
                        type="submit" 
                        class="w-full bg-accent text-white px-6 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition"
                    >
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Propiedades Grid -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <div id="propertiesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($properties as $property): ?>
                    <div class="property-card bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition transform hover:scale-105 cursor-pointer">
                        <!-- Image Placeholder -->
                        <div class="w-full h-48 bg-gradient-to-br from-gold to-rust relative flex items-center justify-center">
                            <span class="text-white text-2xl font-bold"><?php echo strtoupper($property['city']); ?></span>
                            <?php if ($property['featured']): ?>
                                <span class="absolute top-3 right-3 bg-gold text-white px-3 py-1 rounded-full text-xs font-bold">DESTACADO</span>
                            <?php endif; ?>
                        </div>

                        <!-- Info -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">
                                <?php echo htmlspecialchars($property['meta_title']); ?>
                            </h3>
                            
                            <p class="text-slate-600 text-sm mb-4">
                                <?php echo htmlspecialchars(substr($property['meta_desc'], 0, 80)); ?>...
                            </p>

                            <!-- Stats -->
                            <div class="flex gap-4 mb-4 text-sm">
                                <?php if ($property['bedrooms']): ?>
                                    <span class="flex items-center gap-1">
                                        <span class="font-semibold">🛏️</span>
                                        <?php echo $property['bedrooms']; ?> hab.
                                    </span>
                                <?php endif; ?>
                                <?php if ($property['bathrooms']): ?>
                                    <span class="flex items-center gap-1">
                                        <span class="font-semibold">🚿</span>
                                        <?php echo $property['bathrooms']; ?> baños
                                    </span>
                                <?php endif; ?>
                                <?php if ($property['sqm']): ?>
                                    <span class="flex items-center gap-1">
                                        <span class="font-semibold">📐</span>
                                        <?php echo number_format($property['sqm']); ?>m²
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Precio -->
                            <div class="border-t pt-4">
                                <p class="text-3xl font-bold text-gold">
                                    <?php 
                                    if ($currency === 'MXN') {
                                        echo '$' . number_format($property['price']);
                                    } elseif ($currency === 'COP') {
                                        echo '$' . number_format($property['price']);
                                    } else {
                                        echo '$' . number_format($property['price']);
                                    }
                                    ?>
                                </p>
                                <p class="text-slate-500 text-xs">
                                    <?php echo htmlspecialchars($property['city']); ?> • <?php echo $currency; ?>
                                </p>
                            </div>

                            <!-- CTA -->
                            <button class="w-full mt-4 bg-accent text-white py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Load More Button -->
            <?php if ($pagination['has_more']): ?>
                <div class="flex justify-center mt-12">
                    <button 
                        id="loadMoreBtn"
                        data-cursor="<?php echo htmlspecialchars($pagination['next_cursor']); ?>"
                        data-filters="<?php echo htmlspecialchars(json_encode($filters)); ?>"
                        class="px-8 py-3 bg-accent text-white rounded-lg font-semibold hover:bg-opacity-90 transition"
                    >
                        Cargar Más
                    </button>
                </div>
            <?php endif; ?>

            <!-- Empty State -->
            <?php if (empty($properties)): ?>
                <div class="text-center py-16">
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">No hay propiedades disponibles</h3>
                    <p class="text-slate-600 mb-8">Intenta ajustar tus filtros de búsqueda</p>
                    <button onclick="document.getElementById('filterForm').reset(); window.location.reload();" class="bg-accent text-white px-8 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition">
                        Limpiar Filtros
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (!loadMoreBtn) {
        return;
    }

    loadMoreBtn.addEventListener('click', async function() {
        const cursor = this.dataset.cursor;
        const filters = JSON.parse(this.dataset.filters || '{}');

        try {
            this.disabled = true;
            this.textContent = 'Cargando...';

            const params = new URLSearchParams({
                cursor: cursor || '',
                city: filters.city || '',
                bedrooms: String(filters.bedrooms || 0),
                price_min: String(filters.price_min || 0),
                price_max: String(filters.price_max || 0)
            });

            const response = await fetch('/venta/load-more?' + params.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Error al cargar propiedades');
            }

            const data = await response.json();
            if (!Array.isArray(data.properties) || data.properties.length === 0) {
                this.textContent = 'No hay mas propiedades';
                this.disabled = true;
                return;
            }

            const grid = document.getElementById('propertiesGrid');
            data.properties.forEach(function(property) {
                const card = document.createElement('div');
                card.className = 'property-card bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition transform hover:scale-105 cursor-pointer';
                card.innerHTML =
                    '<div class="w-full h-48 bg-gradient-to-br from-gold to-rust relative flex items-center justify-center">' +
                    '<span class="text-white text-2xl font-bold">' + String(property.city || '').toUpperCase() + '</span>' +
                    (property.featured ? '<span class="absolute top-3 right-3 bg-gold text-white px-3 py-1 rounded-full text-xs font-bold">DESTACADO</span>' : '') +
                    '</div>' +
                    '<div class="p-6">' +
                    '<h3 class="text-lg font-bold text-slate-900 mb-2">' + escapeHtml(property.meta_title || 'Propiedad') + '</h3>' +
                    '<p class="text-slate-600 text-sm mb-4">' + escapeHtml(String(property.meta_desc || '').substring(0, 80)) + '...</p>' +
                    '<div class="border-t pt-4">' +
                    '<p class="text-3xl font-bold text-gold">$' + Number(property.price || 0).toLocaleString('es-MX', { maximumFractionDigits: 0 }) + '</p>' +
                    '<p class="text-slate-500 text-xs">' + escapeHtml(property.city || '') + ' • ' + escapeHtml(property.currency || 'MXN') + '</p>' +
                    '</div>' +
                    '<button class="w-full mt-4 bg-accent text-white py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">Ver Detalles</button>' +
                    '</div>';

                grid.appendChild(card);
            });

            if (data.has_more && data.next_cursor) {
                this.dataset.cursor = data.next_cursor;
                this.disabled = false;
                this.textContent = 'Cargar Mas';

                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('cursor', data.next_cursor);
                window.history.pushState({ cursor: data.next_cursor }, '', currentUrl.toString());
            } else {
                this.textContent = 'No hay mas propiedades';
                this.disabled = true;

                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.delete('cursor');
                window.history.pushState({ cursor: null }, '', currentUrl.toString());
            }
        } catch (error) {
            this.textContent = 'Error al cargar';
            this.disabled = false;
        }
    });

    window.addEventListener('popstate', function () {
        window.location.reload();
    });
});

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
