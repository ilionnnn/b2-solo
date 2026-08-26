#!/usr/bin/env bash
#
# Script de déploiement de CESIZen en préproduction (VM Debian + Docker).
# Utilisable manuellement (`./deploy.sh`) ou par le runner CI/CD self-hosted.
#
set -euo pipefail

cd "$(dirname "$0")"                    # se place dans bloc2-solo/
export COMPOSE_PROJECT_NAME=cesizen     # nom de projet stable (containers/volumes)

echo "➤ [1/4] Build de l'image applicative (réseau host pour le DNS d'entreprise)"
DOCKER_BUILDKIT=0 docker build --network=host -t cesizen-app:latest .

echo "➤ [2/4] Démarrage / mise à jour de la stack (app + Nginx + MySQL)"
docker compose up -d

echo "➤ [3/4] Nettoyage des images orphelines"
docker image prune -f >/dev/null

echo "➤ [4/4] État des conteneurs"
docker compose ps

echo "✅ Déploiement terminé — application exposée sur le port 8080 de la VM."
