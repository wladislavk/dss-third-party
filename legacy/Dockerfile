FROM 484964515519.dkr.ecr.us-east-1.amazonaws.com/baseimage

ARG LEGACY_DIR
ARG LOADER_DIR
ARG SYSTEM_TZ

ENV LEGACY_PATH=${DOCUMENT_ROOT}/legacy
ENV LOADER_PATH=${DOCUMENT_ROOT}/loader
ENV SHARED_PATH=${LEGACY_PATH}/../../shared
ENV FILES_PATH=${SHARED_PATH}/q_file

ENV SYSTEM_TZ_ENV=$SYSTEM_TZ

WORKDIR $LOADER_PATH

# Set Timezone
RUN ln -snf /usr/share/zoneinfo/$SYSTEM_TZ /etc/localtime && echo $SYSTEM_TZ > /etc/timezone

# Copy composer manifest before the rest source codes. To be able to install
# all requirements and cache this build step. Use --no-autoloader --no-scripts
# because there is no app source code yet.
COPY $LOADER_DIR/composer* $LOADER_PATH/
RUN set -x \
    && source /opt/rh/rh-php56/enable \
    && composer install --no-autoloader --no-scripts -d $LOADER_PATH

# Copy the project's source code.
COPY $LEGACY_DIR $LEGACY_PATH
COPY $LOADER_DIR $LOADER_PATH

RUN set -x \
    # Create shared folder
    # This step needs special treatment, as in production it will contain
    # encrypted files that MUST NOT be deleted
    && mkdir $SHARED_PATH \
    && mkdir $FILES_PATH \
    && ln -s $FILES_PATH $LEGACY_PATH/manage/letterpdfs \
    && ln -s $FILES_PATH $LEGACY_PATH/manage/upload \
    # Do composer install again to apply autoloader and scripts sections.
    && source /opt/rh/rh-php56/enable \
    && composer install -d $LOADER_PATH \
    # Fix permissions
    && chown -R apache ${DOCUMENT_ROOT} \
    && chown -R apache ${SHARED_PATH}

# Custom apache configs for the project
# NOTE this config is here so as not create extra files in the legacy codebase
RUN echo -e '\
ErrorLog "/dev/stdout"\n\
CustomLog "/dev/stdout" common\n\
<VirtualHost *:80>\n\
    DocumentRoot "${LOADER_PATH}/public"\n\
    <Directory "${LOADER_PATH}/public">\n\
        AllowOverride All\n\
    </Directory>\n\
    # Files from folder "assets" will not be aliased\n\
    AliasMatch "^/(.*\.)(css|js|map|json|bmp|cur|gif|jpg|jpeg|png|tif|swf|svg|pdf|eot|ttf|woff|xml)$" "${LEGACY_PATH}/$1$2"\n\
</VirtualHost>\n\
' > ${ETC_HTTPD}/conf.d/app.conf
