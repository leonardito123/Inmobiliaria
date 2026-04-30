/**
 * Venta Landing - Infinite Scroll + Cursor Pagination
 */

document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    
    if (!loadMoreBtn) return;

    loadMoreBtn.addEventListener('click', async function() {
        const cursor = this.dataset.cursor;
        const filtersJson = this.dataset.filters;
        const filters = JSON.parse(filtersJson || '{}');

        try {
            this.disabled = true;
            this.textContent = 'Cargando...';

            const params = new URLSearchParams({
                cursor,
                city: filters.city || '',
                bedrooms: filters.bedrooms || '0',
                price_min: filters.price_min || '0',
                price_max: filters.price_max || '0'
            });

            const response = await fetch(`/venta/load-more?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();

            if (!data.properties || data.properties.length === 0) {
                this.textContent = 'No hay más propiedades';
                return;
            }

            // Renderizar nuevas propiedades
            const grid = document.getElementById('propertiesGrid');
            data.properties.forEach(property => {
                const card = createPropertyCard(property);
                grid.appendChild(card);
            });

            // Actualizar cursor y botón
            if (data.has_more && data.next_cursor) {
                this.dataset.cursor = data.next_cursor;
                this.disabled = false;
                this.textContent = 'Cargar Más';
            } else {
                this.textContent = 'No hay más propiedades';
                this.disabled = true;
            }

        } catch (error) {
            console.error('Error loading more properties:', error);
            this.textContent = 'Error al cargar. Intenta de nuevo.';
            this.disabled = false;
        }
    });
});

function createPropertyCard(property) {
    const card = document.createElement('div');
    card.className = 'property-card bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition transform hover:scale-105 cursor-pointer';

    const currency = property.currency || 'MXN';
    const bedrooms = property.bedrooms ? `<span class="flex items-center gap-1"><span class="font-semibold">🛏️</span>${property.bedrooms} hab.</span>` : '';
    const bathrooms = property.bathrooms ? `<span class="flex items-center gap-1"><span class="font-semibold">🚿</span>${property.bathrooms} baños</span>` : '';
    const sqm = property.sqm ? `<span class="flex items-center gap-1"><span class="font-semibold">📐</span>${Math.round(property.sqm)}m²</span>` : '';
    const featured = property.featured ? '<span class="absolute top-3 right-3 bg-gold text-white px-3 py-1 rounded-full text-xs font-bold">DESTACADO</span>' : '';

    const price = new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: currency,
        maximumFractionDigits: 0
    }).format(property.price);

    card.innerHTML = `
        <div class="w-full h-48 bg-gradient-to-br from-gold to-rust relative flex items-center justify-center">
            <span class="text-white text-2xl font-bold">${property.city.toUpperCase()}</span>
            ${featured}
        </div>
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">${escapeHtml(property.meta_title)}</h3>
            <p class="text-slate-600 text-sm mb-4">${escapeHtml(property.meta_desc.substring(0, 80))}...</p>
            <div class="flex gap-4 mb-4 text-sm">
                ${bedrooms}
                ${bathrooms}
                ${sqm}
            </div>
            <div class="border-t pt-4">
                <p class="text-3xl font-bold text-gold">${price}</p>
                <p class="text-slate-500 text-xs">${property.city} • ${currency}</p>
            </div>
            <button class="w-full mt-4 bg-accent text-white py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">
                Ver Detalles
            </button>
        </div>
    `;

    return card;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
