copy .env.example file and rename it as.env
use command "cp .env.example .env"

run "composer install"

change the database connectivity part in .env file:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=consultation_management_system
DB_USERNAME=root
DB_PASSWORD=

run database migrations
"php artisan migrate"

run database seeder
"php artisan db:seed"
