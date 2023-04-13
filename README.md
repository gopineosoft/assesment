- Clone Project on your local system.
 	- Install git on your system.
 	- Run- git clone https://gitlab.com/kumar.kamal/aertrip.git 
- Rename .env.example as .env.
- Enter database connection details.
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=aertrip
    DB_USERNAME=root
    DB_PASSWORD=
- Run command 
   composer install
-Run command
    php artisan serve
