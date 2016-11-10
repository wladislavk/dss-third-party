FROM ds3-base

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
RUN set -x \
    # Do composer install again to apply autoloader and scripts sections.
    && source /opt/rh/rh-php56/enable \
    && composer install \
    # Fix permissions
    && chown apache storage/logs

# Copy custom apache configs for the project
COPY etc/httpd/ ${ETC_HTTPD}
