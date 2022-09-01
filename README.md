```
cp .env.example .env
composer install
npm install
npm run prod
./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate
```
