FROM php:8.2-apache-buster

# Opcache env variables.
ENV OPCACHE_REVALIDATE_FREQ=10
ENV OPCACHE_VALIDATE_TIMESTAMP=1

# install the PHP extensions we need
RUN set -eux; \
	\
	if command -v a2enmod; then \
		a2enmod rewrite; \
	fi; \
	\
	savedAptMark="$(apt-mark showmanual)"; \
	\
	apt-get update; \
	apt-get install -y --no-install-recommends \
		libfreetype6-dev \
		libjpeg-dev \
		libpng-dev \
		libpq-dev \
		libzip-dev \
		curl \
    libz-dev \
    libmemcached-dev \
	; \
	\
	docker-php-ext-configure gd \
		--with-freetype \
		--with-jpeg=/usr \
	; \
	\
	docker-php-ext-install -j "$(nproc)" \
		gd \
		opcache \
		mysqli \
		pdo_mysql \
		pdo \
		pdo_pgsql \
		zip \
	; \
	\
	pecl install memcached  \
	; \
	\
  docker-php-ext-enable memcached \
	; \
	\
\
# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
	apt-mark auto '.*' > /dev/null; \
	apt-mark manual $savedAptMark; \
	ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
		| awk '/=>/ { print $3 }' \
		| sort -u \
		| xargs -r dpkg-query -S \
		| cut -d: -f1 \
		| sort -u \
		| xargs -rt apt-mark manual; \
	\
	apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
	rm -rf /var/lib/apt/lists/*

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=4000'; \
        echo 'opcache.revalidate_freq='${OPCACHE_REVALIDATE_FREQ}; \
        echo 'opcache.fast_shutdown=1'; \
#       echo 'opcache.validate_timestamps='${OPCACHE_VALIDATE_TIMESTAMP}; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Increase upload size.
RUN echo "file_uploads = On\n" \
         "upload_max_filesize = 100M\n" \
         "post_max_size = 100M\n" \
         "max_execution_time = 600\n" \
         > /usr/local/etc/php/conf.d/uploads.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/


# VIM
RUN apt-get update && apt-get install -y vim
RUN docker-php-ext-enable mysqli

WORKDIR /var/www/html
