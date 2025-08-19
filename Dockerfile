# ---------- Build do frontend com Node ----------
FROM node:22 AS build
WORKDIR /app
COPY package*.json vite.config.* ./
RUN npm install
COPY . .
RUN npm run build

# ---------- Build do backend PHP ----------
FROM php:8.3-cli

# Instala dependências do sistema e extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /var/www/html

# Copia o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia o projeto
COPY . .

# Copia os assets compilados do frontend
COPY --from=build /app/public/build ./public/build

# Ajustes do Laravel
RUN git config --global --add safe.directory /var/www/html \
    && composer install --no-dev --optimize-autoloader \
    && php artisan storage:link \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Exposição da porta dinâmica do Render
EXPOSE $PORT

# Comando para rodar Laravel usando a porta do Render
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
