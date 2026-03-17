# Usamos una imagen que soporte PHP 8.4
FROM richarvey/nginx-php-fpm:3.1.6

# Esta variable permite que composer corra sin quejarse de permisos
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . .

# Configuración de Laravel
ENV ImageOS=alpine3.18
ENV WEBROOT /var/www/html/public
ENV PHP_UPLOAD_MAX_FILESIZE 10M
ENV PHP_POST_MAX_SIZE 10M

# Forzamos la instalación ignorando requisitos de plataforma
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Exponer el puerto
EXPOSE 80

# Comando final (Ejecuta migraciones y arranca el servidor)
CMD ["sh", "-c", "php artisan migrate --force && /start.sh"]