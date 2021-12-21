# Makefile for Docker

include .env

# Flags
MAKEFLAGS += --no-print-directory

# default target
.DEFAULT_GOAL=help

# Variables
DOCKER_COMPOSE=@docker-compose -f "docker-compose.yml"
APP_PATH=/var/www/html
ARG=

docker-start:
	@echo docker start
	@$(DOCKER_COMPOSE) up -d --build

docker-stop:
	@echo docker stop
	@$(DOCKER_COMPOSE) stop

docker-restart:
	@$(MAKE) docker-stop
	@$(MAKE) docker-start