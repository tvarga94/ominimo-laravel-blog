#!/bin/bash

echo "Starting Laravel project setup..."

echo "Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Generating application key..."
php artisan key:generate

echo "Running migrations and seeding the database..."
php artisan migrate:fresh --seed

echo "Installing frontend dependencies..."
npm install
npm run build

echo "Caching configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Laravel development server..."
php artisan serve --host=127.0.0.1 --port=8000 &

echo "Laravel project setup is complete. Application running at: http://127.0.0.1:8000"
