FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Configuración de Laravel
ENV ImageOS=alpine3.18
ENV WEBROOT /var/www/html/public
ENV PHP_UPLOAD_MAX_FILESIZE 10M
ENV PHP_POST_MAX_SIZE 10M

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto que usa Render
EXPOSE 80

# Comando para arrancar y ejecutar migraciones
CMD ["/start.sh"]