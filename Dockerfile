FROM richarvey/nginx-php-fpm:3.1.6

RUN apk add --no-cache nodejs-current npm

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV WEBROOT /var/www/html/public
ENV SKIP_CHOWN 0

COPY . .

# Sobrescribimos CUALQUIER configuración de Nginx con la nuestra
COPY .docker/nginx.conf /etc/nginx/http.d/default.conf
COPY .docker/nginx.conf /etc/nginx/sites-available/default.conf

RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install --force && npm run build

RUN echo "#!/bin/sh" > /entrypoint.sh && \
    echo "php /var/www/html/artisan config:clear" >> /entrypoint.sh && \
    echo "php /var/www/html/artisan route:clear" >> /entrypoint.sh && \
    echo "php /var/www/html/artisan migrate --force" >> /entrypoint.sh && \
    echo "exec /start.sh" >> /entrypoint.sh && \
    chmod +x /entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]