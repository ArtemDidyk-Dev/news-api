include .env
build:
	docker stop $$(docker ps -aq)
	docker compose build
	docker network create ${NETWORK_NAME}_proxynet
	docker compose up -d
	docker exec -it ${PROJECT_NAME}_app sh -c "composer install"
	exit
	@echo "\033[0;32mBuild done\033[0m"
run:
	docker-compose up -d
	@echo "\033[0;32mDone\033[0m"

stop:
	docker-compose down
	@echo "\033[0;32mDone\033[0m"
# ECS command
.PHONY: ecs
ecs:
	@docker exec ${PROJECT_NAME}_app vendor/bin/ecs check --fix
