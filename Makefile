up: docker-up
down: docker-down
init: docker-down-clear docker-pull docker-build docker-up api-init api-test
test: api-test

docker-up:
	docker-compose up -d
docker-down:
	docker-compose down --remove-orphans
docker-down-clear:
	docker-compose down -v --remove-orphans
docker-pull:
	docker-compose pull
docker-build:
	docker-compose build

api-init: api-composer-install api-permissions api-migrations api-fixtures-load
api-composer-install:
	docker-compose run --rm api-php-cli composer install
api-test:
	docker-compose run --rm api-php-cli php bin/phpunit
api-permissions:
	docker-compose run --rm api-php-cli chown 1000:1000 ./ -R
api-wait-db:
	docker-compose run --rm api-php-cli /app/docker/development/scripts/wait-for-it.sh api-postgres:5432
api-migrations: api-wait-db
	docker-compose run --rm api-php-cli bin/console doctrine:migrations:migrate --no-interaction
api-fixtures-load:
	docker-compose run --rm api-php-cli bin/console doctrine:fixtures:load --no-interaction