# Imagen base
FROM php:7.4-apache

# Instalar controlador PDO para MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar archivos de la aplicación al contenedor
COPY ./src /var/www/html/

# Puerto de escucha de Apache
EXPOSE 80
