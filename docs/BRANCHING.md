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

## Mapeo sugerido en cPanel

- Produccion: despliegue desde `main`.
- Pruebas: despliegue desde `staging`.

## Comandos iniciales (ya aplicados localmente)

- `git branch -M main`
- `git checkout -b develop`
- `git checkout -b staging`
- `git checkout main`
