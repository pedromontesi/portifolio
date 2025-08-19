# ---------- Build do frontend com Node ----------
FROM node:22 AS build
WORKDIR /app
COPY package*.json vite.config.* ./
RUN npm install
COPY . .
RUN npm run build

# ---------- Build do backend PHP ----------
FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=build /app/public/build ./public/build

# Ajustes Laravel em etapas separadas
RUN git config --global --add safe.directory /var/www/html

RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-mongodb

# Certificando-se de que os diretórios existem
RUN mkdir -p storage bootstrap/cache \
    && php artisan storage:link \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE $PORT

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
