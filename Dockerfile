# Usa la imagen base oficial de PHP
FROM php:7.4-apache

# Instala extensiones de PHP adicionales si es necesario
# RUN docker-php-ext-install <extension>

# Copia los archivos de la aplicación al contenedor
COPY . /var/www/html

# Cambia los permisos de todos los archivos para que sean escribibles
RUN chmod -R 777 /var/www/html

# Expone el puerto 80 para el servidor web Apache
EXPOSE 80

# Define el comando de inicio del contenedor
CMD ["apache2-foreground"]
