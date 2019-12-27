.DEFAULT_GOAL := help
.PHONY: help
help: ## This help. %s - it's a project name (e.g. legit, nur) in some commands.
	@awk 'BEGIN {FS = ":.*?## "} /^[%a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Starts HTTP server
	docker-compose start

stop: ## Stops HTTP server
	docker-compose stop

composer: ## Runs composer commands from container
	docker run --rm -v $(PWD):/app composer ${a}