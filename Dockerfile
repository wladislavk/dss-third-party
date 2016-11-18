FROM ds3-base

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

# Copy custom apache configs for the project
COPY etc/httpd/ ${ETC_HTTPD}
