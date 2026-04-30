# Architecture — Havre Estates

## Overview

Havre Estates es una aplicación PHP 8.3+ con arquitectura MVC artesanal, sin framework, siguiendo PSR-4 (Composer) y principios SOLID.

---

## Stack tecnológico

| Capa | Tecnología | Versión |
|------|-----------|---------|
| Lenguaje backend | PHP | ^8.3 |
| Dependencias PHP | Composer (PSR-4) | 2.x |
| Base de datos | MySQL | 8+ |
| Acceso a datos | PDO + prepared statements | — |
| Frontend builder | Vite | 6.x |
| CSS utility | Tailwind CSS v4 (`@tailwindcss/vite`) | 4.x |
| Reactividad UI | Alpine.js | ^3.13 |
| Mapas | Leaflet | ^1.9 |
| Tipografías | Fontsource (Playfair Display, IBM Plex Sans/Mono) | — |
| GeoIP | MaxMind GeoLite2 (`geoip2/geoip2`) | — |
| Variables de entorno | `symfony/dotenv` | — |
| Tests | PHPUnit | ^11 |
| CI/CD | GitHub Actions | — |

---

## Estructura de directorios

```
Inmobiliaria/
├── public/             # Document root (Apache/Nginx)
│   ├── index.php       # Front controller — único punto de entrada HTTP
│   ├── .htaccess       # mod_rewrite, CSP, HSTS, compresión
│   └── assets/         # Vite build output (JS/CSS hasheados)
├── src/
│   ├── Controllers/    # HTTP handlers — reciben Request, retornan Response
│   ├── Models/         # Acceso a datos vía PDO (sin ORM)
│   ├── Services/       # Lógica de negocio desacoplada de HTTP
│   │   ├── SeoService.php       # Meta tags, JSON-LD, hreflang
│   │   ├── GeoService.php       # Detección de país por IP (MaxMind)
│   │   ├── CsrfService.php      # Tokens CSRF rotativos
│   │   ├── RateLimitService.php # Rate limiting file-based
│   │   ├── RecaptchaService.php # Google reCAPTCHA v3
│   │   ├── I18nService.php      # i18n ES-MX/CO/CL sin librerías
│   │   └── CacheService.php     # Caché de archivos simple
│   ├── Views/
│   │   ├── layouts/main.php     # Layout global (head, nav, footer)
│   │   └── pages/               # Vistas por ruta (home, venta, renta…)
│   └── Core/
│       ├── Router.php           # Routing basado en regex
│       ├── Request.php          # Abstracción de $_SERVER/$_POST/$_GET
│       └── Container.php        # DI container minimalista
├── database/
│   └── init.sql        # Esquema MySQL completo con datos semilla
├── storage/
│   ├── geo/            # Archivo mmdb GeoLite2
│   ├── cache/          # Caché de archivos (TTL configurable)
│   └── logs/           # Logs de errores (no en VCS)
├── tests/
│   └── Unit/           # PHPUnit 11 — 24 tests
├── js/                 # Fuentes Vite/Alpine/Leaflet
├── docs/               # Documentación del proyecto
└── .github/workflows/  # CI: php-ci, node-ci, markdown-lint, repo-health
```

---

## Flujo de una petición HTTP

```
Browser → Apache (mod_rewrite) → public/index.php
    │
    ├── Bootstrap: .env, autoload PSR-4, DI Container
    │
    ├── Router::dispatch($request)
    │     └── Empareja regex contra ruta → llama Controller::action()
    │
    ├── Controller
    │     ├── Valida CSRF / RateLimit / Honeypot
    │     ├── Llama Services (Geo, Seo, I18n, Cache…)
    │     ├── Llama Models (PDO queries)
    │     └── Renderiza View con variables de contexto
    │
    └── Response → Browser
```

---

## Separación de capas

### Controllers

Responsabilidad única: orquestar el flujo HTTP. No contienen lógica de negocio ni SQL.

```php
// Ejemplo simplificado
class VentaController {
    public function index(Request $req): void {
        $country = $this->geo->detect($req->ip());
        $props   = $this->propertyModel->getByCountry($country);
        $seo     = $this->seo->page('venta', $country);
        View::render('pages/venta', compact('props', 'seo'));
    }
}
```

### Models

Acceso a datos únicamente. Retornan arrays PHP, no objetos de dominio complejos.

- Todos usan PDO con prepared statements.
- Campos JSON (`languages`, `specialties`) se decodifican automáticamente con `json_decode`.
- Sin ORM para mantener control explícito del SQL.

### Services

Lógica de negocio desacoplada:

| Service | Responsabilidad |
|---------|----------------|
| `SeoService` | Genera `<meta>`, JSON-LD (FAQPage, BreadcrumbList, Person, Review, RealEstateListing) |
| `GeoService` | Detecta país/ciudad/moneda a partir del IP con MaxMind mmdb |
| `I18nService` | Traducciones ES-MX/CO/CL; expone `t(key)` y `toJson()` para Alpine.js |
| `CsrfService` | Genera y valida tokens doble-submit con rotación por formulario |
| `RateLimitService` | Contadores por IP en archivos; evita abuso sin Redis |
| `RecaptchaService` | Verifica score v3 contra la API de Google |
| `CacheService` | TTL por clave en `/storage/cache/`; evita queries repetidos |

---

## Seguridad

- **CSRF**: tokens rotativos por formulario (SaaS-safe).
- **Honeypot**: campo oculto en todos los formularios públicos.
- **Prepared statements**: 100% de queries con PDO.
- **CSP / HSTS / X-Frame-Options**: definidos en `.htaccess`.
- **Rate limiting**: por IP, configurable por ruta.
- **reCAPTCHA v3**: en formulario de contacto y chat.
- **IP hashing**: `sha256($ip)` al guardar leads (privacidad GDPR).

---

## Frontend

- **Vite 6** compila `js/main.js` → `public/assets/[hash].js`.
- **Tailwind v4** vía plugin `@tailwindcss/vite` (sin config separada).
- **Alpine.js** para reactividad inline (calculadora hipoteca, multistep form, precios temporada).
- **Leaflet** para mapas (home y contacto).
- Assets con hash en nombre → caché inmutable (`Cache-Control: max-age=31536000, immutable`).
- Fontsource: fuentes self-hosted con `font-display: swap`.

---

## Tests

24 tests PHPUnit 11 en `tests/Unit/`:

| Suite | Tests |
|-------|-------|
| SeoServiceTest | JSON-LD válido, meta tags, hreflang |
| RouterTest | Matching regex, 404, métodos HTTP |
| GeoServiceTest | Detección país, fallback, mmdb ausente |
| CacheServiceTest | TTL, hit/miss, invalidación |
| EnvTest | Variables requeridas presentes |
| RequestTest | IP forwarded, CSRF header, sanitización |

Ejecutar: `composer test` (alias para `vendor/bin/phpunit`).

---

## CI/CD (GitHub Actions)

| Workflow | Trigger | Qué hace |
|----------|---------|----------|
| `php-ci` | push/PR | `composer install`, PHPUnit, PHP_CodeSniffer |
| `node-ci` | push/PR | `npm ci`, `npm run build` |
| `markdown-lint` | push/PR | `markdownlint-cli2` en `docs/` y `*.md` raíz |
| `repo-health` | schedule diario | Verifica dependencias desactualizadas |
| `detect-stack` | push | Documenta stack detectado automáticamente |

---

## Decisiones de diseño

1. **Sin framework PHP**: control total del stack, sin deuda de versiones, ideal para aprendizaje profundo.
2. **Sin ORM**: SQL explícito previene N+1 accidental y facilita optimización.
3. **Alpine.js en lugar de React/Vue**: reactividad suficiente para formularios y UI interactiva sin build complejo ni hydration cost.
4. **GeoIP file-based**: no requiere servicio externo en producción; mmdb se actualiza mensualmente con MaxMind.
5. **Rate limiting en archivos**: sin Redis como dependencia obligatoria; adecuado para cargas moderadas.
6. **Vite + Tailwind v4**: pipeline moderno con HMR en desarrollo y assets optimizados en producción.
