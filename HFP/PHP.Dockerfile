FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    gnupg2 curl ca-certificates unzip git zip \
    unixodbc unixodbc-dev apt-transport-https software-properties-common \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /app

# Install dependencies
COPY app/composer.json app/composer.lock ./
RUN composer install

# Copy full app
COPY app/ .

EXPOSE 9000
