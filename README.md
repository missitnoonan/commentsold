# Base Laravel + Vue

## Basic Setup / Requirements

* docker-compose must be installed
* edit hosts and add frontend.test and backend.test
* for backend copy .env.example to .env
* for frontend copy .env.local.example to .env.local
* create database (example env uses laravel)
* exec into backend and composer install and artisan migrate
    * composer install
    * php artisan key:generate
    * php artisan migrate
    * php artisan jwt:secret
* exec into frontend
  * npm install 
  * npm build
  * either
    * npm run watch from the container access at http://frontend.test
    * leave and npm run dev from command line and access through local host indicated