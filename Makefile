.PHONY: help install dev up down migrate migrate-fresh seed test cc shell cs-fix ngrok ngrok-webhook telegram-webhook queue-telegram queue-certificates queue-all

# Change 'app' to whatever your php service is named in docker-compose.yml
CONTAINER=app

help:
	@echo "Available commands:"
	@echo "  make start              - Start Docker containers and npm dev server"
	@echo "  make queue              - Start queue worker"
	@echo ""
	@echo "Ngrok & Telegram:"
	@echo "  make ngrok              - Start ngrok and auto-configure Telegram webhook"
	@echo "  make ngrok-stop         - Stop ngrok"
	@echo "  make telegram-webhook   - Update Telegram webhook (if ngrok already running)"
	@echo ""
	@echo "Database:"
	@echo "  make migrate            - Run database migrations"
	@echo "  make migrate-fresh      - Fresh migration with seeding"
	@echo "  make seed               - Seed the database"
	@echo ""
	@echo "Utilities:"
	@echo "  make cc                 - Clear all caches"
	@echo "  make cs-fix             - Run PHP CS Fixer"
	@echo "  make install            - Install dependencies"

start:
	docker compose up -d
	npm run dev

queue:
	docker compose exec $(CONTAINER) php artisan schedule:work

# Ngrok & Telegram Webhook Setup
ngrok:
	@chmod +x scripts/start-ngrok-with-webhook.sh
	@bash scripts/start-ngrok-with-webhook.sh

ngrok-stop:
	@pkill ngrok || echo "Ngrok is not running"

telegram-webhook:
	@chmod +x scripts/setup-telegram-webhook.sh
	@bash scripts/setup-telegram-webhook.sh


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

