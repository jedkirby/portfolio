##
# Applications
##
DOCKER               ?= docker
DOCKER_COMPOSE       ?= docker-compose
DOCKER_COMPOSE_BUILD ?= ${DOCKER_COMPOSE} -f docker-compose.build.yml
NODE                 ?= ${DOCKER_COMPOSE_BUILD} run --rm node
CLI                  ?= ${DOCKER_COMPOSE_BUILD} run --rm cli
ARTISAN              ?= ${CLI} php artisan


##
# Application Specifics
##
env:
	cp -n .env.example .env || true

key:
	${ARTISAN} key:generate

cs:
	${CLI} php vendor/bin/php-cs-fixer fix

compile:
	${NODE} yarn prod

test:
	${CLI} php vendor/bin/phpunit

migrate:
	${ARTISAN} migrate


##
# Dependencies
##
depend-yarn:
	${NODE} yarn install

depend-composer:
	${CLI} composer install

depend: depend-yarn depend-composer


##
# Docker
##
doc-start:
	${DOCKER_COMPOSE} up --force-recreate -d

doc-stop:
	${DOCKER_COMPOSE} stop


##
# Cleaning
##
clean-vendor:
	rm -rf node_modules
	rm -rf vendor

clean-docker:
	${DOCKER_COMPOSE} kill
	${DOCKER_COMPOSE} rm -fv

clean: clean-vendor clean-docker


##
# Helpers
##
start: env depend key compile doc-start
