# Estrategia de ramas

## Ramas principales

- main: produccion estable.
- staging: preproduccion para validacion.
- develop: integracion de trabajo diario.

## Ramas de trabajo

- feature/<nombre>: nuevas funcionalidades.
- release/<version>: estabilizacion de una version.
- hotfix/<nombre>: correcciones urgentes en produccion.

## Flujo sugerido

1. Crear rama feature desde develop.
2. Abrir Pull Request a develop.
3. Crear release desde develop cuando haya corte.
4. Validar en staging.
5. Merge a main solo por Pull Request.

## Reglas recomendadas

- Sin push directo a main y staging.
- Requerir aprobaciones y checks de CI.
- Evitar force push en ramas protegidas.
