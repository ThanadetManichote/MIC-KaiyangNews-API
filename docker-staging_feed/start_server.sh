#!/bin/sh
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
echo $DIR

docker rm -f mic-feednews-api-web
docker-compose rm

docker-compose build mic-feednews-api-web
docker-compose up -d mic-feednews-api-web

sleep 3
docker exec -it mic-feednews-api-web sh /web_start_script.sh
sleep 3
docker exec -it mic-feednews-api-web sh /etc/init.d/apache2 start
