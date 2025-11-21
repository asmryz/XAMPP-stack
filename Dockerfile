FROM php:8.2-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mods
RUN a2enmod rewrite
RUN a2enmod ssl

# Install Xdebug
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

# Copy default vhost if needed
COPY apache-config /etc/apache2/sites-available

# Enable your virtual hosts
RUN a2ensite 000-default.conf || true
