# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install system dependencies and the zip extension for Composer
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# Install the MySQL database extension
RUN docker-php-ext-install pdo_mysql

# Set the working directory to the web root
WORKDIR /var/www/html

# Copy the custom Apache virtual host configuration
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# Enable our new vhost and Apache's rewrite module for pretty URLs
RUN a2ensite 000-default.conf && a2enmod rewrite

# Copy composer dependency definition files
COPY composer.json composer.lock ./

# Copy the official Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of your application's source code
COPY . .

# Change ownership of all files to the web server user
RUN chown -R www-data:www-data /var/www/html

# The base image already exposes port 80 and starts Apache, so we're done.
