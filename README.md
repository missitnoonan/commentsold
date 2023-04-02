# Base Laravel + Vue

## Description
This is a monorepo for a basic docker development environment with a Laravel backed API
in the directory backend and a Vue frontend in the directory frontend.

I did not have time to get this up online, my current droplet is only running PHP 7.3, just getting an 8.2 up now

This is in a fresh github repo as my main repo is connected to my current role, but that can be found at
https://github.com/ambielecki

### Basic Setup / Requirements

* clone repository locally
* docker desktop with compose must be installed
* edit hosts and add frontend.test and backend.test
* in backend copy .env.example to .env
* in frontend copy .env.local.example to .env.local
* create database (example env uses laravel)
* exec into fpm and composer install and artisan migrate (docker-compose exec php-fpm-82-commentsold /bin/bash)
    * cd backend
    * composer install
    * php artisan key:generate
    * php artisan migrate:fresh --seed
    * php artisan jwt:secret
* exec into frontend (docker-compose exec frontend-commentsold /bin/bash)
  * npm install 
  * npm run build
  * for further dev either
    * npm run watch from the container access at http://frontend.test
    * leave and npm run dev from command line and access through local host indicated (assumes node is installed on the system)
* App should be accessible at http://frontend.test

### Description / Caveats

* Definitely spent more than 4 hours, there's a lot here to get something that works right and looks decent
* Quite a bit of the backend auth and frontend shell / auth is from other personal projects
* The auth setup is very simple, just a JWT that is stored in pinia and localstorage, not prod ready
* Very little (no) testing, would write SO MANY MORE
* Very little error handling, especially in the backend
* The repository pattern is massive overkill
* Seeds are not DRY at all, would usually create a more general importer
* Should setup SSL, CORS, etc
* There is no caching, so every time you visit a page it reloads
* Did not implement a currency formatter for the frontend, so everything is still cents

### Tour / Highlights

* Most routes are behind auth, so login with the first user in the csv
  * email: larhonda.hovis@foo.com pw: cghmpbKXXK
* Implemented product list, product view, inventory list, inventory view
* Implemented some minimal testing for the ProductRepository, hampered by some outside code I reused

