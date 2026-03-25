FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring bcmath exif pcntl zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /app

RUN composer install --no-dev --optimize-autoloader --no-interaction || true
RUN if [ -f package.json ]; then npm install && npm run build; fi

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
