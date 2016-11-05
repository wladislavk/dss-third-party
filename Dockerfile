FROM centos:6.6
RUN yum update -y

RUN export BUILD_DIR=/tmp/build && mkdir -p $BUILD_DIR && cd $BUILD_DIR \
    && curl -sSo epel-release-6-8.noarch.rpm http://dl.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm  \
    && curl -sSo remi-release-6.rpm http://rpms.famillecollet.com/enterprise/remi-release-6.rpm \
    && rpm -Uvh remi-release-6*.rpm epel-release-6*.rpm

RUN echo 'Enable remi repositories for php 5.6' \
    && cat /etc/yum.repos.d/remi.repo | tr '\n' '\0' | \
        sed -e 's/^.*\(\[remi\][^[]*\)enabled=0\([^[]*\).*$/\1enabled=1\2/g' \
            | tr '\0' '\n' >> /etc/yum.repos.d/remi-enabled.repo \
    && cat /etc/yum.repos.d/remi.repo | tr '\n' '\0' | \
        sed -e 's/^.*\(\[remi-php56\][^[]*\)enabled=0\([^[]*\).*$/\1enabled=1\2/g' \
            | tr '\0' '\n' >> /etc/yum.repos.d/remi-enabled.repo \
    && cat /etc/yum.repos.d/remi-enabled.repo

RUN yum install -y \
    httpd \
    php \
    php-gd \
    php-mcrypt \
    php-mbstring \
    php-xml \
    php-pdo \
    php-mysql \
    php-mysqli \
    php-tidy

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer
