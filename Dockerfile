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
RUN a2enmod rewrite

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar el contenido del proyecto Laravel al contenedor
COPY . /var/www/html

# Instalar dependencias de Laravel en producción
RUN composer install --no-dev --optimize-autoloader

# Configurar permisos en los directorios de Laravel
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Configurar Apache para usar el puerto dinámico de Heroku
RUN sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf && \
    sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT:-80}>/" /etc/apache2/sites-available/000-default.conf

# Exponer el puerto (Heroku lo ignora, pero es buena práctica)
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
