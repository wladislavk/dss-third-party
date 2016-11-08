FROM centos:6.7

ARG ETC_HTTPD=/opt/rh/httpd24/root/etc/httpd
RUN yum update -y \
    # Install php 5.6 and httpd 2.4 using SCL repo.
    && yum --enablerepo=extras install -y centos-release-scl \
    && yum --enablerepo=centos-sclo-rh install -y \
        httpd24 \
        httpd24-mod_ssl \
        rh-php56 \
        rh-php56-php \
        rh-php56-php-gd \
        rh-php56-php-mcrypt \
        rh-php56-php-mbstring \
        rh-php56-php-xml \
        rh-php56-php-pdo \
        rh-php56-php-mysql \
        rh-php56-php-mysqli \
        rh-php56-php-tidy \

    # Remove default httpd configs and create TLS sertificates.
    && rm -f ${ETC_HTTPD}/conf.d/{autoindex,userdir,welcome}.conf \
    && mkdir ${ETC_HTTPD}/ssl \
    && openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout ${ETC_HTTPD}/ssl/tls.key \
        -out ${ETC_HTTPD}/ssl/tls.crt \
        -subj "/C=US" \
    && echo "s:$\(SSLCertificateKeyFile\).*$:\1 ${ETC_HTTPD}/ssl/tls.key:" \
    && sed -i \
        -e "s:$\(SSLCertificateKeyFile\).*$:\1 ${ETC_HTTPD}/ssl/tls.key:" \
        -e "s:$\(SSLCertificateFile\).*$:\1 ${ETC_HTTPD}/ssl/tls.crt:" \
            ${ETC_HTTPD}/conf.d/ssl.conf \

    # Install TCPDF from EPEL repo.
    && yum --enablerepo=extras install -y epel-release \
    && yum --enablerepo=epel install -y \
        php-tcpdf \
        php-tcpdf-dejavu-sans-fonts \
    # Fix include path to add standard php include path, because of TCPDF which
    # is based on default php shipped with os. It would be better to install it
    # using Composer.
    && echo "include_path = '.:/opt/rh/rh-php56/root/usr/share/pear:/opt/rh/rh-php56/root/usr/share/php:/usr/share/pear:/usr/share/php'" \
        > /etc/opt/rh/rh-php56/php.d/includepath.ini \
    # Install PDFtk from PDF Labs repos. It requires libgcj to be installed.
    && yum install -y libgcj \
    && rpm -Uvh https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/pdftk-2.02-1.el6.x86_64.rpm \

    # NewRelic
    && rpm -Uvh https://yum.newrelic.com/pub/newrelic/el5/x86_64/newrelic-repo-5-3.noarch.rpm \
        && yum --enablerepo=newrelic install -y newrelic-php5 \

    # Other dependencies
    && yum install -y ghostscript \

    # Instal composer using php 5.6
    && source /opt/rh/rh-php56/enable \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer

ARG PROJECT_DIR=/var/www/html/api/
WORKDIR $PROJECT_DIR

# Copy composer manifest before the rest source codes. To be able to install
# all requirements and cache this build step. Use --no-autoloader --no-scripts
# because there is no app source code yet.
COPY composer* $PROJECT_DIR
RUN source /opt/rh/rh-php56/enable \
    && composer install --no-autoloader --no-scripts

# Copy the project's source code.
COPY . $PROJECT_DIR
# Do composer install again to apply autoloader and scripts sections.
RUN source /opt/rh/rh-php56/enable \
    && composer install

# Copy custom apache configs for the project
COPY etc/httpd/ ${ETC_HTTPD}

CMD ["/opt/rh/httpd24/root/usr/sbin/httpd", "-D", "FOREGROUND"]
