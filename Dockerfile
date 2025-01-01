# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    curl \
    libzip-dev \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Habilitar módulos necesarios de Apache
RUN a2enmod rewrite ssl

# Instalar Composer (gestor de dependencias de PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar archivos de configuración del servidor Apache
COPY ./laravel-https.conf /etc/apache2/sites-available/000-default.conf
COPY ./laravel-https.conf /etc/apache2/sites-available/laravel-https.conf

# Habilitar sitio SSL
RUN a2ensite laravel-https.conf

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar el contenido del proyecto Laravel al contenedor
COPY . /var/www/html

# Configurar permisos en los directorios de Laravel
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Exponer los puertos 80 (HTTP) y 443 (HTTPS)
EXPOSE 80 443

# Comando por defecto para ejecutar Apache
CMD ["apache2-foreground"]
