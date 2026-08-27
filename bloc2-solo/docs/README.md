# Dossier Bloc 3 — Déployer et sécuriser CESIZen

Ce dossier regroupe les livrables documentaires de l'activité 3 et les relie aux
éléments concrets mis en place dans le dépôt.

## Livrables

| Livrable | Document | Éléments concrets dans le dépôt |
|----------|----------|----------------------------------|
| Plan de déploiement | [01-plan-de-deploiement.md](01-plan-de-deploiement.md) | `.github/workflows/`, `Dockerfile`, `docker-compose.yml`, `docker/` |
| Préprod sur VM Debian | [05-preprod-vm.md](05-preprod-vm.md) | `deploy.sh`, `.github/workflows/deploy.yml` (runner self-hosted) |
| CI/CD (pipeline complet) | [06-ci-cd.md](06-ci-cd.md) | `.github/workflows/ci.yml`, `deploy.yml`, `dependabot.yml` |
| Plan de maintenance | [02-plan-de-maintenance.md](02-plan-de-maintenance.md) | `.github/ISSUE_TEMPLATE/`, `PULL_REQUEST_TEMPLATE.md`, `pint.json` |
| Plan de sécurisation | [03-plan-de-securisation.md](03-plan-de-securisation.md) | `SecurityHeaders`, `AdminMiddleware`, `RoleMiddleware`, `SECURITY.md` |
| Veille technologique | [04-veille-technologique.md](04-veille-technologique.md) | `.github/dependabot.yml`, `composer audit` (CI) |

## Correspondance avec la grille d'évaluation

| Domaine | Critère | Où le trouver |
|---------|---------|---------------|
| Déploiement | Environnement configuré avec automatisation | `Dockerfile`, `docker-compose.yml`, `docker/entrypoint.sh` |
| Déploiement | Plan de déploiement structuré + étapes + ressources | `docs/01` |
| Déploiement | Outil de versioning configuré | Git + `.github/workflows/ci.yml` |
| Maintenance | Outil de gestion des évolutions / ticketing | `.github/ISSUE_TEMPLATE/`, PR template |
| Maintenance | Organisation & méthodologie | `docs/02` |
| Maintenance | Veille technologique | `docs/04`, `.github/dependabot.yml` |
| Sécurisation | Analyse vulnérabilités + criticité | `docs/03` §2 |
| Sécurisation | Actions correctives / préventives | `docs/03` §3 + middlewares |
| Sécurisation | Gestion de crise | `docs/03` §6, `SECURITY.md` |
| Sécurisation | Données personnelles & RGPD | `docs/03` §5, `/confidentialite` |
| Bonnes pratiques | Structure du code + documentation | `pint.json`, CI, `docs/`, `README.md` |
