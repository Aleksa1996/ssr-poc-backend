#!/bin/bash

if [ "${APP_ENV}" = "DEV" ]
then
    composer install --dev
elif [ "${APP_ENV}" = "PROD" ]
then
    composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader
fi
