# CESIZen

Application web de gestion du stress et d'information sur la santé mentale
(Laravel 12 / PHP 8.2+). Ce dépôt correspond au **Bloc 3 — Déployer et sécuriser
les applications informatiques**.

## Fonctionnalités

- Comptes utilisateurs (inscription, authentification, profil, réinitialisation
  de mot de passe, suppression de compte avec consentement RGPD).
- Contenus d'information sur la santé mentale.
- Exercices de respiration.
- Espaces d'administration et de modération (contrôle d'accès par rôle).

## Stack technique

| Composant | Version |
|-----------|---------|
| PHP | 8.2 / 8.3 |
| Laravel | 12 |
| Base de données | MySQL 8 (SQLite en test) |
| Front | Blade, Tailwind CSS, Vite |

## Installation (développement)

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
composer dev        # serveur + queue + vite
```

## Déploiement conteneurisé (préproduction)

```bash
docker compose up -d --build
# Application disponible sur http://localhost:8080
```

Voir le [plan de déploiement](docs/01-plan-de-deploiement.md) pour le détail.

## Qualité & CI

```bash
vendor/bin/pint          # formatage du code
vendor/bin/pint --test   # vérification du style (CI)
php artisan test         # tests automatisés
```

La CI (`.github/workflows/ci.yml`) exécute style, audit de sécurité des
dépendances, build des assets et tests à chaque push / pull request.

## Documentation (dossier Bloc 3)

Les livrables sont dans [`docs/`](docs/README.md) :

- [Plan de déploiement](docs/01-plan-de-deploiement.md)
- [Plan de maintenance](docs/02-plan-de-maintenance.md)
- [Plan de sécurisation](docs/03-plan-de-securisation.md)
- [Veille technologique](docs/04-veille-technologique.md)
- [Politique de sécurité](SECURITY.md)

## Structure du projet

```
bloc2-solo/
├── app/                  # Contrôleurs, modèles, middlewares
├── docker/               # entrypoint, configuration Nginx
├── docs/                 # Livrables documentaires du Bloc 3
├── routes/web.php        # Routes applicatives
├── Dockerfile            # Image de production (multi-étapes)
├── docker-compose.yml    # Environnement app + web + db
└── pint.json             # Règles de style de code
.github/                  # (racine du dépôt) CI/CD, ticketing, Dependabot
```
