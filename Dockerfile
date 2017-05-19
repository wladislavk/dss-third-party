FROM centos:6.7

# Directories for custom php and httpd packages
ENV _RH_HTTPD=/opt/rh/httpd24 \
    _RH_PHP=/opt/rh/rh-php56

RUN set -xe \
    yum update -y \

    # Install EPEL and SCL repos
    && yum --enablerepo=extras install -y \
        epel-release \
        centos-release-scl \

    # Install php 5.6 and httpd 2.4 using SCL repo.
    && yum --enablerepo=centos-sclo-rh install -y \
        httpd24 \
        rh-php56 \
        rh-php56-php \
        rh-php56-php-bcmath \
        rh-php56-php-cli \
        rh-php56-php-common \
        rh-php56-php-gd \
        rh-php56-php-mbstring \
        rh-php56-php-mysqlnd \
        rh-php56-php-opcache \
        rh-php56-php-pdo \
        rh-php56-php-process \
        rh-php56-php-tidy \
        rh-php56-php-xml \

    # Install mcrypt from php56more by Remi Collet, because CentsOS-SCL doesn't
    # have this library in their repo. Here is answer why this happened:
    # http://stackoverflow.com/a/34824192/456517
    && rpm -Uvh https://www.softwarecollections.org/en/scls/remi/php56more/epel-6-x86_64/download/remi-php56more-epel-6-x86_64.noarch.rpm \
    && yum --enablerepo=epel,remi-php56more-epel-6-x86_64 install -y \
        more-php56-php-mcrypt \

    # Install TCPDF from EPEL repo.
    && yum --enablerepo=epel install -y \
        php-tcpdf \
        php-tcpdf-dejavu-sans-fonts \
    # Fix include path to add standard php include path, because of TCPDF which
    # is based on default php shipped with os. It would be better to install it
    # using Composer.
    && echo "include_path = '.:${_RH_PHP}/root/usr/share/pear:${_RH_PHP}/root/usr/share/php:/usr/share/pear:/usr/share/php'" \
        > "${_RH_PHP}/includepath.ini" \
    # Install PDFtk from PDF Labs repos. It requires libgcj to be installed.
    && yum install -y libgcj \
    && rpm -Uvh https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/pdftk-2.02-1.el6.x86_64.rpm \

    # NewRelic
    && rpm -Uvh https://yum.newrelic.com/pub/newrelic/el5/x86_64/newrelic-repo-5-3.noarch.rpm \
        && yum --enablerepo=newrelic install -y newrelic-php5 \

    # Other dependencies
    && yum install -y ghostscript \

    # Instal composer using php 5.6
    && source ${_RH_PHP}/enable \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer \

    # Customize php setup
    && echo 'short_open_tag = On' > "${_PHP_D}/custom.ini"


ENV \
    # Set variables exactly as in /opt/rh/rh-php56/enable, to do not source manually
    PATH=${_RH_PHP}/root/usr/bin:${_RH_PHP}/root/usr/sbin${PATH:+:${PATH}} \
    LD_LIBRARY_PATH=${_RH_PHP}/root/usr/lib64${LD_LIBRARY_PATH:+:${LD_LIBRARY_PATH}} \
    MANPATH=${_RH_PHP}/root/usr/share/man:${MANPATH} \

    # Environment variable to use in derived images to find exact paths
    ETC_HTTPD=${_RH_HTTPD}/root/etc/httpd \
    DOCUMENT_ROOT=/opt/rh/httpd24/root/var/www/html \
    PHP_PATH=/opt/rh/rh-php56/root/bin/php

# Create entrypoint script, make it executable
RUN echo -e "#!/bin/bash\n\
. ${_RH_HTTPD}/enable\n\
httpd -v\n\
exec httpd -D FOREGROUND\n\
" > /usr/sbin/docker-entrypoint.sh \
    && chmod +x /usr/sbin/docker-entrypoint.sh

CMD /usr/sbin/docker-entrypoint.sh
