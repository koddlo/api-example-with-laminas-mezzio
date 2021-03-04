FROM php:8.0-apache

RUN apt-get update \
  && apt-get install -y libzip-dev zip \
  && docker-php-ext-install zip \
  && a2enmod rewrite ssl \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install mongodb \
  && docker-php-ext-enable mongodb

RUN mkdir /etc/apache2/ssl \
 && openssl req \
              -new \
              -newkey rsa:4096 \
              -days 365 \
              -nodes \
              -x509 \
              -subj "/C=/ST=/L=/O=/CN=customer-api.local" \
              -keyout /etc/apache2/ssl/apache.key \
              -out /etc/apache2/ssl/apache.crt

RUN echo "ServerName customer-api" >> /etc/apache2/apache2.conf

RUN service apache2 restart

WORKDIR /var/www
