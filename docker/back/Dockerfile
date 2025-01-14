FROM php:8.3-fpm

RUN apt-get update -y
RUN apt-get upgrade -y

RUN apt-get install -y \
        apt-transport-https \
        curl \
        build-essential \
        ca-certificates \
        git-core \
        gnupg \
        libicu-dev \
        libzip-dev \
        libssl-dev \
        zlib1g-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
    libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpq-dev \
    libwebp-dev \
        lsb-release \
        openssl \
        wget \
        xz-utils \
        nano \
        unzip

#############################################
## php extensions
#############################################
# COPY docker-php-ext-* docker-php-entrypoint /usr/bin/
# ENTRYPOINT ["docker-php-entrypoint"]
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure zip
RUN docker-php-ext-install pdo zip gd exif intl

#RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pgsql pdo_pgsql

#############################################
## composer
#############################################
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

#############################################
## node & Yarn
#############################################
ENV NODE_VERSION=22.13.0
ENV NVM_DIR=/root/.nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.1/install.sh | bash

RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version
RUN npm install -g yarn

# #############################################
## redis/amqp
# #############################################
RUN docker-php-ext-install bcmath sockets
RUN apt-get update && apt-get install -y librabbitmq-dev libssh-dev \
    && docker-php-ext-install opcache \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN adduser --home /home/dev dev
RUN usermod -aG www-data dev

RUN echo 'alias ll="ls -la"' >> /home/dev/.profile

CMD ["php-fpm"]