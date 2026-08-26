# Résumé des modifications — Bloc 3 (Déployer et sécuriser)

Ce document récapitule toutes les modifications apportées au projet CESIZen pour
couvrir les critères de la grille d'évaluation du Bloc 3.

> Les changements sont dans le *working tree* (non committés). `.github/` est
> placé à la **racine du dépôt Git**, le reste sous `bloc2-solo/`.

---

## 1. Réparation de l'application (préalable)

L'application ne démarrait pas (références cassées). Corrections :

| Fichier | Modification |
|---------|--------------|
| `app/Http/Middleware/RoleMiddleware.php` | **Créé** — contrôle d'accès par rôle (`admin`/`user`/`moderator`) |
| `routes/web.php` | Suppression des routes vers 3 contrôleurs inexistants ; ajout route `/confidentialite` |
| `resources/views/legal/mentions.blade.php` | **Créé** — mentions légales |
| `resources/views/legal/cgu.blade.php` | **Créé** — conditions générales d'utilisation |
| `resources/views/legal/confidentialite.blade.php` | **Créé** — politique de confidentialité (RGPD) |
| `resources/views/legal/contact.blade.php` | **Créé** — page contact |
| `resources/views/support.blade.php` | **Créé** — page support |
| `resources/views/moderator/dashboard.blade.php` | **Créé** — espace modérateur |

**Résultat** : `php artisan route:list` et `view:cache` passent, l'app démarre.

---

## 2. Déploiement (CI/CD, versioning, environnement)

| Fichier | Rôle |
|---------|------|
| `.github/workflows/ci.yml` | Intégration continue : style (Pint), audit sécurité, build assets, tests |
| `.github/workflows/deploy.yml` | Déploiement continu préprod/production |
| `Dockerfile` | Image de production multi-étapes (assets + vendor + PHP-FPM) |
| `docker-compose.yml` | Environnement app + web (Nginx) + db (MySQL) |
| `docker/entrypoint.sh` | Automatise migrations et mise en cache au démarrage |
| `docker/nginx.conf` | Config Nginx + blocage fichiers sensibles |
| `.dockerignore` | Exclusions du contexte de build |
| `docs/01-plan-de-deploiement.md` | Plan de déploiement (architecture, environnements, étapes, ressources, rollback) |

---

## 3. Maintenance (ticketing, méthodologie, veille)

| Fichier | Rôle |
|---------|------|
| `.github/ISSUE_TEMPLATE/bug_report.yml` | Gabarit anomalie avec criticité |
| `.github/ISSUE_TEMPLATE/feature_request.yml` | Gabarit évolution avec priorité |
| `.github/ISSUE_TEMPLATE/config.yml` | Redirection sécurité (canal privé) et support |
| `.github/PULL_REQUEST_TEMPLATE.md` | Checklist qualité des pull requests |
| `.github/dependabot.yml` | Veille automatisée des dépendances (Composer, npm, Actions) |
| `docs/02-plan-de-maintenance.md` | Méthodologie, SLA, cycle de vie des tickets |
| `docs/04-veille-technologique.md` | Sources, outils et méthodologie de veille |

---

## 4. Sécurisation (vulnérabilités, RGPD, crise, bonnes pratiques)

| Fichier | Rôle |
|---------|------|
| `app/Http/Middleware/SecurityHeaders.php` | **Créé** — en-têtes HTTP de sécurité (X-Frame-Options, HSTS, etc.) |
| `bootstrap/app.php` | Enregistrement global du middleware `SecurityHeaders` |
| `SECURITY.md` | Politique de signalement des vulnérabilités + engagements |
| `docs/03-plan-de-securisation.md` | Analyse des risques avec **criticité**, actions correctives/préventives, chiffrement, RGPD, gestion de crise |
| `pint.json` | Règles de style de code (bonne pratique) |
| Ensemble du code `app/` | Reformaté avec Laravel Pint |

---

## 5. Documentation

| Fichier | Rôle |
|---------|------|
| `README.md` | Réécrit (spécifique CESIZen : install, déploiement, CI, structure) |
| `docs/README.md` | Index des livrables + correspondance avec la grille |
| `docs/00-resume-modifications.md` | Le présent document |

---

## Correspondance synthétique avec la grille

| Domaine | Critère grille | Élément livré |
|---------|----------------|---------------|
| Déploiement | Environnement + automatisation | Docker + entrypoint |
| Déploiement | Plan de déploiement | `docs/01` |
| Déploiement | Outil de versioning | Git + CI GitHub Actions |
| Maintenance | Ticketing | Issues + PR templates |
| Maintenance | Méthodologie | `docs/02` |
| Maintenance | Veille | Dependabot + `docs/04` |
| Sécurisation | Vulnérabilités + criticité | `docs/03` §2 |
| Sécurisation | Actions correctives/préventives | `docs/03` §3 + middlewares |
| Sécurisation | Gestion de crise | `docs/03` §6 + `SECURITY.md` |
| Sécurisation | RGPD | `docs/03` §5 + `/confidentialite` |
| Bonnes pratiques | Structure + documentation | Pint + `docs/` + README |

---

## Points d'attention

1. **Tests** : non exécutables dans l'environnement local (`pdo_sqlite` absent).
   Ils tournent en CI. En local : `sudo apt-get install php8.4-sqlite3` puis
   `php artisan test`.
2. **`.github/`** est à la racine du dépôt (lu par GitHub) ; les workflows
   pointent vers `bloc2-solo/` via `working-directory`.
