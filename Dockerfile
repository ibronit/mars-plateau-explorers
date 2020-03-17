FROM php:7.4-cli-alpine

COPY . /usr/src/mars-plateau-explorer

WORKDIR /usr/src/mars-plateau-explorer

CMD ["php", "bin/console", "app:explore-mars-plateau"]