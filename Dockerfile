FROM 484964515519.dkr.ecr.us-east-1.amazonaws.com/baseimage

ENV API_PATH=${DOCUMENT_ROOT}/api
WORKDIR $API_PATH

# Copy composer manifest before the rest source codes. To be able to install
# all requirements and cache this build step. Use --no-autoloader --no-scripts
# because there is no app source code yet.
COPY composer* $API_PATH/
RUN source /opt/rh/rh-php56/enable \
    && composer install --no-autoloader --no-scripts

# Copy the project's source code.
COPY . $API_PATH
RUN set -x \
    # Do composer install again to apply autoloader and scripts sections.
    && source /opt/rh/rh-php56/enable \
    && composer install \
    # Fix permissions
    && chown -R apache ${DOCUMENT_ROOT}

# Apache config to serve application
# NOTE this is a tiny config, no reasons to move it to separate file
RUN echo -e '\
ErrorLog "/dev/stderr"\n\
CustomLog "/dev/stdout" common\n\
<VirtualHost *:80>\n\
    DocumentRoot "${API_PATH}/public"\n\
    <Directory "${API_PATH}/public">\n\
        AllowOverride All\n\
    </Directory>\n\
</VirtualHost>\n\
' > ${ETC_HTTPD}/conf.d/app.conf

# Install wget
RUN \
    yum update && \
    yum install -y \
    wget

# Install phpunit
RUN cd /usr/local/bin/ && \
    wget https://phar.phpunit.de/phpunit-6.1.phar && \
    mv phpunit-6.1.phar phpunit && \
    chmod 0755 phpunit
