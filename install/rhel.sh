#!/usr/bin/env bash

READHAT_FILE=/etc/redhat-release
PHP_Version=74
OS_MIN_VERSION=8
OS_MAX_VERSION=9
TARGET_DIR="/var/www/page/"

export ACCEPT_EULA=Y

if [ "$EUID" -ne 0 ]
  then echo "Please run as root"
  exit
fi

if [ ! -f "$READHAT_FILE" ]; then
    echo "$READHAT_FILE does not exist."
    echo "Centos, AlmaLinux and RockyLinux are supported"
    exit 1
fi

OS_MAJOR_VERSION=$(cat $READHAT_FILE | tr -dc '0-9.'|cut -d \. -f1)
if [ $OS_MAJOR_VERSION -gt $OS_MAX_VERSION ] || [ $OS_MIN_VERSION -gt $OS_MAJOR_VERSION ];
then
    echo "Only Release 8 and 9 supported";
    exit 1
fi;

rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-$OS_MAJOR_VERSION.noarch.rpm
rpm -Uvh https://rpms.remirepo.net/enterprise/remi-release-$OS_MAJOR_VERSION.rpm

if [ $OS_MAJOR_VERSION -eq $OS_MIN_VERSION ];
then
   rpm -Uvh https://packages.microsoft.com/config/rhel/8/packages-microsoft-prod.rpm
else
   rpm -Uvh https://packages.microsoft.com/rhel/$OS_MAJOR_VERSION/prod/packages-microsoft-prod.rpm
fi;

if [ ! -d "$TARGET_DIR" ] || [ ! -f "$TARGET_DIR/composer.phar" ]; then
  # Take action if $DIR exists. #
  echo "Please Upload the Files to ${TARGET_DIR}..."
  exit 1
fi

# stay up to date
yum -y update

# php && httpd
yum -y install php$PHP_Version php$PHP_Version-php php$PHP_Version-php-opcache php$PHP_Version-php-bcmath php$PHP_Version-php-cli php$PHP_Version-php-common php$PHP_Version-php-gd php$PHP_Version-php-intl php$PHP_Version-php-json php$PHP_Version-php-mbstring php$PHP_Version-php-pdo php$PHP_Version-php-pdo-dblib php$PHP_Version-php-pear php$PHP_Version-php-pecl-mcrypt php$PHP_Version-php-xmlrpc php$PHP_Version-php-xml php$PHP_Version-php-mysql php$PHP_Version-php-soap php$PHP_Version-php-pecl-zip php$PHP_Version-php-ioncube-loader php$PHP_Version-php-sqlsrv httpd firewalld mod_ssl

systemctl start firewalld

# firewall setup allow 80 and 443
for s in http https
do
    firewall-cmd --permanent --add-service=$s
done
firewall-cmd --reload

# helpful tools
yum -y install epel-release curl crontabs git unzip htop tmux

systemctl enable httpd crond php$PHP_Version-php-fpm

echo "expose_php = Off
date.timezone = Europe/Berlin
" > /etc/opt/remi/php$PHP_Version/php.d/50-custome.ini

ln -s /bin/php$PHP_Version /bin/php

echo "ServerTokens prod
ServerSignature Off

<VirtualHost *:80>
	DocumentRoot ${TARGET_DIR}public
	<Directory ${TARGET_DIR}public>
			Options -Indexes +FollowSymLinks +MultiViews
			AllowOverride All
			Order allow,deny
			allow from all
	</Directory>

	ErrorLog /var/log/httpd/page-error.log
	CustomLog /var/log/httpd/page-access.log combined
</VirtualHost>


<VirtualHost _default_:443>

DocumentRoot ${TARGET_DIR}public
<Directory ${TARGET_DIR}public>
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

mkdir -p ${TARGET_DIR}data/DoctrineModule/cache
mkdir -p ${TARGET_DIR}public
mkdir -p /var/opt/remi/php$PHP_Version/log/php-fpm

# selinux
setsebool -P httpd_can_network_connect on
restorecon -R $TARGET_DIR
chcon -t httpd_sys_rw_content_t ${TARGET_DIR}/data -R

# cache directory
chown apache:apache -R ${TARGET_DIR}/data
chmod -R 777 ${TARGET_DIR}/data

cd $TARGET_DIR
php composer.phar update


#setup crons
echo "* * * * * apache php ${TARGET_DIR}/public/index.php player-history
*/5 * * * * apache php ${TARGET_DIR}/public/index.php user-codes-cleanup
2 * * * * apache php ${TARGET_DIR}/public/index.php generate-sitemap https://www.example.io/
" > /etc/cron.d/pservercms

systemctl start httpd crond php$PHP_Version-php-fpm
