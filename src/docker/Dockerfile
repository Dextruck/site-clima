# Use a imagem PHP com Apache como base
FROM php:8.0-apache

# Instale o driver PDO para PostgreSQL
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql
