include .env
export

CONTAINER_NGINX=docker compose exec -T nginx sh -c
CONTAINER_PHP=docker compose exec -T php-fpm sh -c
CONTAINER_MARIADB=docker compose exec -T mariadb sh -c
CONTAINER_POSTGRES=docker compose exec -T postgres sh -c
CONTAINER_REDIS=docker compose exec -T redis sh -c

.PHONY: start
start:
	docker compose up -d

.PHONY: stop
stop:
	docker compose -f docker-compose.yml down

.PHONY: setup
setup:
	make permissions
	docker network create proxy || true
	docker compose up --build -d
	$(CONTAINER_PHP) 'composer install --no-interaction'
	$(CONTAINER_PHP) 'php artisan config:clear'
	$(CONTAINER_PHP) 'php artisan storage:link'
	$(CONTAINER_PHP) 'php artisan key:generate'
	make seed
	make docs

.PHONY: staging
staging:
	docker compose up -d
	$(CONTAINER_PHP) 'composer install --no-interaction'
	$(CONTAINER_PHP) 'php artisan optimize'
	make migrate
	make docs

.PHONY: staging-test
staging-test:
	docker compose up -d
	$(CONTAINER_PHP) 'composer install --no-interaction'
	$(CONTAINER_PHP) 'php artisan optimize'
	make seed
	make test

.PHONY: production
production:
	docker compose up -d
	$(CONTAINER_PHP) 'composer install --no-interaction --optimize-autoloader --no-dev'
	$(CONTAINER_PHP) 'php artisan optimize'
	make migrate

.PHONY: composer
composer:
	$(CONTAINER_PHP) 'composer install'

.PHONY: migrate
migrate:
	$(CONTAINER_PHP) 'php artisan migrate'

.PHONY: seed
seed:
	$(CONTAINER_PHP) 'php artisan migrate:fresh --seed'
	# MariaDB User
	# $(CONTAINER_PHP) 'php artisan global-user'
	# Postgres User
	# $(CONTAINER_PHP) 'php artisan ${DOCKER_POSTGRES_USER}'

.PHONY: fix
fix:
	$(CONTAINER_PHP) './vendor/bin/phpcbf'

.PHONY: test
test:
	$(CONTAINER_PHP) 'php artisan test'
	$(CONTAINER_PHP) './vendor/bin/phpcs'

.PHONY: docs
docs:
	$(CONTAINER_PHP) 'yarn'
	$(CONTAINER_PHP) 'yarn docs'

.PHONY: permissions
permissions:
	mkdir -p bootstrap/cache/ storage/logs storage/framework/cache storage/framework/sessions storage/framework/views
	mkdir -p .docker/logs/cron/ .docker/logs/nginx/ .docker/logs/mariadb .docker/logs/php-fpm/ .docker/logs/redis/ .docker/logs/postgres
	sudo chmod -R 777 bootstrap/cache/
	sudo chmod -R 777 storage/
	sudo chmod -R 777 public/
	sudo chmod -R 777 .docker/logs/

.PHONY: reset
reset:
	make stop
	docker system prune --force
	rm -rf ./bootstrap/cache/*
	rm -rf ./.docker/logs/cron/*
	rm -rf ./.docker/logs/mariadb/*
	rm -rf ./.docker/logs/nginx/*
	rm -rf ./.docker/logs/php-fpm/*
	rm -rf ./.docker/logs/redis/*
	rm -rf ./node_modules/
	rm -rf ./.cache/
	rm -rf ./composer/
	rm -rf ./vendor/
	make setup

.PHONY: clean
clean:
	make stop
	docker system prune --all --volumes --force
	rm -rf ./bootstrap/cache/*
	rm -rf ./.docker/logs/cron/*
	rm -rf ./.docker/logs/mariadb/*
	rm -rf ./.docker/logs/nginx/*
	rm -rf ./.docker/logs/php-fpm/*
	rm -rf ./.docker/logs/redis/*
	rm -rf ./node_modules/
	rm -rf ./.cache/
	rm -rf ./composer/
	rm -rf ./vendor/

.PHONY: clean-force
clean-force:
	sudo make clean

.PHONY: ssh-nginx
ssh-nginx:
	docker exec -it ${COMPOSE_PROJECT_NAME}-nginx /bin/sh

.PHONY: ssh-php
ssh-php:
	docker exec -it ${COMPOSE_PROJECT_NAME}-php-fpm /bin/sh

.PHONY: ssh-mariadb
ssh-mariadb:
	docker exec -it ${COMPOSE_PROJECT_NAME}-mariadb /bin/sh

.PHONY: ssh-postgres
ssh-postgres:
	docker exec -it ${COMPOSE_PROJECT_NAME}-postgres /bin/sh

.PHONY: ssh-redis
ssh-redis:
	docker exec -it ${COMPOSE_PROJECT_NAME}-redis /bin/sh

.PHONY: rebuild-nginx
rebuild-nginx:
	docker compose up -d --no-deps  --force-recreate --build nginx

.PHONY: rebuild-php
rebuild-php:
	docker compose up -d --no-deps  --force-recreate --build php-fpm

.PHONY: rebuild-mariadb
rebuild-mariadb:
	docker compose up -d --no-deps  --force-recreate --build mariadb

.PHONY: rebuild-postgres
rebuild-postgres:
	docker compose up -d --no-deps  --force-recreate --build postgres

.PHONY: rebuild-redis
rebuild-redis:
	docker compose up -d --no-deps  --force-recreate --build redis
