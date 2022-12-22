# Clone spotify (not in release now) work in progress
## Picture of last design at moment!
![alt text](https://user-images.githubusercontent.com/46899953/209230334-d8b7e010-e581-4d30-a3cf-f56ca3b5024b.png)
![alt text](https://user-images.githubusercontent.com/46899953/208583653-b748f261-5d42-4670-8ed7-ab340ec5d54a.png)


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Commands
###CRUD

generate model based on table from DB
`php artisan code:models --table=}}Table Name{{`

generate controller
`php artisan make:controller }}Name{{Controller --resource`

generate views (need svenluijten/artisan-view)
`php artisan make:view index`

## Setup
### DataBase

Connect to MySQL.exe (I have it in mariaDB)

`C:\Program Files\MariaDB 10.8\bin> ./mysql -uroot -p`

Create database with your name in env file
`create database sukify`

`php artisan key:generate`

`npm install`

`npm run dev`

`npm run build`

`php artisan serve`

### Другое

`php artisan route:clear`

`php artisan db:seed`

`php artisan key:generate`

### Для проверки на моб устройстве (нужно подключится к одной сетке)

`php artisan serve --host=0.0.0.0:80`

### Пакеты для PHP
`sudo apt install php8.1 php8.1-fpm php8.1-{bcmath,xml,fpm,mysql,zip,intl,ldap,gd,cli,bz2,curl,mbstring,pgsql,opcache,soap,cgi,ssh2}`

