FROM aleksajo/php-swoole

COPY ./ /var/www/html

RUN chmod u+x /var/www/html/install.sh && /var/www/html/install.sh

EXPOSE 1215

RUN chmod u+x /var/www/html/entrypoint.sh
ENTRYPOINT ["/var/www/html/entrypoint.sh"]

CMD ["swoole:server:run"]