FROM linuxserver/letsencrypt

# Install Composer
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

# Copy the required files
ADD . /home/synchrome/lumen
ADD ./deploy/nginx/config/nginx.conf /config/nginx/site-confs/default

WORKDIR /home/synchrome/lumen

# Install dependencies
RUN composer install
RUN composer dump-autoload

RUN chgrp -R 1003 /home/synchrome/lumen .
RUN chmod -R ug+rwx storage

RUN cp .env.production .env