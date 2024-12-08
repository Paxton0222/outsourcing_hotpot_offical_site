./wait-for.sh $DB_HOST:$DB_PORT -- echo 'Database is ready'

php artisan migrate --force --isolated
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

mkdir /var/log/laravel
/usr/bin/supervisord -c /etc/supervisord.conf
