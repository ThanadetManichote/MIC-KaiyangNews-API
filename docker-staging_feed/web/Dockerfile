FROM eggdevop/docker-apache-php:php7-phalcon

WORKDIR /var/projects/staging-feed-news/

RUN git clone -b release-feed http://egghubot:eggdigitalplatform@git365.eggdigital.com/guanyu/mic/MIC-KaiyangNews-API.git /var/projects/staging-feed-news/

RUN composer install

ADD sites-enabled/vhost.conf /etc/apache2/sites-available/

RUN cd /etc/apache2/sites-available/
RUN a2ensite vhost.conf

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]