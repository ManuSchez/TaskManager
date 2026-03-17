FROM richarvey/nginx-php-fpm:3.1.6

# Instalamos Node.js 22
RUN apk add --no-cache nodejs-current npm

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV WEBROOT /var/www/html/public
# Esta variable es CLAVE para que la imagen de richarvey configure Nginx correctamente
ENV ERRORS 1

COPY . .

# Configuración quirúrgica de Nginx para que Laravel maneje las rutas
RUN sed -i 's|try_files $uri $uri/ =404;|try_files $uri $uri/ /index.php?$query_string;|g' /etc/nginx/sites-available/default.conf

# Instalamos dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Instalamos JS y compilamos
RUN npm install --force && npm run build

# Script de inicio
RUN echo "#!/bin/sh" > /entrypoint.sh && \
    echo "php /var/www/html/artisan config:clear" >> /entrypoint.sh && \
    echo "php /var/www/html/artisan migrate --force" >> /entrypoint.sh && \
    echo "exec /start.sh" >> /entrypoint.sh && \
    chmod +x /entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]