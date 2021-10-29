FROM node:16.13.0-alpine3.14
MAINTAINER pk

RUN set -eux \
	&& apk add --no-cache --virtual \
	    .build-deps \
		g++ \
		gcc \
		git \
		make

USER node:node

COPY ./.build/dev/node/docker-entrypoint.sh /usr/local/bin/docker-entrypoint

WORKDIR /var/www/app

ENTRYPOINT ["docker-entrypoint"]

CMD yarn encore ${APP_ENV} --watch