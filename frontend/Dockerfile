# frontend/Dockerfile
#FROM php:7.2-apache
FROM public.ecr.aws/docker/library/php:7.2-apache

# >> INICIO DE LA CORRECCIÓN <<
# Le decimos a apt que use los repositorios archivados para Debian "Buster"
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's|security.debian.org|archive.debian.org/|g' \
           -e '/stretch-updates/d' /etc/apt/sources.list
# >> FIN DE LA CORRECCIÓN <<

# 1. Instalar dependencias del sistema y extensiones de PHP (ahora funcionará)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# 2. Instalar Composer (manejador de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copiar todo el código de la aplicación
COPY . /var/www/html

# 4. Establecer el directorio de trabajo
WORKDIR /var/www/html

# 5. Instalar dependencias de PHP y crear el enlace simbólico de config
RUN composer install && \
    ln -s config-dev config

# 6. Darle permisos a Apache para que escriba en la carpeta de logs
RUN mkdir -p logs && chown -R www-data:www-data logs

# 7. Configurar Apache
COPY apache/default-site.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite && a2ensite 000-default

ENV DB_HOST=<PRIVITE_IP_DB>

EXPOSE 80
