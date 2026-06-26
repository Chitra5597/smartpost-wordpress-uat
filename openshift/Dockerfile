FROM wordpress:6.4.1-php8.1-apache

RUN chgrp -R 0 /var/www \
 && chmod -R g=u /var/www

ENTRYPOINT ["apache2-foreground"]