#FROM ubuntu:latest
FROM php:8.2-apache
#LABEL authors="daizygod"
RUN docker-php-ext-install \
    pdo_mysql \
    && a2enmod \
    rewrite
#ENTRYPOINT ["top", "-b"]