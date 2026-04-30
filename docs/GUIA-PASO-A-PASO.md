# HAVRE ESTATES — Guía de construcción paso a paso

> Desde instalación de herramientas hasta entrega final.  
> Sigue cada sección en orden. Marca cada ítem al completarlo.

---

## RETO COMPLETO — Referencia maestra

### ¿Qué es este proyecto?

Construir una plataforma inmobiliaria premium **HAVRE ESTATES** desde cero, sin frameworks de frontend ni de backend, desplegada en **producción real** en `https://distribuidoroficial.mx/`. Demostrar dominio técnico completo en 5 landings funcionales con datos reales o ficticios bien producidos.

### Entregables requeridos

| # | Entregable | Mínimo |
| --- | --- | --- |
| 1 | Repo GitHub **público** con URL | Obligatorio |
| 2 | Commits Conventional Commits | ≥40 commits |
| 3 | PRs documentados y mergeados | ≥5 PRs |
| 4 | README.md — instalación en ≤5 comandos | Obligatorio |
| 5 | 5 landings funcionales en servidor real | Obligatorio |
| 6 | `/sitemap.xml` dinámico accesible | Obligatorio |
| 7 | 5 reportes PDF Lighthouse | Performance/SEO/A11y ≥95 |
| 8 | Evidencia GEO detection (screenshot o video) | Obligatorio |
| 9 | Schema markup validado en schema.org | Obligatorio |
| 10 | PHPUnit pasando | ≥15 tests |
| 11 | `docs/ARCHITECTURE.md` completo | Obligatorio |
| 12 | Demo en vivo | ≥7 días post-entrega |

---

## REGLAS DEL JUEGO

### ✅ Permitido

- Documentación oficial (MDN, PHP.net, Tailwind, Alpine.js, Leaflet)
- Stack Overflow para resolver bugs
- Imágenes: [picsum.photos](https://picsum.photos), [unsplash.com](https://unsplash.com)
- Iconos SVG: Heroicons, Lucide (copiados como SVG inline, **sin instalar paquete npm**)
- Datos ficticios pero bien producidos en seeds SQL
- MaxMind GeoLite2 (gratuito con registro)
- Fontsource (npm install `@fontsource/...`)

### ❌ No permitido

| Prohibido | Alternativa |
| --- | --- |
| IA para generar código (Copilot, ChatGPT) | Escribir manualmente |
| React, Vue, Angular, Svelte | Alpine.js + JS vanilla |
| UI kits / component libraries | Tailwind + CSS custom |
| Google Maps (API de pago) | Leaflet.js (gratuito) |
| Bootstrap, Bulma, Foundation | Tailwind v4 |
| CMS (WordPress, Drupal) | PHP MVC artesanal |
| Librerías de carrusel (Swiper, Slick) | JS vanilla + CSS |
| Librerías de animación (GSAP, AOS) | CSS `@keyframes` + IntersectionObserver |

---

## 8 RETOS TÉCNICOS OBLIGATORIOS

### RETO 1 — Performance (Core Web Vitals)

**Objetivo**: Lighthouse Performance ≥95 en las 5 landings.

Checklist:

- [ ] **LCP < 1.8s** en conexión 3G simulada (WebPageTest desde CDMX)
- [ ] **CLS = 0** — sin layout shifts: dimensiones explícitas en imágenes, sin fuentes que causen FOUT
- [ ] **INP < 100ms** — sin event handlers bloqueantes; usar `requestIdleCallback` para trabajo no urgente
- [ ] Critical CSS inline en `<head>` (estilos del hero above-the-fold)
- [ ] Imágenes hero en formato **WebP + AVIF** con `<picture>` + fallback JPEG
- [ ] `loading="lazy"` en todas las imágenes fuera del viewport inicial
- [ ] `fetchpriority="high"` en la imagen LCP de cada landing
- [ ] `defer` en todos los `<script>` no críticos
- [ ] Compilar con Vite: tree-shaking, minificación y code-splitting por página
- [ ] Cabecera `Cache-Control: max-age=31536000, immutable` para assets estáticos

### RETO 2 — GEO Targeting

**Objetivo**: Detección automática de país y personalización de contenido.

Checklist:

- [ ] Integrar **MaxMind GeoLite2** (`geoip2/geoip2` vía Composer) — mmdb en `storage/geo/`
- [ ] `GeoMiddleware` detecta país desde IP del visitor
- [ ] **Soft redirect** vía JS state (`history.pushState`) — no recarga de página
- [ ] Precios en moneda local: **MXN** (México), **COP** (Colombia), **CLP** (Chile)
- [ ] Número de teléfono por país: +52 MX / +57 CO / +56 CL
- [ ] **hreflang** correctos en `<head>`: `es-MX`, `es-CO`, `es-CL`, `x-default`
- [ ] Mapa Leaflet centrado en país detectado (coordenadas distintas por country code)
- [ ] Badge dinámico en hero: "Propiedades en [Ciudad detectada]"
- [ ] API endpoint: `GET /api/properties/{country}` devuelve JSON filtrado

### RETO 3 — SEO Avanzado

**Objetivo**: Lighthouse SEO ≥95 y todos los schemas válidos en schema.org.

Checklist:

- [ ] `<title>` único por landing (50–60 caracteres)
- [ ] `<meta name="description">` único por landing (120–160 caracteres), generado por PHP
- [ ] Canonical tags: `<link rel="canonical">` ignorando parámetros de filtros
- [ ] Open Graph completo: `og:title`, `og:description`, `og:image` (1200×630), `og:url`, `og:type`
- [ ] Twitter Cards: `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`
- [ ] **Schemas JSON-LD** por página:
  - Home: `Organization`, `WebSite` con SearchAction
  - Venta/Renta: `RealEstateListing` por propiedad, `BreadcrumbList`
  - Desarrollos: `RealEstateAgent`, `ItemList`
  - Contacto: `Person` (agentes), `LocalBusiness` (3 oficinas)
  - Todas: `FAQPage`, `Review`/`AggregateRating`
- [ ] `/sitemap.xml` dinámico generado por PHP con todas las propiedades
- [ ] `/robots.txt` dinámico con referencia al sitemap
- [ ] Validar cada schema en [validator.schema.org](https://validator.schema.org)

### RETO 4 — Seguridad

**Objetivo**: Headers A+, cero vulnerabilidades en OWASP Top 10.

Checklist:

- [ ] Headers HTTP en `.htaccess` / `Response.php`:
  - `Content-Security-Policy` (CSP) sin `unsafe-inline` ni `unsafe-eval`
  - `Strict-Transport-Security: max-age=31536000; includeSubDomains`
  - `X-Frame-Options: DENY`
  - `X-Content-Type-Options: nosniff`
  - `Referrer-Policy: strict-origin-when-cross-origin`
  - `Permissions-Policy: geolocation=(), microphone=(), camera=()`
- [ ] **CSRF rotativo**: token nuevo en cada sesión, validado en todo POST
- [ ] **Rate limiting file-based**: `RateLimitService` sin Redis — bloquea tras N intentos
- [ ] **PDO exclusivo**: cero raw queries con concatenación de strings
- [ ] **MIME validation** en uploads: `finfo_file()` valida tipo real, no solo extensión
- [ ] `htmlspecialchars()` en todo output de variables en Views
- [ ] `session_regenerate_id(true)` al iniciar sesión / cambio de privilegio
- [ ] `.env` en `.gitignore`, nunca commiteado
- [ ] Verificar headers en [securityheaders.com](https://securityheaders.com)

### RETO 5 — Accesibilidad WCAG 2.2 AA

**Objetivo**: Lighthouse Accessibility ≥95, navegación 100% por teclado.

Checklist:

- [ ] Navegar todo el sitio con **Tab / Shift+Tab / Enter / Space** sin ratón
- [ ] Focus visible en todos los elementos interactivos (`outline: 2px solid`)
- [ ] `aria-label` en botones que solo contienen iconos SVG
- [ ] `aria-live="polite"` en zonas que actualizan contenido dinámicamente
- [ ] `role="dialog"`, `aria-modal="true"`, `aria-labelledby` en todos los modales
- [ ] Contraste de texto **≥ 4.5:1** para texto normal, **≥ 3:1** para texto grande
- [ ] Atributo `alt` descriptivo en **todas** las imágenes (vacío `alt=""` en decorativas)
- [ ] `lang="es"` en `<html>`, `lang` específico en secciones en otro idioma
- [ ] Skip-to-content link: `<a href="#main-content" class="sr-only focus:not-sr-only">Ir al contenido</a>`
- [ ] `<h1>` único por página, jerarquía de headings correcta (h1 → h2 → h3)
- [ ] Formularios: `<label for="id">` o `aria-label` en cada input
- [ ] Auditar con Lighthouse → Accessibility ≥95

### RETO 6 — Tipografía con Fontsource

**Objetivo**: Tipografía premium desde npm, sin Google Fonts, con escala modular.

Checklist:

- [ ] **Mínimo 2 familias** instaladas vía `@fontsource/...` (no CDN, no Google Fonts)
  - `@fontsource/playfair-display` — headings editoriales
  - `@fontsource/ibm-plex-sans` — body text
  - `@fontsource/ibm-plex-mono` — precios, datos técnicos
- [ ] `font-display: swap` en **todas** las declaraciones `@font-face`
- [ ] Preload del subset crítico (latin, 400 woff2) en `<head>`:

  ```html
  <link rel="preload" as="font" type="font/woff2" crossorigin
        href="/assets/playfair-display-latin-400.woff2">
  ```

- [ ] **Variable fonts** cuando estén disponibles (Playfair Display es variable)
- [ ] **Escala tipográfica modular** con ratio **1.25** (Major Third):

  ```css
  --text-xs:   0.64rem;   /* 1rem ÷ 1.25² */
  --text-sm:   0.8rem;    /* 1rem ÷ 1.25 */
  --text-base: 1rem;
  --text-md:   1.25rem;   /* 1rem × 1.25 */
  --text-lg:   1.563rem;  /* 1rem × 1.25² */
  --text-xl:   1.953rem;  /* 1rem × 1.25³ */
  --text-2xl:  2.441rem;  /* 1rem × 1.25⁴ */
  --text-3xl:  3.052rem;  /* 1rem × 1.25⁵ */
  ```

- [ ] Cero requests a `fonts.googleapis.com` ni `fonts.gstatic.com`

### RETO 7 — Arquitectura PHP MVC Artesanal

**Objetivo**: MVC limpio, sin framework, PSR-4, con caché HTML.

Checklist:

- [ ] **Router con regex y named params**: `/propiedad/{slug:[a-z0-9-]+}` → `$params['slug']`
- [ ] **Middleware stack** apilable: `GeoMiddleware → CacheMiddleware → RateLimitMiddleware → Controller`
- [ ] **Template engine PHP nativo**: `require` de vistas PHP con `extract($data)` para inyectar variables
- [ ] **PSR-4** con Composer: namespace `App\` → directorio `src/`
- [ ] **.env parsing** sin dependencia: `Env::get('DB_HOST')` lee `/.env`
- [ ] **Caché HTML con TTL**: `CacheService::set($key, $html, $ttl)` en `storage/cache/`
- [ ] `CacheMiddleware` sirve página cacheada si existe y no expiró (evita render PHP)
- [ ] Cero SQL fuera de los modelos (`src/Models/`)
- [ ] Cero HTML en los controladores (solo lógica y render de vista)

### RETO 8 — Mobile First

**Objetivo**: Experiencia perfecta en móvil, 44px touch areas, PWA.

Checklist:

- [ ] CSS escrito **mobile first**: estilos base para móvil, `@media (min-width: ...)` para desktop
- [ ] Breakpoints Tailwind usados: `sm:` `md:` `lg:` `xl:` `2xl:`
- [ ] Áreas táctiles **mínimo 44×44px** en todos los botones e ítems clicables
- [ ] **Swipe gestures** en carruseles implementado con JS vanilla (`touchstart` / `touchend`)
- [ ] **Safe area insets** en iOS: `padding: env(safe-area-inset-top) env(safe-area-inset-right) ...`
- [ ] **PWA manifest** (`/manifest.webmanifest`): `display: standalone`, iconos 192 y 512
- [ ] **Service Worker** (`/sw.js`): cache-first para assets, network-first para HTML
- [ ] **Offline fallback**: `/offline.html` servido cuando no hay red
- [ ] `<meta name="viewport" content="width=device-width, initial-scale=1">` en todas las páginas
- [ ] Verificar en Chrome DevTools → Device Toolbar → Moto G4 (360px)

---

## 8 PUNTOS BONUS (opcionales)

| # | Bonus | Descripción |
| --- | --- | --- |
| 1 | HTTP/2 Server Push | Precargar CSS/JS crítico en la primera respuesta HTTP |
| 2 | Brotli compression | Habilitar Brotli en cPanel además de gzip (`.htaccess`) |
| 3 | Meta descriptions únicas PHP | Generar con NLP/templates en PHP, sin hardcodear |
| 4 | Analytics con Canvas API | Dashboard visual de leads/visitas dibujado con `<canvas>` |
| 5 | Web Push Notifications | API de notificaciones del navegador (VAPID keys) |
| 6 | KML / GeoJSON | Exportar propiedades en formato geográfico desde `/api/properties.kml` |
| 7 | OG Image dinámico con GD | Generar imagen Open Graph personalizada con `imagecreatetruecolor()` |
| 8 | Infinite scroll con IntersectionObserver | Cargar siguiente página automáticamente al llegar al 80% del scroll |

---

## MÉTRICAS KPI DE EVALUACIÓN

### Web Vitals obligatorios (medidos en conexión 3G desde CDMX)

| Métrica | Umbral | Herramienta |
| --- | --- | --- |
| LCP (Largest Contentful Paint) | **< 1.8s** | Lighthouse / WebPageTest |
| CLS (Cumulative Layout Shift) | **= 0** | Lighthouse |
| INP (Interaction to Next Paint) | **< 100ms** | Chrome DevTools (Lab data) |
| FID / TBT (Total Blocking Time) | **< 200ms** | Lighthouse |

### Lighthouse scores (mínimos requeridos)

| Categoría | Score mínimo |
| --- | --- |
| Performance | **≥ 95** |
| Accessibility | **≥ 95** |
| Best Practices | **≥ 95** |
| SEO | **≥ 95** |

### Otros indicadores

- [ ] **0 errores JavaScript** en consola del navegador (ninguna landing)
- [ ] **0 warnings** de accesibilidad en Lighthouse
- [ ] **HTML válido** según [validator.w3.org](https://validator.w3.org)
- [ ] **Schemas sin errores** en [validator.schema.org](https://validator.schema.org)
- [ ] Evaluación con **WebPageTest** desde: CDMX (MX), Bogotá (CO), Santiago (CL)
- [ ] **Lighthouse CI** en GitHub Actions (`/.github/workflows/ci.yml`)

---

## FLUJO DE BRANCHES (obligatorio)

```text
main ←─── develop ←─── feature/landing-home
                  ←─── feature/landing-venta
                  ←─── feature/landing-renta
                  ←─── feature/landing-desarrollos
                  ←─── feature/landing-contacto
                  ←─── feat/services-core
                  ←─── fix/...
```

**Reglas**:

1. **Nunca** push directo a `main` ni `develop` — siempre vía PR
2. Features van a `develop`, **no a `main`**
3. Solo cuando `develop` esté completo y verificado, se abre PR `develop → main` para el deploy final
4. Títulos de PR y commits siguen **Conventional Commits**: `feat(scope): descripción`

---

## FASE 0 — Instalación de herramientas

### 0.1 Instalar PHP 8.3

- [ ] Descargar XAMPP 8.3+ desde <https://www.apachefriends.org>
- [ ] Instalar en `C:\xampp` (Windows) o `/opt/lampp` (Linux/Mac)
- [ ] Verificar: `php -v` → debe mostrar `PHP 8.3.x`
- [ ] Activar extensiones en `php.ini`:
  - `extension=pdo_mysql`
  - `extension=mbstring`
  - `extension=openssl`
  - `extension=fileinfo`
  - `extension=intl`

### 0.2 Instalar Composer

- [ ] Descargar instalador desde <https://getcomposer.org/download/>
- [ ] Verificar: `composer --version` → debe mostrar `Composer 2.x`

### 0.3 Instalar Node.js 18+

- [ ] Descargar LTS desde <https://nodejs.org>
- [ ] Verificar: `node -v` y `npm -v`
- [ ] En Windows PowerShell si npm falla: usar `npm.cmd` en lugar de `npm`

### 0.4 Instalar Git

- [ ] Descargar desde <https://git-scm.com>
- [ ] Verificar: `git --version`
- [ ] Configurar identidad:

  ```bash
  git config --global user.name "Tu Nombre"
  git config --global user.email "tu@email.com"
  ```

### 0.5 Instalar GitHub CLI (gh)

- [ ] Descargar desde <https://cli.github.com>
- [ ] Verificar: `gh --version`
- [ ] Autenticarse: `gh auth login` → seleccionar GitHub.com → HTTPS → browser

### 0.6 Editor de código

- [ ] Instalar VS Code desde <https://code.visualstudio.com>
- [ ] Instalar extensiones recomendadas:
  - PHP Intelephense
  - Tailwind CSS IntelliSense
  - Alpine.js IntelliSense
  - GitLens
  - EditorConfig for VS Code

### 0.7 MySQL

- [ ] Ya incluido en XAMPP → iniciar servicio MySQL desde panel XAMPP
- [ ] Verificar acceso: `mysql -u root` (o con phpMyAdmin en `http://localhost/phpmyadmin`)

---

## FASE 1 — Repositorio y estructura base (Día 1–2)

### 1.1 Crear repositorio en GitHub

- [ ] Ir a <https://github.com/new>
- [ ] Nombre: `havre-estates` (o `Inmobiliaria`)
- [ ] Visibilidad: **Public** (obligatorio)
- [ ] Inicializar con README
- [ ] Clonar localmente:

  ```bash
  git clone https://github.com/TU-USUARIO/havre-estates.git
  cd havre-estates
  ```

### 1.2 Crear rama `develop`

- [ ] `git checkout -b develop`
- [ ] `git push origin develop`
- [ ] En GitHub → Settings → Branches → añadir branch protection rules para `main` y `develop`

### 1.3 Inicializar Composer (PHP)

- [ ] Crear `composer.json`:

  ```bash
  composer init
  ```

  - Package name: `havre/estates`
  - Description: plataforma inmobiliaria
  - PHP version: `^8.3`
- [ ] Agregar dependencias:

  ```bash
  composer require geoip2/geoip2 symfony/dotenv
  composer require --dev phpunit/phpunit:^11
  ```

- [ ] Configurar autoload PSR-4 en `composer.json`:

  ```json
  "autoload": {
    "psr-4": { "App\\": "src/" }
  }
  ```

- [ ] `composer dump-autoload`

### 1.4 Inicializar npm y Vite

- [ ] `npm init -y`
- [ ] Instalar dependencias:

  ```bash
  npm install alpinejs leaflet tailwindcss
  npm install @fontsource/playfair-display @fontsource/ibm-plex-sans @fontsource/ibm-plex-mono
  npm install --save-dev vite @tailwindcss/vite
  ```

- [ ] Verificar versiones en `package.json`:
  - `vite: ^6.x`
  - `tailwindcss: ^4.x`
  - `alpinejs: ^3.13.x`
  - `leaflet: ^1.9.x`

### 1.5 Crear estructura de directorios

```bash
mkdir -p public/assets
mkdir -p src/Core src/Controllers src/Models src/Services src/Views/layouts src/Views/pages
mkdir -p resources/js/pages resources/css resources/fonts
mkdir -p database/migrations database/seeds
mkdir -p storage/cache storage/geo storage/chat
mkdir -p tests/Unit tests/Feature
mkdir -p routes docs .github/workflows
```

### 1.6 Crear `vite.config.js`

- [ ] Configurar `root: 'resources'`, `base: '/assets/'`
- [ ] Code-splitting: un entry point por landing (`home`, `venta`, `renta`, `desarrollos`, `contacto`)
- [ ] Plugin: `@tailwindcss/vite`
- [ ] Output: `outDir: '../public/assets'`, `manifest: true`

### 1.6b Crear `tailwind.config.js`

> Aunque Tailwind v4 no requiere config obligatorio, crearlo permite definir la paleta y extender el tema.

```js
// tailwind.config.js
export default {
  content: ['./resources/**/*.{js,css}', './src/Views/**/*.php'],
  theme: {
    extend: {
      colors: {
        gold:  '#C9A96E',
        ink:   '#1A1A2E',
        paper: '#F5F0E8',
      },
      fontFamily: {
        display: ['"Playfair Display"', 'Georgia', 'serif'],
        sans:    ['"IBM Plex Sans"', 'system-ui', 'sans-serif'],
        mono:    ['"IBM Plex Mono"', 'Menlo', 'monospace'],
      },
    },
  },
}
```

### 1.7 Crear `.env` y `.env.example`

- [ ] Variables mínimas:

  ```dotenv
  APP_URL=http://localhost:8000
  APP_ENV=local
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_NAME=havre_estates
  DB_USER=root
  DB_PASS=
  RECAPTCHA_SITE_KEY=
  RECAPTCHA_SECRET_KEY=
  MAIL_FROM=noreply@havre-estates.com
  ```

- [ ] Añadir `.env` a `.gitignore` (nunca commitear credenciales)

### 1.8 Primer commit

- [ ] `git add .`
- [ ] `git commit -m "chore: initial project structure with Vite, Tailwind and Composer"`
- [ ] `git push origin develop`

---

## FASE 2 — Core MVC (Día 2–3)

### 2.1 `src/Core/Env.php`

- [ ] Parsea `.env` sin librerías externas
- [ ] Método estático `get(string $key, $default = null)`

### 2.2 `src/Core/DB.php`

- [ ] Singleton PDO
- [ ] Charset `utf8mb4`
- [ ] `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`
- [ ] Método estático `getInstance(): PDO`

### 2.3 `src/Core/Request.php`

- [ ] Acceso a `$_GET`, `$_POST`, `$_SERVER`, `$_FILES`
- [ ] Métodos: `getMethod()`, `getPath()`, `getParam()`, `getBody()`, `isPost()`, `isAjax()`
- [ ] Sanitización de input en la entrada

### 2.4 `src/Core/Response.php`

- [ ] Métodos: `setHeader()`, `setStatus()`, `json(array $data)`, `redirect(string $url)`
- [ ] `send()` para emitir la respuesta HTTP

### 2.5 `src/Core/Router.php`

- [ ] Soporte `GET` y `POST`
- [ ] Named params con regex: `/propiedad/{slug}`
- [ ] Método `dispatch(Request $request): Response`
- [ ] 404 handler por defecto

### 2.6 `src/Core/Middleware.php`

- [ ] Interfaz base con método `handle(Request $request, callable $next)`
- [ ] Middlewares concretos:
  - `GeoMiddleware` — detecta país y lo inyecta en request
  - `CacheMiddleware` — sirve HTML cacheado si existe y no expiró
  - `RateLimitMiddleware` — corta requests excesivos por IP

### 2.7 `public/index.php`

- [ ] Entry point único: carga autoloader, parsea `.env`, instancia Router
- [ ] Aplica middleware stack antes de despachar
- [ ] Maneja excepciones globales → 500 amigable

### 2.8 `public/.htaccess`

- [ ] Redirige todo a `index.php` (mod_rewrite)
- [ ] Headers de seguridad: `Content-Security-Policy`, `HSTS`, `X-Frame-Options`, `X-Content-Type-Options`
- [ ] Compresión deflate/gzip para CSS, JS, HTML
- [ ] Caché de assets estáticos (1 año para `/assets/`)

### 2.9 `routes/web.php`

- [ ] Registrar rutas: `/`, `/venta`, `/renta`, `/desarrollos`, `/contacto`
- [ ] Rutas AJAX: `/venta/load-more`, `/api/properties/{country}`
- [ ] Rutas SEO: `/sitemap.xml`, `/robots.txt`
- [ ] Rutas chat: `POST /contacto/send`, `GET /contacto/stream`

### 2.10 Commit

- [ ] `git commit -m "feat(core): add Router, Request, Response, DB singleton and Middleware stack"`

---

## FASE 3 — Servicios Core (Día 3–4)

### 3.1 `src/Services/GeoService.php`

- [ ] Descargar MaxMind GeoLite2-Country.mmdb (gratuito con registro en <https://www.maxmind.com>)
- [ ] Guardar en `storage/geo/GeoLite2-Country.mmdb`
- [ ] Métodos: `getCountryCode(string $ip): string`, `getCurrency()`, `getPhone()`, `getCity()`
- [ ] Fallback si no hay mmdb: devolver `'MX'`

### 3.2 `src/Services/SeoService.php`

- [ ] `setTitle()`, `setDescription()`, `setCanonical()`
- [ ] Open Graph y Twitter Cards
- [ ] JSON-LD schemas: `Organization`, `RealEstateListing`, `Person`, `FAQPage`, `Review`, `BreadcrumbList`
- [ ] `hreflang()` por variante de país
- [ ] `toHtml(): string` — devuelve todos los meta tags como string HTML

### 3.3 `src/Services/CacheService.php`

- [ ] File-based en `storage/cache/`
- [ ] `set(string $key, string $html, int $ttl = 900): void`
- [ ] `get(string $key): ?string`
- [ ] `forget(string $key): void`
- [ ] Nombre de archivo: `md5($key) . '.cache'`

### 3.4 `src/Services/CsrfService.php`

- [ ] Token rotativo por sesión: `generate(): string`
- [ ] `validate(string $token): bool`
- [ ] Helper `field(): string` — devuelve `<input type="hidden">` listo

### 3.5 `src/Services/RateLimitService.php`

- [ ] File-based, sin Redis
- [ ] `check(string $ip, string $action, int $max, int $window): bool`
- [ ] Guarda contador en `storage/cache/ratelimit_{hash}.json`

### 3.6 `src/Services/RecaptchaService.php`

- [ ] Verifica token v3 contra API de Google
- [ ] `verify(string $token, float $minScore = 0.5): bool`

### 3.7 `src/Services/MailService.php`

- [ ] `send(string $to, string $subject, string $body): bool`
- [ ] `confirmNewsletter(string $email): bool`
- [ ] `notifyLead(array $lead): bool`

### 3.8 `src/Services/SitemapService.php`

- [ ] `generate(array $entries): string` — devuelve XML válido
- [ ] Incluir `<loc>`, `<lastmod>`, `<changefreq>`, `<priority>`

### 3.9 `src/Services/I18nService.php`

- [ ] Traducciones ES-MX, ES-CO, ES-CL en arrays PHP
- [ ] `t(string $key, array $replace = []): string`
- [ ] Detecta locale desde `$countryCode`

### 3.10 Commit

- [ ] `git commit -m "feat(services): add GeoService, SeoService, CacheService, CsrfService, RateLimitService, I18nService"`

---

## FASE 4 — Base de datos (Día 2, en paralelo)

### 4.1 Crear base de datos

```sql
CREATE DATABASE IF NOT EXISTS havre_estates CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4.2 Ejecutar migraciones en orden

- [ ] `database/migrations/001_create_properties_table.sql`
- [ ] `database/migrations/002_create_leads_table.sql`
- [ ] `database/migrations/003_create_agents_table.sql`
- [ ] `database/migrations/004_create_testimonials_sessions_cache.sql`

### 4.3 Ejecutar seeds

- [ ] `database/seeds/001_properties.sql` — 20 propiedades (MX/CO/CL)
- [ ] `database/seeds/002_agents.sql` — 5 agentes
- [ ] `database/seeds/003_testimonials.sql` — 6 testimonios

### 4.4 Modelos

- [ ] `src/Models/Property.php` — `getByCountry()`, `getBySlug()`, `getFeatured()`, `getSitemapEntries()`, `search()`
- [ ] `src/Models/Agent.php` — `getActive(?string $country)`, `getById()`
- [ ] `src/Models/Lead.php` — `create(array $data): int`, `calcScore(array $data): int`

### 4.5 Commit

- [ ] `git commit -m "feat(models): add Property, Agent and Lead models with PDO prepared statements"`

---

## FASE 5 — Layout global y CSS (Día 3)

### 5.1 `resources/css/app.css`

- [ ] `@import 'tailwindcss'` (Tailwind v4)
- [ ] Variables CSS custom: `--color-gold`, `--color-ink`, `--color-paper`, etc.
- [ ] **Escala tipográfica modular** (ratio 1.25 — Major Third):

  ```css
  :root {
    --text-xs:   0.64rem;
    --text-sm:   0.8rem;
    --text-base: 1rem;
    --text-md:   1.25rem;
    --text-lg:   1.563rem;
    --text-xl:   1.953rem;
    --text-2xl:  2.441rem;
    --text-3xl:  3.052rem;
  }
  ```

- [ ] Componentes base: botones, badges, cards

### 5.2 `resources/fonts/index.css`

- [ ] Importar Playfair Display (400, 700, 900, italic) con `font-display: swap`
- [ ] Importar IBM Plex Sans (300, 400, 500) con `font-display: swap`
- [ ] Importar IBM Plex Mono (400, 500) con `font-display: swap`
- [ ] Verificar que Fontsource inyecta `font-display: swap` automáticamente en sus `@font-face`
- [ ] **Cero imports** a `fonts.googleapis.com` en todo el proyecto

### 5.3 `resources/js/main.js`

- [ ] Importar `../fonts/index.css`
- [ ] Importar `../css/app.css`
- [ ] Inicializar Alpine.js: `window.Alpine = Alpine; Alpine.start()`
- [ ] Registrar Service Worker

### 5.4 `src/Views/layouts/main.php`

- [ ] `<meta charset>`, viewport, theme-color, safe-area-inset
- [ ] `<link rel="preload">` para fuentes críticas (woff2 latin 400)
- [ ] Inyección de meta tags desde `SeoService` (`{$seo->toHtml()}`)
- [ ] Manifest PWA: `<link rel="manifest">`
- [ ] Carga de CSS y JS compilados por Vite (leer `public/assets/.vite/manifest.json`)
- [ ] Skip-to-content link para accesibilidad

### 5.5 `public/manifest.webmanifest`

- [ ] `name`, `short_name`, `start_url`, `display: standalone`
- [ ] `theme_color`, `background_color`
- [ ] Iconos 192×192 y 512×512

### 5.6 `public/sw.js` (Service Worker)

- [ ] Cache-first para assets estáticos
- [ ] Network-first para rutas HTML
- [ ] `public/offline.html` como fallback

### 5.7 Commit

- [ ] `git commit -m "feat(layout): add global layout, Tailwind config, PWA manifest and service worker"`

---

## FASE 6 — Landing 1: Home (Día 5)

> Branch: `git checkout -b feature/landing-home`

### 6.1 `src/Controllers/HomeController.php`

- [ ] `index(Request $request): Response`
  - Llama a `GeoService` → detecta país
  - Llama a `Property::getFeatured($country)`
  - Llama a `SeoService` → title/description/OG para Home
  - Renderiza `home.php` con datos inyectados
- [ ] `subscribe(Request $request): Response` — newsletter
  - Valida CSRF, honeypot, rate limit
  - Guarda email en tabla `leads`
  - Llama a `MailService::confirmNewsletter()`

### 6.2 `src/Views/pages/home.php` — 7 secciones

1. **Hero** — video background `<video autoplay muted loop playsinline>`, poster `<150KB`, badge GEO dinámico
2. **Buscador AJAX** — formulario con filtros tipo/precio/m²/ciudad, `aria-live="polite"` para resultados
3. **Propiedades destacadas** — carousel ARIA con `role="region"`, swipe JS nativo, `loading="lazy"` en imágenes
4. **Mapa Leaflet** — clusters por ciudad, centrado en país detectado, marcadores SVG custom
5. **Contadores** — `IntersectionObserver` activa animación al entrar en viewport
6. **Testimonios** — Review JSON-LD, cards con foto, nombre, rating
7. **Newsletter** — form con honeypot `<input name="website">`, CSRF hidden field

### 6.3 PR y merge

- [ ] `git push origin feature/landing-home`
- [ ] Crear PR: `feature/landing-home` → `develop`
- [ ] Descripción del PR con checklist de secciones
- [ ] Merge con squash

---

## FASE 7 — Landing 2: Venta (Día 6)

> Branch: `git checkout -b feature/landing-venta`

### 7.1 `src/Controllers/VentaController.php`

- [ ] `index()` — carga filtros desde `$_GET`, paginación cursor-based, JSON-LD RealEstateListing
- [ ] `loadMore()` — endpoint AJAX que devuelve JSON con siguiente página (cursor)

### 7.2 `src/Views/pages/venta.php` — 7 secciones

1. **Hero parallax** — `background-attachment: fixed` CSS puro, sin JS
2. **Filtros URL-state** — `URLSearchParams` + `history.pushState()` para compartibles y botón Atrás funcional
3. **Grid paginado** — cursor-based (no offset SQL), JSON-LD por card
4. **Modal detalle** — `<dialog>` nativo, `aria-modal="true"`, JSON-LD dinámico en `<script type="application/ld+json">`
5. **Comparador** — máx. 3 propiedades side-by-side, tabla comparativa
6. **Calculadora hipoteca** — Alpine.js reactivo: cuota mensual, total intereses, amortización
7. **CTA flotante** — aparece al pasar 300px de scroll, dismiss con X, `position: sticky`

### 7.3 PR y merge → develop

---

## FASE 8 — Landing 3: Renta (Día 6–7)

> Branch: `git checkout -b feature/landing-renta`

### 8.1 `src/Controllers/RentaController.php`

- [ ] Carga propiedades tipo `renta` con precios por temporada
- [ ] Procesa búsqueda por fechas desde `$_GET`

### 8.2 `src/Views/pages/renta.php` — 7 secciones

1. **Hero slideshow** — `<picture>` con fuentes WebP + AVIF + JPEG fallback, dots de navegación CSS/JS
2. **Precios por temporada** — Alpine.js: alta/baja/media según fechas elegidas
3. **Formulario multistep** — 3 pasos: fechas → huéspedes → contacto; validación en cada paso
4. **Experiencias incluidas** — grid SVG: tours, chef privado, traslados, spa
5. **Grid propiedades** — cards con precio dinámico calculado
6. **Calendario vanilla JS** — desde cero sin librerías: selección check-in/check-out, rango resaltado
7. **FAQs** — `<details>/<summary>` animado con CSS, FAQPage JSON-LD

### 8.3 PR y merge → develop

---

## FASE 9 — Landing 4: Desarrollos (Día 8–9)

> Branch: `git checkout -b feature/landing-desarrollos`

### 9.1 `src/Controllers/DesarrollosController.php`

- [ ] Carga desarrollos con estado de unidades
- [ ] Endpoint JSON `/api/units/{slug}` para el plano SVG

### 9.2 `src/Views/pages/desarrollos.php` — 7 secciones

1. **Hero partículas CSS** — `@keyframes` con `animation-delay` escalonado, sin canvas ni JS
2. **Countdown** — `requestAnimationFrame`, días/horas/minutos/segundos a fecha de entrega
3. **Plano SVG interactivo** — click en cada unidad → fetch `/api/units/{slug}` → muestra estado (disponible/reservada/vendida), accesible: `tabindex`, `role="button"`, Enter key
4. **Scroll-driven animations** — `animation-timeline: scroll()` CSS nativo para timeline de obra
5. **Galería 360°** — CSS `perspective: 800px` cube con 6 caras, botones prev/next
6. **Amenidades SVG** — iconos inline animados en hover con `stroke-dashoffset`
7. **Formulario lead scoring** — indicador de score en tiempo real (Alpine.js), campo por campo suma puntos visibles

### 9.3 PR y merge → develop

---

## FASE 10 — Landing 5: Contacto (Día 9–10)

> Branch: `git checkout -b feature/landing-contacto`

### 10.1 `src/Controllers/ContactoController.php`

- [ ] `index()` — carga agentes, oficinas, prepara JSON-LD Person
- [ ] `send(Request $request)` — valida CSRF + reCAPTCHA v3 + rate limit → guarda mensaje
- [ ] `stream(Request $request)` — SSE: headers `Content-Type: text/event-stream`, bucle `sleep(2)`, lee `storage/chat/messages.json`

### 10.2 `src/Views/pages/contacto.php` — 7 secciones

1. **Hero editorial** — tipografía Playfair 900 animada con `@keyframes fadeUp` CSS
2. **Canales de atención** — grid: teléfono/email/WhatsApp/maps con SVG inline accesibles
3. **Grid agentes** — foto, idiomas (badges), especialidad, Person JSON-LD en `<script type="application/ld+json">`
4. **Mapa Leaflet 3 oficinas** — CDMX, Medellín, Santiago; marcadores SVG personalizados; popup con dirección
5. **Chat SSE** — formulario con CSRF + reCAPTCHA v3; `EventSource` en JS escucha `/contacto/stream`
6. **Manifiesto de marca** — párrafos con `IntersectionObserver` fade-in al hacer scroll
7. **Prensa / menciones** — logos SVG de medios (filtro `grayscale` → color en hover)

### 10.3 PR y merge → develop

---

## FASE 11 — SEO, Performance y Accesibilidad (Día 11–12)

### 11.1 SEO técnico

- [ ] Verificar `<title>` único por landing (60–70 chars)
- [ ] `<meta name="description">` único por landing (120–160 chars)
- [ ] Canonical tags con parámetros de filtros ignorados
- [ ] `hreflang`: `x-default`, `es-MX`, `es-CO`, `es-CL` en `<head>` de cada página
- [ ] Open Graph: `og:title`, `og:description`, `og:image`, `og:url`, `og:type`
- [ ] Twitter Cards: `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`
- [ ] Validar JSON-LD en <https://validator.schema.org> para cada página
- [ ] Sitemap XML accesible en `/sitemap.xml` con todas las propiedades
- [ ] `robots.txt` en `/robots.txt` apuntando al sitemap

### 11.2 Performance

- [ ] Compilar assets: `npm run build` — verificar que salgan CSS y JS minificados
- [ ] Imágenes: convertir a WebP y AVIF; usar `<picture>` con fallback JPEG
- [ ] `loading="lazy"` en todas las imágenes que no sean LCP
- [ ] `fetchpriority="high"` en la imagen LCP de cada landing
- [ ] Critical CSS inline en `<head>` (estilos above-the-fold del hero)
- [ ] Preload de fuentes críticas: `<link rel="preload" as="font" crossorigin>`
- [ ] Verificar que no haya JavaScript bloqueante sin `defer` o `async`
- [ ] **INP < 100ms**: evitar event handlers síncronos pesados; usar `requestIdleCallback` para tareas diferibles
- [ ] Revisar con Lighthouse: **Performance ≥ 95**, **CLS = 0**, **LCP < 1.8s**, TBT < 200ms
- [ ] Medir **INP** en Chrome DevTools → Performance → "Interaction to Next Paint"

### 11.3 Accesibilidad WCAG 2.2 AA

- [ ] Navegar todo el sitio solo con Tab/Shift+Tab/Enter/Space
- [ ] Focus visible en todos los elementos interactivos (outline 2px)
- [ ] `aria-label` en botones que solo tengan iconos
- [ ] `aria-live="polite"` en zonas que actualizan contenido (buscador AJAX, chat)
- [ ] `role="dialog"`, `aria-modal="true"`, `aria-labelledby` en modales
- [ ] Contraste de texto ≥ 4.5:1 (verificar con herramienta <https://webaim.org/resources/contrastchecker/>)
- [ ] Atributo `alt` descriptivo en todas las imágenes
- [ ] Auditar con Lighthouse Accessibility ≥ 95

---

## FASE 12 — Seguridad (Día 13)

- [ ] Verificar que **todos** los queries usen prepared statements (nunca raw queries con concatenación)
- [ ] CSRF token en todos los formularios POST
- [ ] Rate limiting activo en: newsletter, contacto, chat, formulario de leads
- [ ] reCAPTCHA v3 en: chat y formulario de contacto
- [ ] Honeypot en: newsletter
- [ ] Headers HTTP verificados en producción: usar <https://securityheaders.com>
- [ ] `htmlspecialchars()` en todos los outputs de variables en Views
- [ ] Uploads de imagen (si aplica): validar MIME real con `finfo_file()`, no solo extensión
- [ ] Sesiones con `session_regenerate_id(true)` al login/cambio de privilegio
- [ ] `.env` en `.gitignore` y nunca commiteado

---

## FASE 13 — Tests PHPUnit (Día 13–14)

### 13.1 Configurar PHPUnit

- [ ] Crear `phpunit.xml` con bootstrap `tests/bootstrap.php`
- [ ] `tests/bootstrap.php` carga autoloader y parsea `.env.testing`

### 13.2 Tests a escribir (mínimo 15)

- [ ] `RouterTest` — named params, dispatch GET/POST, 404
- [ ] `RequestTest` — getParam, isPost, isAjax
- [ ] `ResponseTest` — json(), setHeader(), redirect()
- [ ] `EnvTest` — get(), default, tipos
- [ ] `CacheServiceTest` — set/get/forget/flush
- [ ] `GeoServiceTest` — getCountryCode(), getCurrency(), fallback
- [ ] `SeoServiceTest` — setTitle, truncate description, JSON-LD output
- [ ] `CsrfServiceTest` — generate/validate
- [ ] `RateLimitServiceTest` — bloquea tras max intentos
- [ ] `PropertyModelTest` — getByCountry() con DB mockeada o DB de test

### 13.3 Ejecutar tests

```bash
php vendor/bin/phpunit --testdox
```

- [ ] Todos deben pasar: `OK (X tests, Y assertions)`

---

## FASE 14 — Deploy en producción (Día 14)

### 14.0 Merge develop → main

> Solo cuando todas las features estén en `develop` y los tests pasen.

```bash
# PR final: develop → main
gh pr create --title "release: HAVRE ESTATES v1.0 production deploy" --base main --head develop
gh pr merge <NUM> --squash
git checkout main
git pull origin main
```

### 14.1 Preparar archivos

- [ ] `npm.cmd run build` → genera `public/assets/` con manifest
- [ ] Configurar `.env` de producción:

  ```dotenv
  APP_URL=https://distribuidoroficial.mx
  APP_ENV=production
  DB_HOST=localhost
  DB_NAME=havre_estates
  DB_USER=<usuario_cpanel>
  DB_PASS=<contraseña_cpanel>
  RECAPTCHA_SITE_KEY=<key_real>
  RECAPTCHA_SECRET_KEY=<secret_real>
  ```

- [ ] Verificar que `storage/cache/` y `storage/geo/` tienen permisos de escritura (`chmod 775`)

### 14.2 Subir a cPanel (`distribuidoroficial.mx`)

**Datos de acceso:**

- URL del proyecto: `https://distribuidoroficial.mx/`
- cPanel: `https://distribuidoroficial.mx:2087`
- Usuario: `usrdist`

**Pasos:**

- [ ] Acceder a cPanel → **File Manager**
- [ ] Subir todos los archivos del proyecto a `public_html/havre-estates/`
- [ ] Subir `GeoLite2-Country.mmdb` a `public_html/havre-estates/storage/geo/`
- [ ] **Document Root** del dominio debe apuntar a `public_html/havre-estates/public`:
  - En cPanel: **Domains** → Edit Document Root → `/home/usrdist/public_html/havre-estates/public`
- [ ] Verificar que el `.htaccess` en `public/` redirige todo a `index.php`

### 14.3 Crear base de datos en cPanel

- [ ] cPanel → **MySQL Databases** → crear `usrdist_havre`
- [ ] Crear usuario de BD y asignar **todos los privilegios**
- [ ] Actualizar `.env` con datos de la BD creada
- [ ] Importar desde **phpMyAdmin**:
  1. `database/migrations/001_create_properties_table.sql`
  2. `database/migrations/002_create_leads_table.sql`
  3. `database/migrations/003_create_agents_table.sql`
  4. `database/migrations/004_create_testimonials_sessions_cache.sql`
  5. `database/seeds/001_properties.sql`
  6. `database/seeds/002_agents.sql`
  7. `database/seeds/003_testimonials.sql`

### 14.4 Verificar rutas en producción

- [ ] `https://distribuidoroficial.mx/` → Home
- [ ] `https://distribuidoroficial.mx/venta` → Venta
- [ ] `https://distribuidoroficial.mx/renta` → Renta
- [ ] `https://distribuidoroficial.mx/desarrollos` → Desarrollos
- [ ] `https://distribuidoroficial.mx/contacto` → Contacto
- [ ] `https://distribuidoroficial.mx/sitemap.xml` → XML válido
- [ ] `https://distribuidoroficial.mx/robots.txt` → texto plano

### 14.5 Verificar `.htaccess` en producción

- [ ] Confirmar que `mod_rewrite` está activo (cPanel → Apache Handlers)
- [ ] Comprobar headers de seguridad en [securityheaders.com](https://securityheaders.com/?q=https://distribuidoroficial.mx)

---

## FASE 15 — Entregables y evidencias (Día 14)

### 15.1 Git — verificar historial

- [ ] `git log --oneline --all | wc -l` → mínimo 40 commits visibles
- [ ] Commits siguen Conventional Commits (`feat:`, `fix:`, `chore:`, etc.)
- [ ] Al menos 5 PRs mergeados visibles en GitHub (pull_requests tab)
- [ ] Branches `main` y `develop` existen en remote
- [ ] Al menos 5 feature branches visibles en historial (`git log --oneline --all`)

### 15.2 README.md

- [ ] Instrucciones de instalación en ≤ 5 comandos
- [ ] Rutas principales documentadas
- [ ] Variables `.env` explicadas
- [ ] Comando para ejecutar tests

### 15.3 Reportes Lighthouse (5 PDFs)

- [ ] Abrir Chrome → DevTools → Lighthouse → Generate Report para cada URL:
  - `/` (Home)
  - `/venta`
  - `/renta`
  - `/desarrollos`
  - `/contacto`
- [ ] Scores mínimos: Performance ≥ 95, SEO ≥ 95, Accessibility ≥ 95
- [ ] Guardar cada reporte como PDF
- [ ] Nombrar: `lighthouse-home.pdf`, `lighthouse-venta.pdf`, etc.

### 15.4 Evidencia GEO detection

- [ ] Opción A: usar extensión Chrome "Location Guard" o VPN para simular IP de CO y CL
- [ ] Tomar screenshot con badge de país visible (moneda, teléfono, mapa centrado)
- [ ] Grabar video corto de 30-60 segundos cambiando el país y mostrando el cambio en vivo

### 15.5 Validación Schema.org

- [ ] Ir a <https://validator.schema.org>
- [ ] Pegar la URL de cada landing (o el HTML con JSON-LD)
- [ ] Captura de pantalla mostrando "No errors" por página

### 15.6 Documento de arquitectura

- [ ] `docs/ARCHITECTURE.md` debe incluir:
  - Stack tecnológico
  - Diagrama del flujo HTTP (texto ASCII o Mermaid)
  - Estructura de directorios explicada
  - Separación de capas MVC
  - Decisiones de diseño (por qué no ORM, por qué file-based cache, etc.)

---

## RESUMEN DE ENTREGABLES FINALES

| # | Entregable | Mínimo requerido | Estado |
| --- | --- | --- | --- |
| 1 | Repo GitHub público con URL | Obligatorio | ⬜ |
| 2 | Commits Conventional Commits | ≥40 commits | ⬜ |
| 3 | PRs documentados y mergeados | ≥5 PRs feature→develop + 1 develop→main | ⬜ |
| 4 | README.md — instalación en ≤5 comandos | Obligatorio | ⬜ |
| 5 | 5 landings funcionales en `distribuidoroficial.mx` | Obligatorio | ⬜ |
| 6 | `/sitemap.xml` dinámico accesible | Obligatorio | ⬜ |
| 7 | 5 reportes PDF Lighthouse | Performance/SEO/A11y ≥95 | ⬜ |
| 8 | Evidencia GEO detection (screenshot o video) | Obligatorio | ⬜ |
| 9 | Schema markup validado en schema.org | Sin errores por página | ⬜ |
| 10 | PHPUnit pasando | ≥15 tests | ⬜ |
| 11 | `docs/ARCHITECTURE.md` completo | Obligatorio | ⬜ |
| 12 | Demo en vivo | ≥7 días post-entrega | ⬜ |

### Métricas Core Web Vitals (todas las landings)

| Métrica | Umbral | Estado |
| --- | --- | --- |
| LCP | < 1.8s en 3G | ⬜ |
| CLS | = 0 | ⬜ |
| INP | < 100ms | ⬜ |
| 0 errores JS console | 0 | ⬜ |
| Lighthouse Performance | ≥ 95 | ⬜ |
| Lighthouse Accessibility | ≥ 95 | ⬜ |
| Lighthouse SEO | ≥ 95 | ⬜ |

---

## COMANDOS DE REFERENCIA RÁPIDA

```bash
# Instalar dependencias
composer install
npm.cmd install

# Compilar frontend
npm.cmd run build

# Servidor local PHP
php -S localhost:8000 -t public

# Tests
php vendor/bin/phpunit --testdox

# === FLUJO DE BRANCHES CORRECTO ===

# 1. Crear feature desde develop
git checkout develop
git checkout -b feature/nombre-descriptivo
git push origin feature/nombre-descriptivo

# 2. Commit semántico
git add .
git commit -m "feat(scope): descripción en minúsculas sin punto final"

# 3. Abrir PR: feature → develop (no a main)
gh pr create --title "feat(scope): título" --base develop

# 4. Mergear PR a develop
gh pr merge NUMERO --squash

# 5. Actualizar local
git checkout develop
git pull origin develop

# 6. PR final para deploy: develop → main
git checkout develop
gh pr create --title "release: v1.0 production" --base main --head develop
gh pr merge NUMERO --squash
git checkout main
git pull origin main

# === GITHUB CLI (Windows) ===
$gh = "C:\Program Files\GitHub CLI\gh.exe"
& $gh pr create --title "feat(scope): título" --base develop
& $gh pr merge NUMERO --squash --repo leonardito123/Inmobiliaria
```

---

*Guía generada el 30 de abril de 2026 · HAVRE ESTATES Dev Challenge*  
*Actualizada para cubrir los 8 retos técnicos obligatorios, 8 bonus, reglas, KPIs y deploy en `distribuidoroficial.mx`*
