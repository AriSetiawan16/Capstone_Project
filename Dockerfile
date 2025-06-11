# Gunakan image PHP versi 8.3 dengan Composer
FROM composer:2.7 AS composer

# Base PHP image
FROM php:8.3-cli

# Install dependency system
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Salin composer dari stage sebelumnya
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy semua file project ke container
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Generate APP_KEY otomatis saat build (optional)
RUN php artisan key:generate

# Expose port 8000 untuk php artisan serve
EXPOSE 8000

# Command untuk menjalankan Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
