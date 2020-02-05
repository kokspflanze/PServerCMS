## PServerCMS basic configuration

Go to the `config/autoload` directory and create `[GAME].local.php` with the content of `[GAME].example.php`. Now you have to edit the 
configuration with the sql connect´s and other parts like mail and and and, you can find some other parts in `PServerCMS-Config` (module/PServerCore/config/module.config.php)

PS: You have to create the web-database by your self, the scripts of the p-server-cms will just add the tables, but will not create the database.
  
![BasicConfig](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/basic-config.gif?raw=true)

## Start with the PServerCMS ToDo-List

### Generate the Database

Go to your install directory windows `/c/Apache24/htdocs/pserverCMSFull` with your git-bash or with centos to `/var/www/page` in your terminal. 

```sh
php ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:schema-tool:create
```

if you get an error, try

```sh
php ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:schema-tool:create --dump-sql
```

and create with the response the tables.
Before you do that delete the current tables. 

### Create the Roles

You have to execute this in your SQL-Client (SQL Management or HeidiSQL, ...)

```sql
INSERT INTO user_role (role_id, is_default, parent_id) VALUES
('guest', NULL, NULL),
('user', NULL, NULL),
('admin', NULL, 2);
```

## Finished

if everything done, the page works and you can start with [customize](/#customize-guides) the system.
