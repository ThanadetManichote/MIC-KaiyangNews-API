#!/bin/sh
# MySQL start script

sleep 10;

mysql --host=localhost --port=3306 --user=root --password=$MYSQL_ROOT_PASSWORD -e "CREATE DATABASE mic_news DEFAULT CHARSET=utf8"
mysql --host=localhost --port=3306 --user=root --password=$MYSQL_ROOT_PASSWORD mic_news < /news.sql

mysql --host=localhost --port=3306 --user=root --password=$MYSQL_ROOT_PASSWORD -e "update mysql.user set Host = '%'"
mysql --host=localhost --port=3306 --user=root --password=$MYSQL_ROOT_PASSWORD -e "FLUSH PRIVILEGES"

