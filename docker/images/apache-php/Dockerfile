FROM centos:7
RUN yum -y update
RUN yum upgrade
RUN yum clean all
RUN yum -y install rsync httpd git
RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
RUN yum -y install php72w php72w-opcache php72w-mbstring php72w-pdo php72w-mysqlnd php72w-soap php72w-pecl-imagick php72w-pecl-xdebug.x86_64 php72w-gd
RUN yum -y install php72w-fpm php72w-pecl-apcu php72w-bcmath
RUN yum -y install php72w-intl
RUN yum -y install memcached php72w-pecl-memcache
RUN sed -i "s/AllowOverride None/AllowOverride All/" /etc/httpd/conf/httpd.conf

RUN yum -y install supervisor

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer
RUN curl -sL https://rpm.nodesource.com/setup_10.x | bash -

RUN yum -y install nodejs
RUN npm install
RUN npm install -g npm
RUN npm install --global webpack
RUN npm install --global browser-sync
RUN npm install -g cross-env
RUN npm install -g pm2

RUN supervisorctl start laravel-worker:*
RUN mkdir /u1
RUN chown -R apache:apache /var/www/html

RUN fc-cache -f -v

RUN echo "IncludeOptional sites-enabled/*.conf" >> /etc/httpd/conf/httpd.conf
RUN mkdir /etc/httpd/sites-available
RUN mkdir /etc/httpd/sites-enabled

VOLUME ["/var/www/html"]
WORKDIR /var/www/html

EXPOSE 80
EXPOSE 9000
EXPOSE 443
EXPOSE 3000

CMD ["supervisord", "-n"]
CMD ["php-fpm"]
CMD ["/usr/sbin/httpd", "-DFOREGROUND"]
