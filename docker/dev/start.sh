mkdir /var/log/laravel

nohup /usr/bin/supervisord -c /etc/supervisord.conf &
nohup npm run dev &
nohup tail -f /var/log/laravel/queue.log &
nohup tail -f /var/log/laravel/schedule.log &
nohup tail -f /var/log/laravel/octane.log &

composer i
npm install --no-audit --no-fund --legacy-peer-deps
npm run build
php artisan key:generate
php artisan optimize:clear
php artisan migrate --force --isolated

php artisan pail --timeout=0
