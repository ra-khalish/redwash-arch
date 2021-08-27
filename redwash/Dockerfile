FROM php:7.4.14-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP Extension
RUN docker-php-ext-install mysqli pdo_mysql bcmath sockets pcntl
RUN apt-get update && apt-get install -y nano wget

# Get Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Copy config apache
COPY assets/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html/redwash

RUN a2enmod rewrite