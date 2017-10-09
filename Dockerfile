FROM node:7.10-alpine

RUN apk update \
  && apk add \
    chromium \
    ttf-dejavu \
    xpra \
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
