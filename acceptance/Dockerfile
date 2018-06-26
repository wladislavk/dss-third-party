FROM centos:7.3.1611

WORKDIR /opt/app/acceptance

# Set Timezone
ENV TZ=$SYSTEM_TZ
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm \
    && rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

RUN set -xe \
    yum update -y \
    && yum install -y \
        php72w-fpm \
        php72w-opcache \
        php72w-cli \
        php72w-mbstring \
        php72w-xml \
        php72w-pdo \
        php72w-mysql \
        fontconfig \
        wget \
        mesa-libOSMesa-devel \
        gnu-free-sans-fonts \
        https://dl.google.com/linux/direct/google-chrome-stable_current_x86_64.rpm

RUN rpm -ivh https://kojipkgs.fedoraproject.org//packages/http-parser/2.7.1/3.el7/x86_64/http-parser-2.7.1-3.el7.x86_64.rpm

RUN curl -sL https://rpm.nodesource.com/setup_7.x | bash - && yum install -y nodejs

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

RUN wget http://dev.mysql.com/get/mysql57-community-release-el7-11.noarch.rpm

RUN yum localinstall -y mysql57-community-release-el7-11.noarch.rpm

RUN yum install -y mysql-community-client

COPY composer.json ./
COPY composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . ./
RUN composer install
