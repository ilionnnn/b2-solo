# syntax=docker/dockerfile:1

###########################################################
# Étape 1 : build des assets front-end (Vite / Tailwind)
# Base Debian (glibc) : résolveur DNS compatible réseaux d'entreprise.
###########################################################
FROM node:20 AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

###########################################################
# Étape 2 : dépendances PHP (sans dev) via Composer
###########################################################
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-interaction --optimize-autoloader

###########################################################
# Étape 3 : image applicative de production (PHP-FPM, Debian)
###########################################################
FROM php:8.3-fpm AS app

# Extensions PHP requises par Laravel, installées via l'utilitaire
# install-php-extensions (gère automatiquement les dépendances système).
# On installe uniquement les extensions nécessaires à l'application :
# pdo_mysql (base de données), bcmath, intl. opcache est déjà fourni par l'image.
# gd/zip sont volontairement écartées (chaîne de compilation lourde, non requises).
COPY --from=ghcr.io/mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql bcmath intl

# Configuration OPcache pour la production
RUN { \
      echo 'opcache.enable=1'; \
      echo 'opcache.memory_consumption=128'; \
      echo 'opcache.max_accelerated_files=10000'; \
      echo 'opcache.validate_timestamps=0'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

# Code applicatif + dépendances + assets compilés
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Droits sur les dossiers inscriptibles par Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

EXPOSE 9000
ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]
