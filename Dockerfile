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
        nodejs \
        fontconfig

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer
