 Positioned in the 'backStore' folder you must execute the commands:

$ npm i --> install the dependencies for Laravel.

$ composer install --> component needed for Laravel to work.


3 - Create a MySQL database.


4 - Create the .env file (it is recommended to use the '.env.example' file as an example).


5 - Inside the .env file the data of the created database must be entered:

DB_CONNECTION=mysql

DB_HOST=localhost

DB_PORT=3306

DB_DATABASE=(database name)

DB_USERNAME=root

DB_PASSWORD=(if you have a password enter it, otherwise leave it empty)


6 - Inside the 'backStore' folder, generate the security keys by executing the following commands:

$ php artisan key:generate

$ php artisan jwt:secret


7 - Then make the corresponding migrations with the command:

$ php artisan migrate


8 - Finally, run the 'backStore' server with the command:

$ php artisan serve