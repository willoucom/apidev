FROM php:7-apache-buster

ENV TZ=Europe/Paris

# Install packages
RUN \
    apt-get update \
    && apt-get install -y \
        unzip \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Install apache configuration
COPY apache/web.conf /etc/apache2/conf-enabled/

# Install app

COPY . /var/www/html