api-install:
	cd api && composer install

api-routes:
	cd api && php artisan route:list

api-test:
	cd api && php artisan test

frontend-install:
	cd frontend && npm install

frontend-dev:
	cd frontend && npm run dev

frontend-build:
	cd frontend && npm run build

docker-up:
	docker compose up -d --build

docker-down:
	docker compose down
