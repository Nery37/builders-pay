CONTAINER_NAME=builders-api

install:
	make build
	make up
	make composer-install
	make migrate

up:
	docker-compose up -d

down:
	docker-compose down

bash:
	make up
	docker exec -it $(CONTAINER_NAME) sh

build:
	docker-compose build

composer-install:
	docker exec $(CONTAINER_NAME) composer install --no-interaction --no-scripts

migrate:
	docker exec $(CONTAINER_NAME) php artisan migrate --seed

test:
ifdef FILTER
	make up
	#make clear
	docker exec -t $(CONTAINER_NAME) composer unit-test -- --filter="$(FILTER)"
else
	make up
	#make clear
	docker exec -t $(CONTAINER_NAME) composer unit-test
endif

logs:
	docker-compose logs --follow

clear:
	docker exec $(CONTAINER_NAME) sh -c "php artisan optimize:clear"

coverage-html:
	make up
	#make clear
	docker exec -t $(CONTAINER_NAME) composer test-coverage-html

format:
	make up
	docker exec -t $(CONTAINER_NAME) composer lint-fix
