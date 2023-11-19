# Use an official PHP image with Apache based on PHP 8.1
FROM php:8.1-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    unzip \
    git

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the composer.json and composer.lock files
COPY composer.json composer.lock ./

# Install project dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . .

RUN chmod -R 777 .

# Run composer install again to generate the autoloader
RUN composer install --optimize-autoloader --no-dev
RUN composer dump-autoload

# Set up Apache
RUN a2enmod rewrite

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
