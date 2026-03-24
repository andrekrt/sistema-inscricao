FROM webdevops/php-nginx:8.2-alpine

ENV WEB_DOCUMENT_ROOT=/app/public

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

RUN if [ -f package.json ]; then npm install && npm run build; fi

RUN chown -R application:application /app/storage /app/bootstrap/cache || true
