#php-fpm
FROM php:7.1.13-fpm
MAINTAINER Aleksandr Sobakar <xaosaki@gmail.com>

RUN apt-get update && apt-get install -y mysql-client
RUN docker-php-ext-install pdo_mysql pdo mysqli