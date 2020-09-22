FROM aleksajo/php-swoole

USER root

COPY ./ /var/www/html

RUN chmod 775 /var/www/html/install.sh && /var/www/html/install.sh

EXPOSE 1215

RUN chmod 775 /var/www/html/entrypoint.sh
ENTRYPOINT ["/var/www/html/entrypoint.sh"]

CMD ["swoole:server:run"]