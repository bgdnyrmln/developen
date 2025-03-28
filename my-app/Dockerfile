# FROM aspendigital/octobercms:php7.4-apache
FROM php:8.2-apache
# FROM php:7.4-apache

RUN apt-get update && apt-get install -y cron git-core jq unzip vim zip libxml2-dev \
  libjpeg-dev libpng-dev libpq-dev libsqlite3-dev libwebp-dev libzip-dev && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-configure zip --with-zip && \
  docker-php-ext-configure gd --with-jpeg --with-webp && \
  docker-php-ext-install -j$(nproc) exif gd mysqli opcache pdo_pgsql pdo_mysql soap intl

RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
  } > /usr/local/etc/php/conf.d/docker-oc-opcache.ini

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

SHELL ["/bin/bash", "-c"]

RUN a2enmod rewrite

CMD ["apache2-foreground"]

# # Install Node version manager and node and yarn
# RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash && source ~/.profile \
#         && nvm install 12.16.3 \
#         && npm -g install yarn


# Install nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.2/install.sh | bash

# Install Node.js using nvm
RUN bash -c "\
    export NVM_DIR=\$HOME/.nvm && \
    [ -s \"\$NVM_DIR/nvm.sh\" ] && \. \"\$NVM_DIR/nvm.sh\" && \
    nvm install 22"

# Set environment variables for nvm
ENV NVM_DIR /root/.nvm
ENV PATH $NVM_DIR/versions/node/v22.14.0/bin:$PATH

# Verify the Node.js version
RUN node -v

# Verify npm version
RUN npm -v

# Install npm dependencies (after Node.js is installed)
WORKDIR /var/www/html
COPY package.json package-lock.json ./
RUN npm install
