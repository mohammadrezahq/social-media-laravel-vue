# Lymedia
Social media like instagram based on laravel and vue js

### images
<img src="https://github.com/mohammadrezahq/social-media-laravel-vue/blob/main/readme/explore.JPG">
<img src="https://github.com/mohammadrezahq/social-media-laravel-vue/blob/main/readme/feed.JPG">
<img src="https://github.com/mohammadrezahq/social-media-laravel-vue/blob/main/readme/profile.JPG">

### Setup

#### Frontend

For running Vue js, go inside the frontend folder and run these commands in terminal: 

```
npm install
npm run serve
```

#### Backend

For running laravel:

Make a copy of .env.example and rename it to .env

Find database properties inside .env file, change it like below
(Lymedia works with mongodb, you need to install mongodb on your system)

```
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=AnythingYouWant
```
then go to backend folder and open terminal and run this command:

```
composer install
```

then inside /vendor/laravel/sanctum/src/PersonalAccessToken.php

replace this:

```
use Illuminate\Database\Eloquent\Model;
```

with this:

```
use Jenssegers\Mongodb\Eloquent\Model;
```

then for generating laravel key use this command:

```
php artisan key:generate
```

for database testing use these commands:

```
php artisan migrate
php artisan db:seed
```

and finally for running laravel use 

```
php artisan serve
````

After runnig vue and laravel, you can access to lymedia with:
http://localhost:8080