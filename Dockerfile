FROM richarvey/nginx-php-fpm:3.1.6

# Instalamos Node.js 22 (versión actual) para cumplir con los requisitos de Vite
RUN apk add --no-cache nodejs-current npm

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV WEBROOT /var/www/html/public

COPY . .

# Instalamos dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Instalamos dependencias de JS y compilamos assets
# Usamos --force para evitar conflictos con Tailwind Oxide
RUN npm install --force && npm run build

# Script de inicio: limpia configuración vieja y ejecuta migraciones
RUN echo "#!/bin/sh" > /entrypoint.sh && \
    echo "php /var/www/html/artisan config:clear" >> /entrypoint.sh && \
    echo "php /var/www/html/artisan migrate --force" >> /entrypoint.sh && \
    echo "exec /start.sh" >> /entrypoint.sh && \
    chmod +x /entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]