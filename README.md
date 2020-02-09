# Adzooma - Technical Test

This is a basic RSS Feed manager written in Laravel 6.x

## Prerequisites

The following is assumed to be installed and setup on the local machine for development:

-   PHP 7.2
-   Composer
-   MySQL 5.x or 8.x
-   Node 12.x
-   Npm 6.x

You also need to create a database and populate the .env file, at very least, the following should be provided. In this instance, `adzooma` is the database name.

```
APP_NAME="RSS Reader"
APP_ENV=local
APP_KEY=RANDOM_BASE64_KEY
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=adzooma
DB_USERNAME=user
DB_PASSWORD=password
```

## Quick start

Clone the repository and run the following commands:

```bash
composer install
npm install && npm run dev
php artisan migrate
php artisan serve
```

## Issues / Todos

List of known issues or todos where, if given more time, I'd model this correctly. Of course, this is just a demonstration of how one would go about bootstrapping a Laravel project.

-   Images aren't consistend with the RSS spec, they seem to be optional, so this has been ommitted
-   No tests provided, granted this is a technical test with a limited time constraint
-   Basic validation added, custom validation around URLs passed should suffice
-   Limitation on API isn't set. N number of results could be returned
-   Client and Server should be split, but Laravel doesn't seem to advocate this like React / Express
-   Code in controller, not split into domain logic / service etc
-   This is productionised, ideally Docker would be used
