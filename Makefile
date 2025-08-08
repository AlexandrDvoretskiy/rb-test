up:
	docker-compose up -d
down:
	docker compose down --remove-orphans
build:
	docker-compose up -d --build
php:
	docker exec -it php sh
memcache:
	telnet 127.0.0.1 11211
redis:
	telnet 127.0.0.1 6379
#ssh-add:
#	eval $(ssh-agent -s)
#	ssh-add ~/.ssh/id_rsa_otus