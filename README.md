**Requirements:**


* Web server with apache 2.2 or higher (on Windows you can use https://www.apachefriends.org/ru/index.html or http://open-server.ru/)
* PHP 5.3 or higher
* PostgreSQL 9.3 or higher
* Composer (https://getcomposer.org/)

**Installation steps:**


0. Create a domain for your site (http://example.me), with /%your_app_dir%/public document root folder
1. Open command line or git bash in the application folder and run composer install / composer update for required dependencies installation
2. Create a new role in your PostgreSQL admin and an empty database for it (for example basement / basement)
3. Copy config/autoload/db.example.php to config/autoload/db.local.php and fill it with proper database settings (user, password, dbname). If you have mongo db installed and want to use it you can perform step 2) for mongoDb and fill settings for mongo
4. Open your browser and go to http://example.me. If it is your first installation you will be redirected to the installation page. Then just follow the installer's instructions.
