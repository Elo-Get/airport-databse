FROM php:8.2-apache

# Architecture compatible M1/ARM64 + x64
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activer mod_rewrite pour Symfony
RUN a2enmod rewrite

# Configuration Apache
COPY apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# Définir le dossier par défaut
WORKDIR /var/www/html
