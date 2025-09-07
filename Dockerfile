FROM php:8.3-fpm

# create userfor docker system
ARG user
ARG uid

# insatall dependency for system
RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# conection to mysql
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -u $uid -ms /bin/bash -g www-data $user

COPY . /var/www

COPY --chown=$user:www-data . /var/www

USER $user

EXPOSE 9000

CMD ["php-fpm"]