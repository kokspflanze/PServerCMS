#!/usr/bin/env bash

rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
rpm -Uvh https://rpms.remirepo.net/enterprise/remi-release-8.rpm

# stay up to date
yum -y update

# php && httpd
yum -y install php74 php74-php php74-php-opcache php74-php-bcmath php74-php-cli php74-php-common php74-php-gd php74-php-intl php74-php-json php74-php-mbstring php74-php-pdo php74-php-pdo-dblib php74-php-pear php74-php-pecl-mcrypt php74-php-xmlrpc php74-php-xml php74-php-mysql php74-php-soap php74-php-pecl-zip php74-php-ioncube-loader httpd firewalld mod_ssl

systemctl start firewalld

# firewall setup allow 80 and 443
for s in http https
do
    firewall-cmd --permanent --add-service=$s
done
firewall-cmd --reload

# helpful tools
yum -y install epel-release curl crontabs git unzip htop tmux

systemctl enable httpd crond php74-php-fpm

echo "expose_php = Off
date.timezone = Europe/Berlin
" > /etc/opt/remi/php74/php.d/50-custome.ini

ln -s /bin/php74 /bin/php

echo "ServerTokens prod
ServerSignature Off

<VirtualHost *:80>
	DocumentRoot /var/www/page/public
	<Directory /var/www/page/public>
			Options -Indexes +FollowSymLinks +MultiViews
			AllowOverride All
			Order allow,deny
			allow from all
	</Directory>

	ErrorLog /var/log/httpd/page-error.log
	CustomLog /var/log/httpd/page-access.log combined
</VirtualHost>


<VirtualHost _default_:443>

DocumentRoot /var/www/page/public
<Directory /var/www/page/public>
		Options -Indexes +FollowSymLinks +MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
</Directory>

ErrorLog logs/ssl_error_log
TransferLog logs/ssl_access_log
LogLevel warn

SSLEngine on
SSLHonorCipherOrder on

SSLCipherSuite PROFILE=SYSTEM
SSLProxyCipherSuite PROFILE=SYSTEM

SSLCertificateFile /etc/pki/tls/certs/localhost.crt

SSLCertificateKeyFile /etc/pki/tls/private/localhost.key

</VirtualHost>

" > /etc/httpd/conf.d/v-host.conf

mkdir -p /var/www/page/data/DoctrineModule/cache
mkdir -p /var/www/page/public
mkdir -p /var/opt/remi/php74/log/php-fpm

# selinux
setsebool -P httpd_can_network_connect on
chcon -t httpd_sys_rw_content_t /var/www/page/data -R
restorecon -R /var/www/page

# cache directory
chown apache:apache -R /var/www/page/data
chmod -R 777 /var/www/page/data

cd /var/www/page
php composer.phar update


#setup crons
echo "* * * * * apache php /var/www/page/public/index.php player-history
*/5 * * * * apache php /var/www/page/public/index.php user-codes-cleanup
2 * * * * apache php /var/www/page/public/index.php generate-sitemap https://www.example.io/
" > /etc/cron.d/pservercms

systemctl start httpd crond php74-php-fpm
