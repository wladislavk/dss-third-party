FROM debian:9.3

# Directories for custom php and httpd packages
ENV _RH_HTTPD=/etc/apache2 \
    _RH_PHP=/php/7.2
ENV _RH_PHP_D=/etc${_RH_PHP}

# Set Timezone
ENV TZ=America/New_York
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

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
        php7.2-mcrypt \
        php7.2-mysqli \
        php7.2-mysqlnd \
        php7.2-pdo \
        php7.2-tcpdf \
        php7.2-tidy \
        php7.2-xml \
        phpunit \
    # PDFtk
    && curl -sSLo pdftk-2.02-1.el6.x86_64.rpm https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/pdftk-2.02-1.el6.x86_64.rpm \
    && alien pdftk-2.02-1.el6.x86_64.rpm \
    && dpkg -i pdftk_2.02-2_amd64.deb \
    # NewRelic
    && curl -sSLo newrelic-agent.tar.gz https://download.newrelic.com/php_agent/release/newrelic-php5-7.7.0.203-linux.tar.gz \
    && tar -xvzf newrelic-agent.tar.gz \
    && cd newrelic-php5-7.7.0.203-linux \
    && chmod u+x newrelic-install \
    && export NR_INSTALL_SILENT=1 \
    && ./newrelic-install install \
    # Composer
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer \
    # PHPUnit
    && mkdir -p /opt/tmp && cd /opt/tmp \
    # Get keys Sebastian Bergmann <sb@sebastian-bergmann.de> GPG key to validate signature
    && export GPG_KEYS=D8406D0D82947747293778314AA394086372C20A \
    # Fallback servers in case one of them is down
    && ( gpg --keyserver ha.pool.sks-keyservers.net --recv-keys "$GPG_KEYS" \
      || gpg --keyserver pgp.mit.edu --recv-keys "$GPG_KEYS" \
      || gpg --keyserver keyserver.pgp.com --recv-keys "$GPG_KEYS" ) \
    && gpg --fingerprint "$GPG_KEYS" \
    # Download phpunit and its signature
    && export PHPUNIT_VERSION=7.0 \
    && curl -sSLo phpunit.phar https://phar.phpunit.de/phpunit-${PHPUNIT_VERSION}.phar \
    && curl -sSLo phpunit.phar.asc https://phar.phpunit.de/phpunit-${PHPUNIT_VERSION}.phar.asc \
    && ls -la \
    # Validate
    && gpg --verify phpunit.phar.asc phpunit.phar \
    # Install and cleanup
    && mv phpunit.phar /usr/local/bin/phpunit && chmod +x /usr/local/bin/phpunit \
    && rm -rf /opt/tmp

RUN set -xe \
    # Customize php setup
    && /bin/echo 'short_open_tag=On\ndate.timezone="America/New_York"' > "${_RH_PHP_D}/mods-available/custom.ini" \
    && ln -s "${_RH_PHP_D}/mods-available/custom.ini" "${_RH_PHP_D}/apache2/conf.d/40-custom.ini"

ENV \
    # Environment variable to use in derived images to find exact paths
    ETC_HTTPD=/etc/apache2 \
    DOCUMENT_ROOT=/var/www/html \
    PHP_PATH=/usr/bin/php

ENV API_PATH=${DOCUMENT_ROOT}/api
WORKDIR $API_PATH

# Copy composer manifest before the rest source codes. To be able to install
# all requirements and cache this build step. Use --no-autoloader --no-scripts
# because there is no app source code yet.
COPY composer* $API_PATH/
RUN composer install --no-autoloader --no-scripts

# Copy the project's source code.
COPY . $API_PATH
RUN set -x \
    # Do composer install again to apply autoloader and scripts sections.
    && composer install \
    # Fix permissions
    && chown -R www-data ${DOCUMENT_ROOT}

# Apache config to serve application
# Overwrite default vhost
RUN /bin/echo -e '\
ErrorLog "/dev/stderr"\n\
CustomLog "/dev/stdout" common\n\
<VirtualHost *:80>\n\
    DocumentRoot "${API_PATH}/public"\n\
    <Directory "${API_PATH}/public">\n\
        AllowOverride All\n\
    </Directory>\n\
</VirtualHost>\n\
' > ${ETC_HTTPD}/sites-available/000-default.conf

# Create entrypoint script, make it executable
# Execute with apachectl to set the proper ENV variables
RUN /bin/echo -e "#!/bin/bash\n\
apache2 -v\n\
exec apachectl -D FOREGROUND\n\
" > /usr/sbin/docker-entrypoint.sh \
    && chmod +x /usr/sbin/docker-entrypoint.sh

CMD /usr/sbin/docker-entrypoint.sh
