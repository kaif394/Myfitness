# Use an official PHP runtime as a parent image with Apache
FROM php:8.2-apache

# Set environment variables for non-interactive installs
ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies and common PHP extensions for Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libxml2-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_pgsql pgsql zip bcmath exif pcntl xml mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Copy custom PHP configuration for error logging
COPY php-custom.ini /usr/local/etc/php/conf.d/zz-php-custom.ini

# Configure Apache
RUN a2enmod rewrite
# Set ServerName globally in Apache's main configuration file to suppress warnings
RUN echo "ServerName laragym-backend.onrender.com" >> /etc/apache2/apache2.conf

# Update Apache virtual host configuration to point to Laravel's public directory
# and ensure AllowOverride All is set for .htaccess to work.
COPY <<EOF /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# Install Composer dependencies (after copying files and setting up Apache/PHP config)
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel storage and cache directories
# This ensures that the web server (www-data) can write to these directories.
# Run this after composer install as vendor files might be needed by artisan commands.
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# Clear and then re-cache configurations, routes, and views
# This should run if code copied by 'COPY .' changes, including .env
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan event:clear \
    && php artisan cache:clear
# RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
