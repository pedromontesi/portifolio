# ---------- Build do frontend com Node ----------
FROM node:22 AS build

WORKDIR /app

# Copia arquivos de configuração do Node
COPY package*.json vite.config.* ./

# Instala dependências
RUN npm install

# Copia todo o projeto
COPY . .

# Build dos assets (Tailwind/Vite)
RUN npm run build

# ---------- Build do backend PHP ----------
FROM php:8.3-cli

# Instala dependências do sistema e extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia o Composer do container oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia todo o projeto
COPY . .

# Copia os assets compilados do build Node
COPY --from=build /app/public/build ./public/build

# Ajustes Laravel
RUN git config --global --add safe.directory /var/www/html \
    && composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-mongodb \
    && php artisan storage:link \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expondo porta consistente com o .env
EXPOSE 8000

# Comando para rodar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
