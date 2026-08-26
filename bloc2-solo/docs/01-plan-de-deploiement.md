# Plan de déploiement — CESIZen

## 1. Contexte et objectifs

CESIZen est une application web Laravel 12 (PHP 8.2+) de gestion du stress et
d'information sur la santé mentale. Ce plan décrit l'organisation, le
dimensionnement et les étapes permettant un **déploiement externalisé,
reproductible et automatisé** de la solution.

## 2. Architecture applicative

| Couche | Technologie | Rôle |
|--------|-------------|------|
| Front-end | Blade + Tailwind + Vite | Rendu des pages, assets compilés |
| Back-end | Laravel 12 / PHP 8.3 | Logique métier, API, authentification |
| Base de données | MySQL 8 | Persistance (comptes, contenus, favoris) |
| Serveur web | Nginx | Reverse proxy vers PHP-FPM |
| Exécution | PHP-FPM (conteneur) | Traitement des requêtes PHP |
| Files d'attente | Queue Laravel (DB driver) | Traitements asynchrones (mails, etc.) |

L'application est conteneurisée (voir `Dockerfile` et `docker-compose.yml`) : un
service `app` (PHP-FPM), un service `web` (Nginx) et un service `db` (MySQL).

## 3. Environnements

| Environnement | Objectif | Données | Déclenchement du déploiement |
|---------------|----------|---------|------------------------------|
| **Développement** | Codage local | Jeux de test / seeders | Manuel (`composer dev`) |
| **Test / Préproduction** | Validation client, recette | Anonymisées, iso-prod | Auto sur push `preprod` (CI verte) |
| **Production** | Service aux utilisateurs | Réelles | Manuel validé (`workflow_dispatch`) |

> Conformément au sujet, **un seul environnement** (préproduction, via Docker)
> est réellement mis en place et configuré pour la démonstration.

### 3.1 Dimensionnement cible (préproduction)

- 1 vCPU / 2 Go RAM pour le conteneur applicatif.
- 1 vCPU / 2 Go RAM pour MySQL, volume persistant 20 Go.
- Nginx en frontal, terminaison TLS (Let's Encrypt) au niveau du reverse proxy.

## 4. Chaîne d'intégration et de déploiement continu (CI/CD)

Les workflows GitHub Actions se trouvent dans `.github/workflows/`.

### 4.1 Intégration continue — `ci.yml`

Déclenchée sur chaque `push`/`pull_request` vers `main` et `preprod` :

1. Installation de PHP (matrice 8.2 / 8.3) et des dépendances Composer.
2. **Contrôle du style** de code : `vendor/bin/pint --test`.
3. **Build des assets** front : `npm ci && npm run build`.
4. **Tests automatisés** : `php artisan test` (SQLite en mémoire).

Aucun déploiement n'a lieu si l'un de ces contrôles échoue (*fail fast*).

### 4.2 Déploiement continu — `deploy.yml`

Déclenché après un merge sur `preprod` (ou manuellement pour la production) :

1. Build d'un artefact de release (`composer install --no-dev`, `npm run build`).
2. Transfert vers le serveur cible (rsync/SSH) — secrets stockés dans
   *Settings → Environments* du dépôt (jamais dans le code).
3. Migrations : `php artisan migrate --force`.
4. Mise en cache : `config:cache`, `route:cache`, `view:cache`.
5. Redémarrage des workers de queue.

## 5. Étapes de déploiement détaillées (préproduction Docker)

```bash
# 1. Récupérer le code
git clone <repo> && cd cesizen/bloc2-solo

# 2. Préparer la configuration
cp .env.example .env         # renseigner APP_KEY, APP_URL, MAIL_*
#    (les identifiants de la base du conteneur sont fixés dans docker-compose.yml)

# 3. Construire l'image applicative
docker build -t cesizen-app:latest .

# 4. Démarrer l'environnement (app PHP-FPM + Nginx + MySQL)
docker compose up -d

# 5. L'entrypoint applique automatiquement migrations + caches.
#    Application disponible sur http://localhost:8080
```

L'`entrypoint` (`docker/entrypoint.sh`) automatise migrations et optimisation
des caches à chaque démarrage du conteneur. Le code applicatif est partagé avec
Nginx via un volume (`app-code`) afin qu'il serve le point d'entrée et les
fichiers statiques.

### 5.1 Point d'attention — build derrière un DNS d'entreprise

Sur certains réseaux (ex. réseau CESI, DNS internes), le résolveur **musl**
des images Alpine échoue (« DNS: transient error ») alors que la **glibc**
(images Debian) fonctionne. Les images de build ont donc été basées sur Debian.
Si un build échoue encore sur la résolution DNS, forcer le réseau de l'hôte :

```bash
DOCKER_BUILDKIT=0 docker build --network=host -t cesizen-app:latest .
```

Correctif permanent (droits admin) : déclarer les DNS de l'hôte dans
`/etc/docker/daemon.json` puis `sudo systemctl restart docker` :

```json
{ "dns": ["10.96.23.50", "10.96.23.51"] }
```

### 5.2 Mise à jour d'une version déjà déployée

```bash
git pull
docker build -t cesizen-app:latest .
docker compose up -d --force-recreate app
# Recréer le volume app-code si le code partagé avec Nginx doit être rafraîchi :
# docker compose down && docker volume rm bloc2-solo_app-code && docker compose up -d
```

## 6. Versioning des sources et documentation

- **Git** avec stratégie de branches : `main` (production), `preprod`
  (préproduction/recette), branches de fonctionnalité `feat/*` et `fix/*`.
- Pull requests obligatoires (gabarit `PULL_REQUEST_TEMPLATE.md`) avec CI verte
  avant merge.
- Documentation versionnée avec le code (dossier `docs/`).
- Convention de messages de commit préfixés (`fix:`, `feat:`, `composer`, `npm`).

## 7. Ressources nécessaires

| Ressource | Détail |
|-----------|--------|
| Hébergement | VPS/instance cloud (UE, RGPD) + reverse proxy TLS |
| Dépôt & CI/CD | GitHub + GitHub Actions (runners) |
| Registre d'images | (option) GitHub Container Registry |
| Base de données | MySQL 8 managé ou conteneurisé, sauvegardes quotidiennes |
| Secrets | GitHub Environments (SSH, DB, APP_KEY) |
| Supervision | Endpoint santé `/up`, logs centralisés |

## 8. Stratégie de retour arrière (rollback)

- Conservation des N derniers artefacts / images taguées par version.
- Rollback = redéploiement de l'image précédente + `migrate:rollback` si besoin.
- Sauvegarde de la base avant chaque migration en production.
