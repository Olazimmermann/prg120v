FROM php:8.2-apache

# Installer støtte for PDO og MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Sett arbeidsmappe og kopier alt inn
WORKDIR /var/www/html
COPY . /var/www/html

# Åpne port 80 (vanlig for nettsider)
EXPOSE 80

