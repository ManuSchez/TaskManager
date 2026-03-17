FROM richarvey/nginx-php-fpm:3.1.6

# Instalamos Node.js 22
RUN apk add --no-cache nodejs-current npm

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV WEBROOT /var/www/html/public
ENV RUN_SCRIPTS 1
# Desactivamos el SKIP_CHOWN para que la imagen intente ayudar con los permisos
ENV SKIP_CHOWN 0

COPY . .

# 1. Configuración de Nginx para rutas de Laravel
RUN sed -i 's|try_files $uri $uri/ =404;|try_files $uri $uri/ /index.php?$query_string;|g' /etc/nginx/http.d/default.conf

# 2. FIX DE PERMISOS: Crucial para que Laravel pueda escribir logs y sesiones
RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Instalamos dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Instalamos JS y compilamos assets
RUN npm install --force && npm run build

# Script de inicio
RUN echo "#!/bin/sh" > /entrypoint.sh && \
    echo "php /var/www/html/artisan config:clear" >> /entrypoint.sh && \
    echo "php /var/www/html/artisan migrate --force" >> /entrypoint.sh && \
    echo "exec /start.sh" >> /entrypoint.sh && \
    chmod +x /entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]