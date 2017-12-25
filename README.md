# Kaiyang Microservice News

[![N|Solid](http://www.nunamts.com/cdn/phalcon-readme.jpg)](https://nodesource.com/products/nsolid)

### Technology

* [php7]
* [Phalcon]

### Port&URL

* [Website Docker] http://mic-kaiyangnews-api.develop:8135
* [Phpmyadmin Docker] http://mic-kaiyangnews-api.develop:32065

For staging environments...

* [Website Staging] http://staging-mic-kaiyangbanner-api.eggdigital.com:8135
* [Phpmyadmin Staging] http://192.168.110.132/phpmyadmin

### Installation

```sh
$ cd mic-kaiyangnews-api
$ cd docker
$ sh start_server.sh

$ docker exec -it kaiyang_api_web bash
$ composer install
```

For staging environments...

```sh
$ cd mic-kaiyangnews-api
$ cd docker-staging
$ sh start_server.sh
```

### Development

เป็น api สำหรับไก่ย่างไทย CRUD

สามารถจัดการข่าวของไก่ไทย ทั้ง Business และ Customer

### Jira
- EGAP-3202
- EGAP-3289


