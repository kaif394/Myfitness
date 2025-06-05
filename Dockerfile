# Use the official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Clear cache
RUN rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Enable PHP extensions (explicitly, just in case)
RUN docker-php-ext-enable pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate application key (if not already set in .env)
# This is usually handled by environment variables on Render, but good for local Docker builds
# RUN php artisan key:generate

    # Clear config and cache to ensure environment variables are picked up
    RUN php artisan config:clear
    RUN php artisan cache:clear

    # Run migrations and seeders
    RUN php artisan migrate --force
    RUN php artisan db:seed --force

# Configure Apache for Laravel
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Expose port 80 (Apache default)
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
