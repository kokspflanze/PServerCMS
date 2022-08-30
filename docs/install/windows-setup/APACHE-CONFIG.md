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

For SSL support, like cloudflare SSL-Full mode you need also the following setting.
With SSL-Flexible it is not required.

Remove everything in `httpd-ssl.conf` and add the following, in the `conf/extra` directory.
````ini
Listen 443

SSLPassPhraseDialog  builtin

SSLSessionCache        "shmcb:${SRVROOT}/logs/ssl_scache(512000)"
SSLSessionCacheTimeout  300

##
## SSL Virtual Host Context
##

<VirtualHost _default_:443>

#   General setup for the virtual host
DocumentRoot "${SRVROOT}/htdocs/pserverCMSFull/public"

<Directory "${SRVROOT}/htdocs/pserverCMSFull/public">
   Options Indexes FollowSymLinks MultiViews
   AllowOverride All
   Require all granted
</Directory>

ServerAdmin admin@example.com
ErrorLog "${SRVROOT}/logs/ssl_error.log"
TransferLog "${SRVROOT}/logs/ssl_access.log"

#   SSL Engine Switch:
#   Enable/Disable SSL for this virtual host.
SSLEngine on
SSLCipherSuite ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP:+eNULL
SSLCertificateFile "${SRVROOT}/conf/server.crt"
SSLCertificateKeyFile "${SRVROOT}/conf/server.key"

</VirtualHost>                                  
````
 ![ApacheVHost](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/apache-vhost.gif?raw=true)
 
Continue with [config](/general-setup/CONFIG.md)
