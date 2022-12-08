Open source version for 
Project on sns event management

```
cp .env.example .env
composer install
npm install
npm run prod
./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
```

open localhost
