FROM really/nginx-certbot

# COPY nginx.conf /etc/nginx/nginx.conf
COPY ./back.conf /etc/nginx/conf.d/default.conf

#RUN certbot renew --nginx -d back.local -d www.back.local

# DEV:
#RUN openssl req -newkey rsa:2048 -nodes -keyout ./docker/nginx/certs/symfony.local.key -x509 -days 365 -out ./docker/nginx/certs/symfony.local.crt -subj '/CN=symfony.local'
# RUN openssl req -newkey rsa:2048 -nodes -keyout /var/www/symfony/docker/nginx/certs/symfony.local.key -x509 -days 365 -out /var/www/symfony/docker/nginx/certs/symfony.local.crt -subj '/CN=symfony.local'
#RUN certbot --nginx -n --agree-tos --email mouss38@gmail.com --domains www.symfony.local

WORKDIR /var/www/html