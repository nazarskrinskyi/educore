.PHONY: help install dev up down migrate migrate-fresh seed test cc shell cs-fix ngrok queue-telegram queue-certificates queue-all

# Change 'app' to whatever your php service is named in docker-compose.yml
CONTAINER=app

# Setup & Installation
install:
	docker compose exec $(CONTAINER) composer install
	docker compose exec $(CONTAINER) npm install
	docker compose exec $(CONTAINER) npm run build

# Database
migrate:
	docker compose exec $(CONTAINER) php artisan migrate

migrate-fresh:
	docker compose exec $(CONTAINER) php artisan migrate:fresh --seed

seed:
	docker compose exec $(CONTAINER) php artisan db:seed

# Quality Tools
cs-fix:
	docker compose exec $(CONTAINER) ./vendor/bin/php-cs-fixer fix

# Utilities
cc:
	docker compose exec $(CONTAINER) php artisan optimize:clear
	docker compose exec $(CONTAINER) php artisan cache:clear
	docker compose exec $(CONTAINER) php artisan config:clear
	docker compose exec $(CONTAINER) php artisan view:clear
	docker compose exec $(CONTAINER) php artisan route:clear

# Ngrok & Queue Workers
ngrok:
	npx ngrok http 8000
	php artisan queue:work --tries=3 --timeout=90
