FROM richarvey/nginx-php-fpm:3.1.6

# Instalamos Node.js 22
RUN apk add --no-cache nodejs-current npm

ENV COMPOSER_ALLOW_SUPERUSER=1
# Definimos el directorio raíz de la web para Laravel
ENV WEBROOT /var/www/html/public
# Activamos la configuración de Laravel para Nginx que ya trae la imagen
ENV RUN_SCRIPTS 1
ENV SKIP_CHOWN 1

COPY . .

# Copiamos la configuración de Nginx específica para Laravel
# Esto asegura que las rutas como /login funcionen
RUN cp .docker/nginx.conf /etc/nginx/sites-available/default.conf 2>/dev/null || \
    sed -i 's|try_files $uri $uri/ =404;|try_files $uri $uri/ /index.php?$query_string;|g' /etc/nginx/http.d/default.conf

# Instalamos dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Instalamos JS y compilamos assets
RUN npm install --force && npm run build

# Script de inicio mejorado
RUN echo "#!/bin/sh" > /entrypoint.sh && \
    echo "php /var/www/html/artisan config:clear" >> /entrypoint.sh && \
    echo "php /var/www/html/artisan migrate --force" >> /entrypoint.sh && \
    echo "exec /start.sh" >> /entrypoint.sh && \
    chmod +x /entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]