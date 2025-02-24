FROM php:8.1.13-fpm-alpine

ENV PHPIZE_DEPS \
            autoconf \
            dpkg-dev dpkg \
            file \
            g++ \
            gcc \
            git \
            libc-dev \
            linux-headers \
            make \
            pcre-dev \
            pkgconf \
            re2c \
            openssl-dev \
            icu-dev \
            gettext \
            gettext-dev

RUN apk add --update openssl gmp-dev lz4-dev lz4-libs icu-dev icu-data-full

RUN apk add --no-cache --virtual .phpize-deps-configure $PHPIZE_DEPS \
    && pecl install igbinary \
    && pecl install xdebug-3.2.0 \
    && docker-php-ext-enable igbinary \
    && docker-php-ext-enable xdebug \
    && pecl bundle redis \
    && cd redis \
    && phpize \
    && ./configure --enable-redis-igbinary \
    && make \
    && make install \
    && docker-php-ext-enable redis \
    && cd /tmp \
    && git clone --recursive --depth=1 https://github.com/kjdev/php-ext-lz4.git \
    && cd php-ext-lz4 \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && rm -rf php-ext-lz4 \
    && docker-php-ext-enable lz4 \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apk del .phpize-deps-configure

# Misc
RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-configure intl \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo_mysql mysqli \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gmp \
    && docker-php-ext-enable opcache \
    && docker-php-ext-install gettext \
    && docker-php-ext-configure gettext \
    && docker-php-ext-enable gettext \
    gettext

RUN apk add imagemagick && \
    apk add --no-cache imagemagick-dev; \
    pecl install imagick; \
    docker-php-ext-enable imagick;

RUN docker-php-ext-install sockets \
    && docker-php-ext-enable sockets

# Requirements for Mailhog
RUN apk add --no-cache git make musl-dev go

# Configure Go
ENV GOROOT /usr/lib/go
ENV GOPATH /go
ENV PATH /go/bin:$PATH

RUN mkdir -p ${GOPATH}/src ${GOPATH}/bin

#RUN go install github.com/mailhog/mhsendmail@latest
##RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail
#RUN echo 'sendmail_path = /root/go/bin/mhsendmail --smtp-addr mailhog:1025' > /usr/local/etc/php/php.ini

#RUN echo http://dl-cdn.alpinelinux.org/alpine/edge/main >> /etc/apk/repositories \
#    && echo http://dl-cdn.alpinelinux.org/alpine/edge/community >> /etc/apk/repositories \
#    && echo http://dl-cdn.alpinelinux.org/alpine/edge/testing >> /etc/apk/repositories \
#    && apk update \
#    && apk add --no-cache autoconf gearman-dev gearman-libs \
#    && pecl install gearman  \
#    && docker-php-ext-enable gearman

WORKDIR /var/thinkhuge/

# Installing composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

RUN chown www-data:www-data /var/thinkhuge

EXPOSE 9000
CMD ["php-fpm"]

