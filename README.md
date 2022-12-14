# Clone spotify (not in release now) work in progress
## Picture of last design at moment!
![alt text](https://user-images.githubusercontent.com/46899953/207670267-e2177a56-1ab0-4c22-8cbb-0376a92610ad.png)


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

### Пакеты для PHP
`sudo apt install php8.1 php8.1-fpm php8.1-{bcmath,xml,fpm,mysql,zip,intl,ldap,gd,cli,bz2,curl,mbstring,pgsql,opcache,soap,cgi,ssh2}`

