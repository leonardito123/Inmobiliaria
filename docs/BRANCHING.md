# Estrategia de ramas (Git + cPanel)

## Ramas principales

- `main`: produccion. Solo codigo estable y desplegable.
- `staging`: preproduccion. Rama para validar antes de pasar a produccion.
- `develop`: integracion de trabajo diario.

## Ramas de trabajo

- `feature/<nombre>`: nuevas funcionalidades.
- `release/<version>`: estabilizacion previa a publicacion.
- `hotfix/<nombre>`: correcciones urgentes en produccion.

## Flujo recomendado

1. Crear rama desde `develop` para cada cambio:
   - `git checkout develop`
   - `git checkout -b feature/nombre-cambio`
2. Al terminar, abrir PR de `feature/*` hacia `develop`.
3. Para sacar version, crear `release/*` desde `develop`.
4. Validar `release/*` y mezclar a `staging`.
5. Desplegar `staging` en entorno de pruebas (si existe subdominio).
6. Si todo esta correcto, mezclar a `main`.
7. Desplegar `main` a cPanel productivo.

## Hotfix de emergencia

1. Crear `hotfix/*` desde `main`.
2. Corregir y mezclar a `main`.
3. Propagar el mismo hotfix a `develop` (y `staging` si aplica).

## Reglas de proteccion recomendadas

- `main` y `staging` sin push directo.
- Pull Request obligatorio.
- Al menos 1 aprobacion por PR.
- Checks de CI requeridos (tests/lint) antes de merge.

### Configuracion sugerida en GitHub

- Regla para `main`:
   - Require a pull request before merging: activado.
   - Require approvals: 2 (o 1 si el equipo es pequeno).
   - Dismiss stale pull request approvals when new commits are pushed: activado.
   - Require conversation resolution before merging: activado.
   - Require status checks to pass before merging: activado.
   - Require branches to be up to date before merging: activado.
   - Restrict who can push to matching branches: activado.
   - Allow force pushes: desactivado.
   - Allow deletions: desactivado.

- Regla para `staging`:
   - Require a pull request before merging: activado.
   - Require approvals: 1.
   - Require conversation resolution before merging: activado.
   - Require status checks to pass before merging: activado.
   - Require branches to be up to date before merging: activado.
   - Restrict who can push to matching branches: recomendado.
   - Allow force pushes: desactivado.
   - Allow deletions: desactivado.

### Checks de CI para marcar como requeridos

- `repo-health`
- `markdown-lint`

Los jobs `node-ci`, `python-ci` y `php-ci` se ejecutan solo si detectan sus archivos de stack (`package.json`, `requirements.txt`/`pyproject.toml`, `composer.json`).

## Mapeo sugerido en cPanel

- Produccion: despliegue desde `main`.
- Pruebas: despliegue desde `staging`.

## Comandos iniciales (ya aplicados localmente)

- `git branch -M main`
- `git checkout -b develop`
- `git checkout -b staging`
- `git checkout main`
