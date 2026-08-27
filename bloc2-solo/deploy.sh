#!/usr/bin/env bash
#
# Script de déploiement de CESIZen en préproduction (VM Debian + Docker).
# Utilisable manuellement (`./deploy.sh`) ou par le runner CI/CD self-hosted.
#
set -euo pipefail

cd "$(dirname "$0")"                    # se place dans bloc2-solo/
export COMPOSE_PROJECT_NAME=cesizen     # nom de projet stable (containers/volumes)

# Le .env est hors du dépôt (secret). On le conserve à un emplacement stable,
# hors de l'espace de travail du runner qui est recréé à chaque exécution.
STABLE_ENV="${HOME}/cesizen-preprod.env"

echo "➤ [0/4] Préparation de la configuration (.env)"
if [ ! -f "$STABLE_ENV" ]; then
    echo "  .env persistant absent : génération initiale depuis .env.example"
    cp .env.example "$STABLE_ENV"
    sed -i 's|^APP_ENV=.*|APP_ENV=production|' "$STABLE_ENV"
    sed -i 's|^APP_DEBUG=.*|APP_DEBUG=false|' "$STABLE_ENV"
    sed -i 's|^APP_URL=.*|APP_URL=http://172.20.10.4:8080|' "$STABLE_ENV"
    sed -i "s|^APP_KEY=.*|APP_KEY=base64:$(openssl rand -base64 32)|" "$STABLE_ENV"
    echo "  → configuration enregistrée dans $STABLE_ENV (modifiable si l'IP change)"
fi
cp "$STABLE_ENV" .env                    # injecte le .env dans l'espace de travail courant

echo "➤ [1/4] Build de l'image applicative (réseau host pour le DNS d'entreprise)"
DOCKER_BUILDKIT=0 docker build --network=host -t cesizen-app:latest .

echo "➤ [2/4] Démarrage / mise à jour de la stack (app + Nginx + MySQL)"
docker compose up -d

echo "➤ [3/4] Nettoyage des images orphelines"
docker image prune -f >/dev/null

echo "➤ [4/4] État des conteneurs"
docker compose ps

echo "✅ Déploiement terminé — application exposée sur le port 8080 de la VM."
