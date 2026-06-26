FROM wordpress:6.4.1-php8.1-apache

# Make files owned by root group and group writable
RUN chgrp -R 0 /var/www/html \
    && chmod -R g=u /var/www/html