FROM php:7-fpm-alpine

ENV DOCKER_PHP_XDEBUG_MODE=${DOCKER_PHP_XDEBUG_MODE:-"off"}
ENV DOCKER_PHP_ERRORS=${DOCKER_PHP_ERRORS:-"off"}

ARG DOCKER_PHP_EXTENSIONS
ENV DOCKER_PHP_EXTENSIONS=${DOCKER_PHP_EXTENSIONS:-"gd mysqli bcmath pdo_mysql zip xdebug"}
ENV DOCKER_PHP_UPLOAD_SIZE=${DOCKER_PHP_UPLOAD_SIZE:-"32M"}

ARG DOCKER_COMPOSER_GIT_TOKEN
ENV DOCKER_COMPOSER_GIT_TOKEN=${DOCKER_COMPOSER_GIT_TOKEN:-""}

ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy PHP configuration
COPY .docker/php/conf.d/php.ini /usr/local/etc/php/php.ini
COPY .docker/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d

# Copy extension configurations
COPY .docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug-dev.ini
COPY .docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Logs
RUN mkdir -p /var/log/php-fpm/ && \
    chown -R www-data:www-data /var/log/php-fpm

# Install PHP Extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions $(eval echo ${DOCKER_PHP_EXTENSIONS})

# Development Tools
RUN apk add gcc make g++ zlib-dev autoconf automake libtool nasm libjpeg jpeg-dev libjpeg-turbo-dev

# Git
RUN apk add git

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add Oauth Token for Composer
RUN composer config -g github-oauth.github.com ${DOCKER_COMPOSER_GIT_TOKEN}

# NodeJS
RUN apk add nodejs npm
# Yarn
RUN apk add yarn --repository="http://dl-cdn.alpinelinux.org/alpine/edge/community"

RUN apk add vim
RUN apk add mc

# Cron
ENV TZ=Europe/Bucharest
RUN apk add busybox-initscripts


WORKDIR /var/www/

VOLUME /var/www/node_modules

EXPOSE ${DOCKER_PHP_PORT}

CMD ["php-fpm"]
