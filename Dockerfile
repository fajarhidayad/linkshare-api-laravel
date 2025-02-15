# Use the official PHP image
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www

# Copy Laravel files
COPY . .

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Create a non-root user
RUN useradd -m laravel
USER laravel

# Set permissions for storage & bootstrap
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000
CMD ["php-fpm"]
