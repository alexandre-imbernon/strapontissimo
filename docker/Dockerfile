# Utilise une image de base PHP avec Apache
FROM php:7.4-apache

# Copie les fichiers de l'application dans le conteneur
COPY src/ /var/www/html/

# Installe les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Configure Apache
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Expose le port 80
EXPOSE 80