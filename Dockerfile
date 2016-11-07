FROM centos:6.6
RUN yum update -y

RUN yum --enablerepo=extras install -y centos-release-scl

RUN yum install -y \
    httpd24 \
    rh-php56 \
    rh-php56-php \
    rh-php56-php-gd \
    rh-php56-php-mcrypt \
    rh-php56-php-mbstring \
    rh-php56-php-xml \
    rh-php56-php-pdo \
    rh-php56-php-mysql \
    rh-php56-php-mysqli \
    rh-php56-php-tidy

RUN source /opt/rh/rh-php56/enable \
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

# Remove default apache configs
RUN rm -f /opt/rh/httpd24/root/etc/httpd/conf.d/{autoindex,userdir,welcome}.conf
# Copy custom apache configs for the project
COPY etc/httpd/ /opt/rh/httpd24/root/etc/httpd/

CMD ["/opt/rh/httpd24/root/usr/sbin/httpd", "-D", "FOREGROUND"]
