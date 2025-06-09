#!/bin/bash

docker rm -f roomracoon-devtest roomracoon-devtest-mysql roomracoon-devtest-phpmyadmin

docker network rm roomracoon-devtest-network

docker build --no-cache -t devtest .

docker network create roomracoon-devtest-network

docker run -d \
-p 8080:80 \
--name roomracoon-devtest \
--network roomracoon-devtest-network \
-v "$PWD":/var/www/html devtest

docker run -d \
--name roomracoon-devtest-mysql \
--network roomracoon-devtest-network \
-e MYSQL_ROOT_PASSWORD=root \
-p 3306:3306 \
mysql:8.0

docker run -d \
--name roomracoon-devtest-phpmyadmin \
--network roomracoon-devtest-network \
-e PMA_HOST=roomracoon-devtest-mysql \
-e PMA_PORT=3306 \
-p 8081:80 \
phpmyadmin/phpmyadmin