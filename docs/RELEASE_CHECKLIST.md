# Release Checklist

## 1) Preparacion

- [ ] `develop` actualizado y estable
- [ ] Version objetivo definida
- [ ] Cambios de la version documentados
- [ ] Dependencias bloqueadas/validadas

## 2) Rama de release

- [ ] Crear rama: `release/<version>` desde `develop`
- [ ] Ajustar versionado (si aplica)
- [ ] Congelar cambios no criticos

## 3) Calidad y pruebas

- [ ] Tests unitarios pasan
- [ ] Tests de integracion pasan
- [ ] Lint/analisis estatico limpio
- [ ] Validacion funcional completa
- [ ] Validacion de performance basica

## 4) Base de datos y config

- [ ] Migraciones revisadas
- [ ] Script de rollback preparado
- [ ] Variables de entorno verificadas
- [ ] Backups previos al despliegue confirmados

## 5) Preproduccion (`staging`)

- [ ] Merge de `release/*` a `staging`
- [ ] Deploy en `staging` ejecutado
- [ ] Smoke tests OK
- [ ] Aprobacion funcional del negocio

## 6) Produccion (`main`)

- [ ] Merge de `release/*` a `main`
- [ ] Tag de version creado (ejemplo: `v1.4.0`)
- [ ] Deploy en cPanel desde `main`
- [ ] Verificacion post-deploy completada

## 7) Post-release

- [ ] Monitoreo de errores 24h
- [ ] Hotfix plan listo en caso de incidente
- [ ] Merge de `main` de vuelta a `develop` (si aplica)
- [ ] Changelog/notas de version publicadas

## Comandos utiles

```bash
# Crear release
git checkout develop
git pull
git checkout -b release/1.0.0

# Enviar release al remoto
git push -u origin release/1.0.0

# Tag en main
git checkout main
git pull
git tag -a v1.0.0 -m "Release v1.0.0"
git push origin v1.0.0
```
