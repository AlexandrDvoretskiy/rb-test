up:
	docker-compose up -d
down:
	docker compose down --remove-orphans
build:
	docker-compose up -d --build
php:
	docker exec -it symfony_php sh