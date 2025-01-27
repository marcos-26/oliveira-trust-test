# Use PHP 8.2 como base
FROM php:8.2-fpm

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instala as dependências do sistema e as extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libssl-dev \   
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Instala a extensão MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expõe a porta 9000 para PHP-FPM
EXPOSE 9000

# Comando padrão para iniciar o PHP-FPM
CMD ["php-fpm"]
