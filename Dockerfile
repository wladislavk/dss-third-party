FROM node:7.10-alpine

RUN set -x \
  && sed -i 's,v[0-9]\.[0-9],v3.6,g' /etc/apk/repositories \
  && apk update \
  && apk upgrade \
  && apk add \
    bash \
    chromium \
    ttf-dejavu \
    xpra \
    make \
  && rm -rf /var/cache/apk/*

ARG APP_DIR=/opt/app
RUN mkdir -p $APP_DIR
WORKDIR $APP_DIR

ARG NODE_ENV=development
ENV NODE_ENV $NODE_ENV

COPY package.json $APP_DIR
RUN yarn
COPY . $APP_DIR

CMD [ "yarn", "run", "dev" ]
