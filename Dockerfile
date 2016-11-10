FROM centos:6.7

ENV ETC_HTTPD=/opt/rh/httpd24/root/etc/httpd
RUN set -xe \
    yum update -y \

    # Install EPEL and SCL repos
    && yum --enablerepo=extras install -y \
        epel-release \
        centos-release-scl \

    # Install php 5.6 and httpd 2.4 using SCL repo.
    && yum --enablerepo=centos-sclo-rh install -y \
        httpd24 \
        httpd24-mod_ssl \
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
    # heve this library in their repo. Here is answer why this happened:
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
    && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer \

    # Remove default httpd configs
    && rm -f ${ETC_HTTPD}/conf.d/{autoindex,userdir,welcome}.conf

COPY docker-entrypoint.sh /usr/sbin/
CMD /usr/sbin/docker-entrypoint.sh
