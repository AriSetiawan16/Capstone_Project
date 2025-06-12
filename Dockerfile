# Stage 1: Composer
FROM composer:2.7 AS composer

# Stage 2: Laravel + Apache + Node.js + Vite
FROM php:8.3-apache

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    unzip git curl libpng-dev libonig-dev libxml2-dev zip \
    gnupg lsb-release ca-certificates netcat \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g vite

# Set working directory
WORKDIR /var/www/html

# Copy composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies & build assets
RUN npm install --legacy-peer-deps --no-cache && npm run build

# Enable Laravel-friendly Apache configuration
RUN a2enmod rewrite

COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Tambahkan AllowOverride untuk public folder Laravel
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
</Directory>' >> /etc/apache2/apache2.conf

# Set permissions
RUN mkdir -p storage/framework/cache/data \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Tambahkan custom entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Jalankan entrypoint
CMD ["/entrypoint.sh"]
