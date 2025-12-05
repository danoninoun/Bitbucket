# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Activamos el módulo rewrite de Apache (buena práctica para el futuro)
RUN a2enmod rewrite

# Copiamos todo el contenido de tu proyecto a la carpeta del servidor
COPY . /var/www/html/

# IMPORTANTE:
# Como tu index.php está dentro de /public, tenemos que cambiar
# la configuración de Apache para que apunte allí directamente.
# Si no hiciéramos esto, tendrías que entrar a http://ip/public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Exponemos el puerto 80
EXPOSE 80