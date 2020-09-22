#!/bin/bash

if [ "$1" = "swoole:server:run" ]; then
    exec /var/www/html/bin/console "$@"
fi

exec "$@"