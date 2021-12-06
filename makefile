include .env
CURRENT_USER=${USER:=$(/usr/bin/id -run)}
DOCKER_PHP=docker exec -it ${DOCKER_APP}-php
up:
	- docker-compose up -d
down:
	- docker-compose down
php:
	- docker exec -it ${DOCKER_APP}-php bash
build:
	- ${DOCKER_PHP} composer install
	- ${DOCKER_PHP} php artisan key:generate
	- ${DOCKER_PHP} php artisan migrate --seed
	- ${DOCKER_PHP} npm i
	- ${DOCKER_PHP} npm run dev
	- ${DOCKER_PHP} php artisan ide-helper:models --dir="modules"
db-fresh:
	- ${DOCKER_PHP} php artisan migrate:fresh --seed
db:
	- ${DOCKER_PHP} php artisan migrate
chown:
	- sudo chown ${CURRENT_USER}:${CURRENT_USER} -R .
	- sudo chmod 777 -R .
stan:
	- ${DOCKER_PHP} php -d memory_limit=1G /composer/vendor/bin/phpstan analyse core modules --level=1
ide:
	- ${DOCKER_PHP} php artisan ide-helper:models --dir="modules"
role:
	- ${DOCKER_PHP} php artisan db:seed --class="\Modules\Auth\Database\Seed\PermissionSeeder"
