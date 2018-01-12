#!/bin/sh

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

echo $DIR

docker rm -f mic-feednews-api-web

docker rm -f mic-feednews-api-mysql
docker rm -f mic-feednews-api-pma
docker-compose rm

docker-compose build mic-feednews-api-web
WEB_ID=$(docker-compose up -d mic-feednews-api-web)


docker-compose build mic-feednews-api-mysql
WEB_ID=$(docker-compose up -d mic-feednews-api-mysql)

docker-compose up -d mic-feednews-api-pma

sleep 3

docker exec -it mic-feednews-api-mysql sh /start_script.sh

sleep 3

docker exec -it mic-feednews-api-web sh /start_script.sh

sleep 3

docker exec -it mic-feednews-api-web sh /etc/init.d/apache2 start
