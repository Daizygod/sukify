# Clone spotify (not in release now) work in progress

## About
I'm live in Russia, and when spotify was opened in my country<br />
I was so happy because it's music service have awesome features like music tracks transitions, switch devices on fly and etc.<br />
And they leave us country (of course you know why)<br />
But! I have so many music that not in library spotify or others music players,<br />
and I also love "perfect transitions" between two tracks, spotify only allow you to edit default time for transition.<br />
<br/>
As the result I start create this project,<br>
<h2><b>Don't take it as anger to spotify or other music players I just have time and power for this</b>
<b>And of course I don't plan make money on this, just creating a player in spotify design, have fun!</b></h2>
<br>

## Planning
- add creating tracks page (working, need to be editied for albums and artists)
- add music player page like one page app (edditing design, player works)
- add transitions for different tracks (added default transition at the moment)


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

