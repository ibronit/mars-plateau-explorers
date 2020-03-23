FROM php:7.4-cli-alpine

COPY . /usr/src/mars-plateau-explorer

WORKDIR /usr/src/mars-plateau-explorer

CMD ["tail", "-f", "/dev/null"]