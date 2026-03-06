web: heroku-php-apache2 public/
release: php artisan migrate --force && php artisan storage:link --force
# optional worker if you use queues:
# worker: php artisan queue:work --sleep=3 --tries=3 --max-time=3600
