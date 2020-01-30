.DEFAULT_GOAL := help
.PHONY: help
help: ## This help. %s - it's a project name (e.g. legit, nur) in some commands.
	@awk 'BEGIN {FS = ":.*?## "} /^[%a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Builds and starts HTTP server
	docker-compose up

start: ## Starts HTTP server
	docker-compose start

stop: ## Stops HTTP server
	docker-compose stop

salts: ## Generating WordPress salts
	docker-compose exec php-fpm vendor/bin/wp dotenv salts regenerate --file=.env --allow-root