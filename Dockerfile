FROM php:7.4-apache
WORKDIR /var/www/html

COPY . /var/www/html/
COPY docker_file/waweb.conf /etc/apache2/sites-available/

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip\
    nano\
    zlib1g-dev
    # libpng-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN a2enmod rewrite
RUN docker-php-ext-install exif pdo_mysql
# RUN docker-php-ext-install gd pdo_mysql
RUN chmod -R 777 /var/www/html/storage
RUN a2dissite 000-default.conf
RUN a2ensite waweb
RUN cd /var/www/html && php artisan storage:link
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
RUN service apache2 restart



# https://www.appsloveworld.com/laravel/100/6/call-to-undefined-function-intervention-image-gd-imagecreatefromjpeg-larav?expand_article=1
