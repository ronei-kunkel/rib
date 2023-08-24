FROM php:8.2-fpm

# setup user as root
USER root

WORKDIR /var/www/rib

# # setup node js source will be used later to install node js
# RUN curl -sL https://deb.nodesource.com/setup_16.x -o nodesource_setup.sh
# RUN ["sh",  "./nodesource_setup.sh"]

# Install environment dependencies
RUN apt-get update \
  && apt-get install -y \
    build-essential \
    openssl \
    nginx \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    zlib1g-dev \
    libzip-dev \
    gcc \
    g++ \
    make \
    vim \
    unzip \
    curl \
    git \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    locales \
    libonig-dev \
    # nodejs \
  && apt-get install -y --no-install-recommends \
    libgmp-dev \
  && apt-get autoclean -y \
  && rm -rf /var/lib/apt/lists/* \
  && rm -rf /tmp/pear/

RUN docker-php-ext-enable opcache
RUN docker-php-ext-configure gd

RUN docker-php-ext-install -j$(nproc) \
  opcache \
  gd \
  gmp \
  pdo_mysql \
  mbstring \
  pdo \
  exif \
  sockets \
  sodium \
  apcu \
  bz2 \
  intl \
  pcntl \
  bcmath \
  zip

# Copy files
COPY . /var/www/rib

COPY ./.docker/php/prod.ini /usr/local/etc/php/local.ini

COPY ./.docker/nginx/prod.conf /etc/nginx/nginx.conf

# RUN chmod +rwx /var/www/rib

# RUN chmod -R 777 /var/www/rib

RUN chgrp -R www-data storage && chgrp -R www-data bootstrap/cache
# RUN chmod 777 ca.pem

# setup FE
# RUN npm install

# RUN npm rebuild node-sass

# RUN npm run prod

# setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer update --working-dir="/var/www/rib" && composer dump-autoload --working-dir="/var/www/rib"

# RUN php artisan optimize && \
# php artisan route:clear && \
# php artisan route:cache && \
# php artisan config:clear && \
# php artisan config:cache && \
# php artisan view:clear && \
# php artisan view:cache

# remove this line if you do not want to run migrations on each build
# RUN php artisan migrate --force

EXPOSE 80

RUN ["chmod", "+x", "post_deploy.sh"]

CMD [ "sh", "./post_deploy.sh" ]