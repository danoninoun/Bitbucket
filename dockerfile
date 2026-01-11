FROM php:8.2-apache

# Instalar el driver de MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Activamos el módulo rewrite
RUN a2enmod rewrite

# Copiamos el proyecto
COPY . /var/www/html/

# Ajustamos la carpeta pública
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80