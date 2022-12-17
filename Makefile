# Executables (local)
DOCKER_COMP = docker compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php-fpm

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP_CONT) bin/console

GEN_DB_PASS       = $(shell xxd -l10 -ps /dev/urandom)
GEN_APP_SECRET    = $(shell xxd -l16 -ps /dev/urandom)

up: # Start application
	$(DOCKER_COMP) up -d

down: # Stop application
	@$(DOCKER_COMP) down --remove-orphans

restart: down up # Restart application

init: .env.local up composer migrations create-admin cc

migrations: # Run database migrations
	@$(SYMFONY) doctrine:migrations:migrate -n

create-admin: # Create admin user
	@$(SYMFONY) app:create-user --admin

composer: # Install vendor
	@$(COMPOSER) install

cc: # Clear caches
	@$(SYMFONY) cache:clear
	@$(SYMFONY) cache:warmup

upgrade: composer migrations restart

.env.local:
	@cp .env .env.local && sed -i -e 's/%CHANGE_ME_DB_PASSWORD%/$(GEN_DB_PASS)/g' .env.local && sed -i -e 's/%CHANGE_ME_APP_SECRET%/$(GEN_APP_SECRET)/g' .env.local