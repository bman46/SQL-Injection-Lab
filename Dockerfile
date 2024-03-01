# Use an official PHP runtime as a parent image
FROM php:apache-bullseye

# Set the working directory in the container
WORKDIR /var/www/html

# Install PHP extensions and other dependencies
RUN apt-get update && \
    apt-get install -y libpng-dev curl && \
    docker-php-ext-install pdo pdo_mysql gd
RUN docker-php-ext-install mysqli

WORKDIR /var/www/html
# Copy your PHP application code into the container
COPY base/ ./

RUN mkdir -p /mods
COPY mods/ /mods/
COPY entry.sh /

# SQL Vars
ARG SQL_SERVER_TMP=SQL_SERVER
ENV SQL_SERVER=$SQL_SERVER_TMP

ARG SQL_USERNAME_TMP=SQL_USERNAME
ENV SQL_USERNAME=$SQL_USERNAME_TMP

ARG SQL_PASSWORD_TMP=SQL_PASSWORD
ENV SQL_PASSWORD=$SQL_PASSWORD_TMP

ARG SQL_DB_TMP=SQL_DB
ENV SQL_DB=$SQL_DB_TMP

ARG VERSION_TMP=VERSION
ENV VERSION=$VERSION_TMP

# Expose the port Apache listens on
EXPOSE 80

# Start Apache when the container runs
ENTRYPOINT ["/bin/bash", "/entry.sh"]