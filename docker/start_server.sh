#!/bin/sh

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

echo $DIR

docker rm -f mic-kaiyangnews-api-web

docker rm -f mic-kaiyangnews-api-mysql
docker rm -f mic-kaiyangnews-api-pma
docker-compose rm

docker-compose build mic-kaiyangnews-api-web
WEB_ID=$(docker-compose up -d mic-kaiyangnews-api-web)


docker-compose build mic-kaiyangnews-api-mysql
WEB_ID=$(docker-compose up -d mic-kaiyangnews-api-mysql)

docker-compose up -d mic-kaiyangnews-api-pma

sleep 3

docker exec -it mic-kaiyangnews-api-mysql sh /start_script.sh

sleep 3

docker exec -it mic-kaiyangnews-api-web sh /start_script.sh

sleep 3

docker exec -it mic-kaiyangnews-api-web sh /etc/init.d/apache2 start
