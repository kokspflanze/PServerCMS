## Git-Client download and install

 - http://git-scm.com/download/win

Install the downloaded Git-Client

## Copy the repository

go to `/c/Apache24/htdocs` and create the `pserverCMSFull` directory.
Then you have to copy the webfiles into the `pserverCMSFull` directory.

![GitClone](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/COPY.png?raw=true)
 
## Download all other parts with composer

Go with the Git-Bash to the page like `cd /c/Apache24/htdocs/pserverCMSFull` and type the following commands

```shell
php composer.phar self-update
php composer.phar update
```

That can take some minutes.
  
### Info API rate limit

 If you have a problem like that please create a GitHub account and follow the link after "Head to" in the message.
 If you later input the token, it is hidden, so you dont see a input, that is normal. 
 
Continue with [configuration for Apache](/install/windows-setup/APACHE-CONFIG.md)