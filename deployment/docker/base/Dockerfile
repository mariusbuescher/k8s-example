FROM php:7.3-cli-alpine3.10

WORKDIR /opt/build
COPY ./install-composer.sh /opt/build/install-composer.sh

RUN apk add --update nodejs nodejs-npm \
    && ./install-composer.sh