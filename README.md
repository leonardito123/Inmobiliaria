# HAVRE ESTATES

Plataforma inmobiliaria premium construida con PHP MVC artesanal, Vite y MySQL.

## Estado actual

- Home landing con GEO por pais (MX, CO, CL).
- Venta landing con filtros y cursor pagination.
- Renta landing con calendario de fechas en Vanilla JS.
- Desarrollos landing con plano SVG interactivo.
- Contacto landing con chat SSE (Server-Sent Events).
- Sitemap XML dinamico y robots.txt servidos por rutas PHP.
- Newsletter con honeypot + CSRF + rate limiting.
- PWA base: manifest, service worker y pagina offline.
- Suite de pruebas unitarias: 24 tests, 38 assertions.

## Stack

- PHP 8.2+
- MySQL 8+
- Node.js 18+
- Vite
- Tailwind CSS
- Alpine.js
- PHPUnit 11

## Requisitos

- XAMPP o entorno equivalente con PHP y MySQL.
- Composer 2.x
- Node.js y npm

## Instalacion local

### 1) Dependencias

```bash
composer install
npm install
```

En PowerShell, si hay bloqueo de scripts para npm, usa:

```bash
npm.cmd install
```

### 2) Configurar entorno

Edita el archivo `.env` y revisa especialmente:

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`

### 3) Crear esquema y datos semilla

```bash
# Windows PowerShell
Get-Content database/init.sql | C:\xampp\mysql\bin\mysql -u root
Get-Content database/seeds.sql | C:\xampp\mysql\bin\mysql -u root havre_estates
```

### 4) Compilar assets

```bash
npm run build
```

### 5) Levantar servidor PHP

```bash
php -S localhost:8000 -t public
```

App disponible en `http://localhost:8000`.

## Rutas principales

- `GET /`
- `GET /venta`
- `GET /venta/load-more` (AJAX cursor pagination)
- `GET /renta`
- `GET /desarrollos`
- `GET /contacto`
- `POST /contacto/send` (chat)
- `GET /contacto/stream` (SSE)
- `GET /sitemap.xml`
- `GET /robots.txt`
- `POST /newsletter/subscribe`

## Pruebas

```bash
php vendor/phpunit/phpunit/phpunit tests/Unit --no-coverage
```

## Estructura relevante

```text
public/
src/
Core/
Controllers/
Models/
Services/
Views/
routes/
database/
init.sql
seeds.sql
tests/
storage/
```

## Notas

- El chat SSE persiste mensajes en `storage/chat/messages.json`.
- Ese archivo esta ignorado por git para evitar versionar datos runtime.
- Para reCAPTCHA v3 define `RECAPTCHA_ENABLED`, `RECAPTCHA_SITE_KEY` y `RECAPTCHA_SECRET_KEY` en `.env`.
