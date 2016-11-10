#!/bin/bash -xe

. /opt/rh/httpd24/enable

# Remove default ssl host configuration
export HTTPD_SSL_CONF=${ETC_HTTPD}/conf.d/ssl.conf
if [ -f $HTTPD_SSL_CONF ]; then
    cat $HTTPD_SSL_CONF | tr '\n' '\0' | \
        sed 's:<VirtualHost.*</VirtualHost>::' | tr '\0' '\n' \
            > /tmp/ssl.conf
    mv /tmp/ssl.conf $HTTPD_SSL_CONF
fi

mkdir -p ${ETC_HTTPD}/ssl

# Create self-signed certificates for the domain we are going to serve
export HTTPD_SERVER_NAME=${HTTPD_SERVER_NAME:-localhost}
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout ${ETC_HTTPD}/ssl/${HTTPD_SERVER_NAME}.key \
    -out ${ETC_HTTPD}/ssl/${HTTPD_SERVER_NAME}.crt \
    -subj "/C=US/CN=${HTTPD_SERVER_NAME}"

httpd -v
exec httpd -D FOREGROUND
