# Use official PHP-FPM image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    iputils-ping

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Copy nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Copy application code
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Create health check
RUN echo '<?php phpinfo(); ?>' > /var/www/html/health.php

# Expose port
EXPOSE 80

# Start both PHP-FPM and Nginx
CMD service nginx start && php-fpm
