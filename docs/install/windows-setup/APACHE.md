## Setup basic Apache with default PHP

 Use the CommandlineTool and go to the apache/bin directory and type `httpd -k install` as administrator. than you can start the 
 ApacheMonitor to check if the Apache24 is listed and can be start.
 
 ![ApacheInstall](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/apache-install.png)
 
 Now you have to add the following lines in your Apache `httpd.conf` (you can find it in the `conf` directory).
 
 ```ini
 LoadModule php7_module "c:/PHP/php7apache2_4.dll"
 <FilesMatch \.php$>
       SetHandler application/x-httpd-php
  </FilesMatch>
 
 # configure the path to php.ini
 PHPIniDir "C:/PHP"
 ```
 
 You you have to restart your Apache, to test if the PHP works.
 
 ![ApacheSetup](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/apache-setup.gif?raw=true)

## PHP Settings

### Enable PHP extensions
 
 Rename the `php.ini-production` in `php.ini` in your PHP-Directory.
 
 Add the following things in your `php.ini` file.
 
 ```ini
 extension_dir = "c:\PHP\ext"
 extension=php_bz2.dll
 extension=php_curl.dll
 extension=php_fileinfo.dll
 extension=php_gd2.dll
 extension=php_intl.dll
 extension=php_mbstring.dll
 extension=php_exif.dll      ; Must be after mbstring as it depends on it
 extension=php_openssl.dll
 extension=php_pdo_mysql.dll ; if you work with a mysql DB
 extension=php_sockets.dll
 extension=php_pdo_sqlsrv_73_ts.dll ; if you work with a mssql DB 
 ```
 
 If you work with a MsSQL DB you have to copy the `x64/php_pdo_sqlsrv_73_ts.dll` from the download above, to the `ext` directory from your PHP.
 
 ![PHPExtensions](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/php-extensions.gif?raw=true)
 
### DateTime settings
 
 You have to set a valid DateTimeZone, search in your `php.ini` the config entry `date.timezone` and 
 set it to your favorite timezone [Timezone-List](http://php.net/manual/en/timezones.php). Please check that before the config is no `;`.
 
 ![ApacheInstall](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/php-datetime.png)
 
### Curl CAInfo [optional]

_**REQUIRED for PayOP**_

 [Guide StackOverflow](http://stackoverflow.com/questions/21114371/php-curl-error-code-60#answer-21114601)
 
 Download the content of https://curl.haxx.se/ca/cacert.pem and save it under `c:\PHP\cacert.pem`. Please check that you dont add a `txt` extension in the filename.
 Than add `curl.cainfo = "C:\PHP\cacert.pem"` in your php.ini

### Ioncube

You have to download the loader from [Ioncube](https://www.ioncube.com/loaders.php), select `Windows VC15 (64 bits)` or a newer version.
Copy the `ioncube_loader_win_7.3.dll` to your `ext` directory from your PHP.

Now you have to add the `ioncube-key`, this line you will get from me. You just have to enable ioncube and add config part in your `php.ini`.

````
zend_extension = ioncube_loader_win_7.3.dll
ioncube.loader.key.pservercms = [ioncube-key]
````

as example a valid line could looks like, `dfg3egsg34g4gdfg` this is what you get from me as `ioncube-key`
````
zend_extension = ioncube_loader_win_7.3.dll
ioncube.loader.key.pservercms = dfg3egsg34g4gdfg
```` 

### PHP-Path in Environment Variables
 
 In Control Panel -> Search -> Advanced System Settings and use the button Environment Variables. 
 Under System Variables find Path add the `c:/PHP` folder (or whatever path) and restart Apache.
 
 IMPORTANT:
  - you have to use a `;` as delimiter (only on older windows systems)
  - restart your computer or close the Apache2 and the ApacheMonitor and start it again 
  
 ![PHPPathEnv](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/php-path-env.gif?raw=true)
 
Continue with [GIT](/install/windows-setup/GIT.md)
