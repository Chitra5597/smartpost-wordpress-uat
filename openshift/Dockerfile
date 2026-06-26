FROM wordpress:6.4.1-php8.1-apache

# Allow OpenShift random UID to write
RUN chgrp -R 0 /var/www/html \
    && chmod -R g=u /var/www/html

# Configure Apache to use port 8080
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-enabled/000-default.conf

EXPOSE 8080

CMD ["apache2-foreground"]