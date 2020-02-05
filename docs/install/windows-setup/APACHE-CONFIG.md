# Configuration for Apache

 Add the following things in your `httpd.conf` file.

 ```ini
 LoadModule rewrite_module modules/mod_rewrite.so
 LoadModule vhost_alias_module modules/mod_vhost_alias.so
 
 # Virtual hosts
 Include conf/extra/httpd-vhosts.conf
 ```
 
 Change `DocumentRoot "c:/Apache24/htdocs"` to `DocumentRoot "c:/Apache24/htdocs/default"` and create the `default` directory in `htdocs`.
 
 Also you have change
 
 ```ìni
<IfModule dir_module>
	DirectoryIndex index.html
</IfModule>
 ```
 
 to
 
 ```ìni
<IfModule dir_module>
	DirectoryIndex index.html index.php
</IfModule>
 ```
 
 Remove everything in `httpd-vhosts.conf` and add the following, in the `conf/extra` directory.
  
 ```ini
<VirtualHost *:80>
	DocumentRoot "${SRVROOT}/htdocs/pserverCMSFull/public"
	
	<Directory "${SRVROOT}/htdocs/pserverCMSFull/public">
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
 ```
 ![ApacheVHost](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/apache-vhost.gif?raw=true)
 
Continue with [config](/general-setup/CONFIG.md)
