FROM php:8.2-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mods
RUN a2enmod rewrite
RUN a2enmod ssl

# Install Xdebug
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

# Copy Apache configuration
COPY ./apache-config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable mod_autoindex for directory listings
RUN a2enmod autoindex

# Enable your virtual hosts
RUN a2ensite 000-default.conf
