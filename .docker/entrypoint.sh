#!/bin/bash

composer install
# npm install
php artisan migrate
php artisan db:seed
php-fpm
