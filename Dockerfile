# Use the official httpd image with PHP 8.1
FROM php:8.1-apache

# Install additional PHP extensions if needed
# For example, if you need PDO with MySQL support:
RUN docker-php-ext-install pdo_mysql

RUN apt-get update && apt-get install -y default-mysql-client && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html

# Expose port 80 for Apache
EXPOSE 80