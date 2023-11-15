FROM php:8.1-apache

# change working dir
WORKDIR /var/www/html
# copy all the files to web root
COPY . /var/www/html

# install extensions
RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

EXPOSE 80

# SET DOC ROOT
ENV APACHE_DOCUMENT_ROOT /var/www/html

CMD ["apache2-foreground"]