include .makefile-lib/common.mk

.PHONY: help dependencies

dependencies: check-dependencies ## Check dependencies
	composer check-platform-reqs

up: ## build and run docker stack
	@docker compose up -d --build

ssh: ## connect to back container
	@docker compose exec back bash

install: up ## install project
	@docker compose exec back composer install -o
	@docker compose exec back yarn install
	@docker compose exec back yarn dev
	@docker compose exec back bin/console doctrine:schema:update -f

check: ## run php cs fixer
	@docker compose exec back vendor/bin/php-cs-fixer check src

fix: ## run php cs fixer
	@docker compose exec back vendor/bin/php-cs-fixer fix src

test: ## install project
	@docker compose exec back bin/phpunit

