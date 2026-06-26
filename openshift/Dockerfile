FROM wordpress:6.4.1-php8.1-apache

RUN chgrp -R 0 /var/www/html /var/run/apache2 /var/log/apache2 /var/lock/apache2 \
    && chmod -R g=u /var/www/html /var/run/apache2 /var/log/apache2 /var/lock/apache2 \
    && sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-enabled/000-default.conf

EXPOSE 8080

ENTRYPOINT []
CMD ["apache2-foreground"]