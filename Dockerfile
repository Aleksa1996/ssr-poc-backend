# Build stage
FROM aleksajo/php-swoole as builder

USER root

EXPOSE 1215

COPY . /var/www/html

RUN chmod 775 /var/www/html/entrypoint.sh
ENTRYPOINT ["/var/www/html/entrypoint.sh"]
CMD ["swoole:server:run"]
WORKDIR /var/www/html

# Dev stage
FROM builder as dev

# Test stage
FROM builder as test

RUN composer install --no-interaction

# Production stage
FROM builder as prod

RUN composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader --no-interaction