# laravel-feed-parser
Basic app with auth and feed parsing.

## Frameworks and Libraries used
- [Laravel](https://laravel.com/)
- [Laravel Feeds](https://github.com/willvincent/feeds)
- [Vue.js](https://vuejs.org/)
- [Bootstrap](https://getbootstrap.com/)

## Prerequisites
- PHP 7
- MySQL (you can use another db provider in .env file)
- [Composer](https://getcomposer.org/download/)
- [npm](https://www.npmjs.com/get-npm)

## Instalation instructures
1. Get files
  **git clone https://github.com/mihailvasilchenko/laravel-feed-parser.git**
2. Go to project folder
  **cd laravel-feed-parser**
3. Install composer packages
  **composer install**
4. Install npm packages
  **npm install && npm run dev**
5. Copy config file and rename to .env
  **cp .env.example .env**
6. Create mysql db (or db provider of your choice) and update the DB settings in .env file
  (default db name is **feedparser** with user and pass set as **root**)
7. Run db migrations
  **php artisan migrate**
8. Run app
  **php artisan serve**
9. Run tests
  **vendor/bin/phpunit**
  (note that it uses the same db for simplicity's sake, you can edit the config in **phpunit.xml**)