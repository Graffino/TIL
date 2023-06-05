FROM postgres:14.1-alpine

RUN apk add vim
RUN apk add mc

WORKDIR /var/lib/postgresql

EXPOSE ${DOCKER_POSTGRES_PORT}

VOLUME ["/var/lib/postgres"]

