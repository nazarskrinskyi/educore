# ==============================================================================
# Useful Laravel Commands
# ==============================================================================

.PHONY: help install dev up down migrate migrate-fresh seed test cc shell cs-fix

# Show this help message
help:
	@echo "Available commands:"
	@echo "  make install       - Install Composer and NPM dependencies"
	@echo "  make dev           - Run the local development server (Composer script)"
	@echo "  make migrate       - Run database migrations"
	@echo "  make migrate-fresh - Drop all tables and re-run all migrations"
	@echo "  make seed          - Run database seeders"
	@echo "  make test          - Run Pest/PHPUnit tests"
	@echo "  make cc            - Clear all Laravel caches (config, route, view, etc.)"
	@echo "  make shell         - Open a Laravel Tinker shell"
	@echo "  make cs-fix        - Run PHP CS Fixer to format code"

# Setup & Installation
install:
	composer install
	npm install
	npm run build

# Development Servers
dev:
	composer run dev

# Database
migrate:
	php artisan migrate

migrate-fresh:
	php artisan migrate:fresh --seed

seed:
	php artisan db:seed

# Testing & Linting
test:
	composer run test

cs-fix:
	./vendor/bin/php-cs-fixer fix

# Utilities
cc:
	php artisan optimize:clear
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear

shell:
	php artisan tinker
