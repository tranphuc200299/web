FROM php:7.4-fpm

RUN apt-get update
RUN apt-get install -y libzip-dev
RUN apt-get install -y zip
RUN apt-get install -y libfreetype6-dev
RUN apt-get install -y libjpeg62-turbo-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y libzip-dev
RUN apt-get install -y libcurl4-openssl-dev
RUN apt-get install -y pkg-config
RUN apt-get install -y libssl-dev
RUN apt-get install -y libmagickwand-dev --no-install-recommends
RUN docker-php-ext-install -j$(nproc) iconv
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd
RUN pecl install imagick
RUN docker-php-ext-enable imagick

#xdebug install
#RUN pecl install xdebug-2.5.0 && docker-php-ext-enable xdebug
#RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;
#RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;
#RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;
#RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

RUN docker-php-ext-install pdo_mysql pdo mysqli zip

RUN chown -R www-data:www-data /var/www

RUN chmod -R 777 /var/www

RUN usermod -a -G www-data root

#RUN apt-get install nodejs -y

# Install composer
ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer


RUN apt-get install -y gnupg2
# Removing /var/lib/apt/lists worked
RUN rm -rf /var/lib/apt/lists/ && curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install nodejs -y
RUN npm install pm2 -g
RUN cp /usr/share/zoneinfo/Asia/Ho_Chi_Minh /etc/localtime
RUN apt-get install redis-tools -y

# Install mongodb
RUN pecl install mongodb && docker-php-ext-enable mongodb

#COPY *.sh /scripts/
#
#RUN chmod a+x /scripts/*.sh
#
#CMD ["/scripts/command.sh"]
