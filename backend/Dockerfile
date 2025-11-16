# Use PHP with Apache (more reliable than PHP-FPM for this use case)
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
    iputils-ping \
    default-mysql-client \
    wget

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd sockets

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Create health check endpoint
RUN echo '<?php \n\
header("Content-Type: application/json"); \n\
http_response_code(200); \n\
echo json_encode(["status" => "healthy", "service" => "backend", "timestamp" => date("c")]); \n\
?>' > /var/www/html/health.php

# Create test endpoint
RUN echo '<?php \n\
header("Content-Type: application/json"); \n\
echo json_encode(["status" => "ok", "message" => "Backend API is running"]); \n\
?>' > /var/www/html/test.php

# Expose port
EXPOSE 80

# Apache runs automatically via the base image's CMD
