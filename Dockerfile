FROM richarvey/nginx-php-fpm:3.1.6

# Instalamos Node para Vite
RUN apk add --no-cache nodejs npm

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV WEBROOT /var/www/html/public

COPY . .

# Instalamos todo
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install && npm run build

# Script de inicio para migraciones
RUN echo "#!/bin/sh" > /entrypoint.sh && \
    echo "php /var/www/html/artisan migrate --force" >> /entrypoint.sh && \
    echo "exec /start.sh" >> /entrypoint.sh && \
    chmod +x /entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]