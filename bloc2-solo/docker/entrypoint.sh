#!/bin/sh
set -e

# Entrypoint de production : prépare l'application avant le démarrage de PHP-FPM.

# Génère une clé applicative si absente (défense en profondeur ; en prod elle
# doit provenir d'un secret injecté par l'orchestrateur).
if [ -z "${APP_KEY}" ]; then
  echo "⚠️  APP_KEY absente : génération d'une clé temporaire."
  php artisan key:generate --force
fi

# Attend la disponibilité de la base puis applique les migrations.
echo "➤ Application des migrations..."
php artisan migrate --force

# Mise en cache pour la performance en production.
echo "➤ Optimisation des caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Application prête."
exec "$@"
