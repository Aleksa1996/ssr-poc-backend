# Build stage
FROM aleksajo/php-swoole as builder

USER root

EXPOSE 1215

COPY . /var/www/html

RUN chmod -R 775 /var/www/html
ENTRYPOINT ["/var/www/html/entrypoint.sh"]
CMD ["swoole:server:run"]
WORKDIR /var/www/html

# Dev stage
FROM builder AS dev

# Test stage
FROM builder AS test

ENV TOOLBOX_TARGET_DIR="/tools"
ENV TOOLBOX_VERSION="1.27.3"
ENV PATH="$PATH:$TOOLBOX_TARGET_DIR:$TOOLBOX_TARGET_DIR/.composer/vendor/bin:/tools/QualityAnalyzer/bin:$TOOLBOX_TARGET_DIR/DesignPatternDetector/bin:$TOOLBOX_TARGET_DIR/EasyCodingStandard/bin"
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME=$TOOLBOX_TARGET_DIR/.composer

RUN composer install --no-interaction  && \
    cd /tmp && \
    git clone https://github.com/nikic/php-ast.git && cd php-ast && phpize && ./configure && make && make install && cd .. && rm -rf php-ast && docker-php-ext-enable ast && \
    pecl install pcov && docker-php-ext-enable pcov && \
    echo "memory_limit=-1" >> $PHP_INI_DIR/php.ini && \
    echo "phar.readonly=0" >> $PHP_INI_DIR/php.ini && \
    echo "pcov.enabled=0" >> $PHP_INI_DIR/php.ini && \
    mkdir -p $TOOLBOX_TARGET_DIR && curl -Ls https://github.com/jakzal/toolbox/releases/download/v$TOOLBOX_VERSION/toolbox.phar -o $TOOLBOX_TARGET_DIR/toolbox && chmod +x $TOOLBOX_TARGET_DIR/toolbox && \
    php $TOOLBOX_TARGET_DIR/toolbox install
CMD php $TOOLBOX_TARGET_DIR/toolbox list-tools

# Production stage
FROM builder AS prod

RUN composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader --no-interaction