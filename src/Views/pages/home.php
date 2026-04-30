<?php
/**
 * Home Landing Page
 * 
 * Variables disponibles:
 * - $country: Código del país (MX, CO, CL)
 * - $currency: Moneda (MXN, COP, CLP)
 * - $phone: Teléfono de contacto
 * - $featured_properties: Array de propiedades destacadas
 */
?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-ink to-ink/80 text-paper py-24 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <p class="text-gold font-mono text-sm tracking-widest uppercase mb-4">
                🏗️ Plataforma Inmobiliaria Premium
            </p>
            <h1 class="text-5xl md:text-6xl font-serif font-black mb-6 leading-tight">
                Propiedades de Lujo en <span class="text-gold"><?php echo $country === 'MX' ? 'México' : ($country === 'CO' ? 'Colombia' : 'Chile'); ?></span>
            </h1>
            <p class="text-lg text-paper/80 mb-8 max-w-2xl leading-relaxed">
                Descubre una selección exclusiva de inmuebles premium. Venta, renta y desarrollos de clase mundial con GEO targeting, SEO avanzado y experiencia de usuario sin compromisos.
            </p>
            <div class="flex gap-4">
                <a href="/venta" class="px-8 py-4 bg-gold text-ink font-bold rounded hover:bg-gold/90 transition">
                    Ver Propiedades
                </a>
                <a href="/contacto" class="px-8 py-4 border-2 border-paper text-paper font-bold rounded hover:bg-paper hover:text-ink transition">
                    Contactar
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Properties -->
<section class="py-20 bg-paper">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <p class="text-gold font-mono text-sm tracking-widest uppercase mb-2">
                ✨ Destacadas
            </p>
            <h2 class="text-4xl font-serif font-bold">Propiedades Premium en <?php echo $country; ?></h2>
        </div>

        <?php if (!empty($featured_properties)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($featured_properties as $prop): ?>
            <?php
                $slug = (string) ($prop['slug'] ?? '');
                $localImageFile = $slug === 'depto-ñuñoa-cl' ? 'depto-nunoa-cl.svg' : ($slug !== '' ? $slug . '.svg' : 'default-property.svg');
                $imageUrl = '/images/properties/' . $localImageFile;
            ?>
            <div class="bg-white border border-rule rounded-lg overflow-hidden hover:shadow-xl transition">
                <div class="aspect-square bg-gradient-to-br from-muted to-rule relative overflow-hidden">
                    <img
                        src="<?php echo htmlspecialchars($imageUrl); ?>"
                        alt="<?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad destacada'); ?>"
                        class="w-full h-full object-cover"
                        loading="lazy"
                        referrerpolicy="no-referrer"
                        onerror="this.onerror=null; this.src='/images/property-fallback.svg';"
                    >
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-serif font-bold mb-2"><?php echo htmlspecialchars($prop['meta_title'] ?? 'Propiedad'); ?></h3>
                    <p class="text-muted text-sm mb-4"><?php echo htmlspecialchars($prop['city'] ?? 'Ubicación'); ?></p>
                    
                    <div class="flex gap-4 mb-4 text-sm">
                        <?php if ($prop['bedrooms']): ?>
                        <span class="flex items-center gap-1">
                            <span class="font-bold"><?php echo $prop['bedrooms']; ?></span> Recámaras
                        </span>
                        <?php endif; ?>
                        <?php if ($prop['bathrooms']): ?>
                        <span class="flex items-center gap-1">
                            <span class="font-bold"><?php echo $prop['bathrooms']; ?></span> Baños
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="border-t border-rule pt-4">
                        <p class="text-2xl font-serif font-bold text-gold">
                            <?php echo number_format($prop['price'] ?? 0, 0, ',', '.'); ?> <?php echo $prop['currency'] ?? $currency; ?>
                        </p>
                    </div>

                    <a href="#" class="block mt-6 text-center py-3 bg-ink text-paper font-bold rounded hover:bg-accent transition">
                        Ver Detalles
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="bg-white border-2 border-dashed border-rule rounded-lg p-12 text-center">
            <p class="text-muted text-lg">No hay propiedades destacadas en este momento.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-ink text-paper">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-3 gap-8">
            <div class="text-center">
                <p class="text-5xl font-serif font-bold text-gold mb-2">450+</p>
                <p class="text-paper/80">Propiedades Listadas</p>
            </div>
            <div class="text-center">
                <p class="text-5xl font-serif font-bold text-gold mb-2">12K+</p>
                <p class="text-paper/80">Clientes Satisfechos</p>
            </div>
            <div class="text-center">
                <p class="text-5xl font-serif font-bold text-gold mb-2">15 años</p>
                <p class="text-paper/80">En el Mercado</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-paper">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-serif font-bold mb-6">¿Listo para encontrar tu propiedad ideal?</h2>
        <p class="text-lg text-muted mb-8">Contáctanos hoy y déjanos ayudarte a encontrar la inversión inmobiliaria perfecta.</p>
        <a href="/contacto" class="inline-block px-12 py-4 bg-gold text-ink font-bold rounded-lg hover:bg-gold/90 transition">
            Iniciar Consulta Gratis
        </a>
    </div>
</section>

<!-- Newsletter -->
<section class="py-16 bg-white border-t border-rule">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-8">
            <p class="text-gold font-mono text-xs tracking-widest uppercase mb-2">Newsletter</p>
            <h2 class="text-3xl font-serif font-bold mb-3">Recibe Nuevas Propiedades Premium</h2>
            <p class="text-muted">Actualizaciones semanales por país, tipo de propiedad y rangos de precio.</p>
        </div>

        <?php if (($newsletter_status ?? '') === 'ok'): ?>
            <div class="mb-4 p-3 border border-green-300 bg-green-50 text-green-800 rounded-lg text-sm">Suscripción completada con éxito.</div>
        <?php elseif (($newsletter_status ?? '') === 'invalid_email'): ?>
            <div class="mb-4 p-3 border border-red-300 bg-red-50 text-red-700 rounded-lg text-sm">Correo inválido. Intenta de nuevo.</div>
        <?php elseif (($newsletter_status ?? '') === 'rate_limited'): ?>
            <div class="mb-4 p-3 border border-amber-300 bg-amber-50 text-amber-800 rounded-lg text-sm">Demasiados intentos. Espera antes de reintentar.</div>
        <?php elseif (($newsletter_status ?? '') === 'csrf_error'): ?>
            <div class="mb-4 p-3 border border-red-300 bg-red-50 text-red-700 rounded-lg text-sm">Sesión inválida. Recarga la página.</div>
        <?php elseif (($newsletter_status ?? '') === 'server_error'): ?>
            <div class="mb-4 p-3 border border-red-300 bg-red-50 text-red-700 rounded-lg text-sm">No se pudo registrar la suscripción en este momento.</div>
        <?php endif; ?>

        <form action="/newsletter/subscribe" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 bg-paper border border-rule rounded-xl p-4">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($newsletter_csrf_token ?? ''); ?>">

            <input type="text" name="name" placeholder="Nombre (opcional)" class="px-4 py-3 border border-rule rounded-lg md:col-span-1">
            <input type="email" name="email" required placeholder="tu@email.com" class="px-4 py-3 border border-rule rounded-lg md:col-span-1">
            <button type="submit" class="px-4 py-3 bg-ink text-paper rounded-lg font-semibold hover:bg-accent transition md:col-span-1">Suscribirme</button>

            <div class="hidden" aria-hidden="true">
                <label for="website">No llenar</label>
                <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
            </div>
        </form>
    </div>
</section>
