install:
		sh bin/install.sh

ps:
		docker-compose ps

up:
		docker-compose up -d

stop:
		docker-compose stop
down:
		docker-compose down

deploy:
		sh bin/deploy.sh

restart: stop up

bash:
		docker-compose exec apache bash
down:
		docker-compose down

clean:
		rm -rf data vendor
		docker-compose rm --stop --force
		docker volume prune -f || true
		docker network prune -f || true

build-dev:
		docker-compose exec apache sh -c 'composer install'
		docker-compose exec apache sh -c 'bin/console assets:install public'
		docker-compose exec apache sh -c 'bin/console cache:clear'
