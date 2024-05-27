# Usa la imagen base oficial de PHP con Apache y PHP 8.2
FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación al contenedor
COPY . /var/www/html

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Cambia los permisos de todos los archivos para que sean escribibles (ajustar según sea necesario)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto 80 para el servidor web Apache
EXPOSE 80

# Define el comando de inicio del contenedor
CMD ["apache2-foreground"]
