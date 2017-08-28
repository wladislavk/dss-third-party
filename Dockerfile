FROM centos:7.3.1611

RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm \
    && rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

RUN set -xe \
    yum update -y \
    && yum install -y \
        php71w-fpm \
        php71w-opcache \
        php71w-cli \
        php71w-mbstring \
        php71w-xml \
        php71w-pdo \
        php71w-mysql \
        fontconfig \
        wget

RUN rpm -ivh https://kojipkgs.fedoraproject.org//packages/http-parser/2.7.1/3.el7/x86_64/http-parser-2.7.1-3.el7.x86_64.rpm && yum -y install nodejs

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

RUN wget http://dev.mysql.com/get/mysql57-community-release-el7-11.noarch.rpm

RUN yum localinstall -y mysql57-community-release-el7-11.noarch.rpm

RUN yum install -y mysql-community-client
