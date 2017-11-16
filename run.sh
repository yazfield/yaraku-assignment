echo 'Installing dependencies'
composer install -q
cp .env.laradock.nginx .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
cd laradock
cp ../laradockenv .env
echo 'Running docker containers'
sudo docker-compose up -d nginx
cd ..

echo 'Open http://localhost:8080/ to access the app'
