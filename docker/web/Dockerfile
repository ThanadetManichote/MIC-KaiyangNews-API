FROM eggdevop/docker-apache-php:php7-phalcon

COPY ["start_script.sh", "/"]
RUN chmod +x /start_script.sh
RUN mkdir -m 777 /log-dev-docker.develop

WORKDIR /var/www/html
RUN chmod 777 /var/www/html

# ## Add apache config
ADD sites-enabled/vhost.conf /etc/apache2/sites-enabled/
