FROM php:8.4-apache

RUN apt-get update && apt-get install -y cron

COPY src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html/uploads

RUN chmod 000 /var/www/html/uploads/flag.txt

CMD service cron start && php /var/www/html/setup_cron.php && apache2-foreground
