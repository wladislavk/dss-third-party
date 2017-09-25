FROM node:7.10-alpine

RUN apk update && \
    apk upgrade && \
    apk add bash

ARG APP_DIR=/opt/app
RUN mkdir -p $APP_DIR
WORKDIR $APP_DIR

ARG NODE_ENV=development
ENV NODE_ENV $NODE_ENV

COPY package.json $APP_DIR
RUN yarn
COPY . $APP_DIR

CMD [ "yarn", "run", "dev" ]
