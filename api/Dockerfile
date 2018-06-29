FROM debian:9.3

ARG SYSTEM_TZ

# Directories for custom php and httpd packages
ENV _RH_HTTPD=/etc/apache2 \
    _RH_PHP=/php/7.2
ENV _RH_PHP_D=/etc${_RH_PHP}

ENV SYSTEM_TZ_ENV=$SYSTEM_TZ

# Set Timezone
RUN ln -snf /usr/share/zoneinfo/$SYSTEM_TZ /etc/localtime && echo $SYSTEM_TZ > /etc/timezone

RUN set -xe \
    && apt-get update

RUN set -xe \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get update \
    && apt-get -y install \
        apt-utils \
        apache2 \
        apt-transport-https \
        lsb-release \
        ca-certificates \
        curl \
        zip \
        unzip \
        alien \
        libgcj-common \
        ghostscript \
        wget \
    && wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list \
    && apt-get update \
    && apt-get -y install \
        php7.2 \
        php7.2-bcmath \
        php7.2-common \
        php7.2-dom \
        php7.2-gd \
        php7.2-mbstring \
        php7.2-mysqli \
        php7.2-mysqlnd \
        php7.2-pdo \
        php7.2-tidy \
        php7.2-xml \
        libapache2-mod-php7.2 \
    && apt-get -y upgrade \
    # PDFtk
    && curl -sSLo pdftk-2.02-1.el6.x86_64.rpm https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/pdftk-2.02-1.el6.x86_64.rpm \
    && alien pdftk-2.02-1.el6.x86_64.rpm \
    && dpkg -i pdftk_2.02-2_amd64.deb \
    # Composer
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer

# PHPUnit
RUN set -xe \
    && mkdir -p /opt/tmp && cd /opt/tmp \
    # Get keys Sebastian Bergmann <sb@sebastian-bergmann.de> GPG key to validate signature
    # Fallback servers in case one of them is down
    && gpg --keyserver ha.pool.sks-keyservers.net --recv-keys D8406D0D82947747293778314AA394086372C20A \
    #  || gpg --keyserver pgp.mit.edu --recv-keys "$GPG_KEYS" \
    #  || gpg --keyserver keyserver.pgp.com --recv-keys "$GPG_KEYS" ) \
    && gpg --fingerprint D8406D0D82947747293778314AA394086372C20A \
    # Download phpunit and its signature
    && export PHPUNIT_VERSION=6.5 \
    && curl -sSLo phpunit.phar https://phar.phpunit.de/phpunit-${PHPUNIT_VERSION}.phar \
    && curl -sSLo phpunit.phar.asc https://phar.phpunit.de/phpunit-${PHPUNIT_VERSION}.phar.asc \
    && ls -la \
    # Validate
    && gpg --verify phpunit.phar.asc phpunit.phar \
    # Install and cleanup
    && mv phpunit.phar /usr/local/bin/phpunit && chmod +x /usr/local/bin/phpunit \
    && rm -rf /opt/tmp

# Customize php setup
RUN set -xe \
    && /bin/echo 'date.timezone="${SYSTEM_TZ_ENV}"' > "${_RH_PHP_D}/mods-available/custom.ini" \
    && ln -s "${_RH_PHP_D}/mods-available/custom.ini" "${_RH_PHP_D}/apache2/conf.d/40-custom.ini"

ENV \
    # Environment variable to use in derived images to find exact paths
    ETC_HTTPD=/etc/apache2 \
    DOCUMENT_ROOT=/var/www/html \
    PHP_PATH=/usr/bin/php

WORKDIR $DOCUMENT_ROOT

COPY composer.json ./
COPY composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . ./
RUN composer install --no-scripts

RUN set -x && chown -R www-data ${DOCUMENT_ROOT} && chmod -R 0777 ${DOCUMENT_ROOT}/storage/logs

# Apache config to serve application
# Overwrite default vhost
RUN /bin/echo -e '\
ErrorLog "/dev/stderr"\n\
CustomLog "/dev/stdout" common\n\
<VirtualHost *:80>\n\
    DocumentRoot "${DOCUMENT_ROOT}/public"\n\
    <Directory "${DOCUMENT_ROOT}/public">\n\
        AllowOverride All\n\
    </Directory>\n\
</VirtualHost>\n\
' > ${ETC_HTTPD}/sites-available/000-default.conf

RUN a2enmod rewrite

# Create entrypoint script, make it executable
# Execute with apachectl to set the proper ENV variables
RUN /bin/echo -e "#!/bin/bash\n\
apache2 -v\n\
exec apachectl -D FOREGROUND\n\
" > /usr/sbin/docker-entrypoint.sh \
    && chmod +x /usr/sbin/docker-entrypoint.sh

CMD /usr/sbin/docker-entrypoint.sh
