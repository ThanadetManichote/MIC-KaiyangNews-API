#!/bin/sh
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
echo $DIR

docker rm -f mic-kaiyangnews-api-web
docker-compose rm

docker-compose build mic-kaiyangnews-api-web
docker-compose up -d mic-kaiyangnews-api-web

sleep 3
docker exec -it mic-kaiyangnews-api-web sh /web_start_script.sh
sleep 3
docker exec -it mic-kaiyangnews-api-web sh /etc/init.d/apache2 start
