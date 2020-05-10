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
('not_active', NULL, NULL),
('admin', NULL, 2);
```

### WorldMap Images

For the WorldMap you have to download the map images.

Go to your install directory windows `/c/Apache24/htdocs/pserverCMSFull` with your git-bash or with centos to `/var/www/page` in your terminal. 

````bash
curl -LO https://github.com/JellyBitz/xSROMap/archive/master.zip
unzip master.zip
mv xSROMap-master/assets/img public/assets/xSROMap/img
rm -rf master.zip xSROMap-master
````

## Finished

![Congratulation](https://i.giphy.com/xT0xezQGU5xCDJuCPe.gif)

Now the page should work, if you get an error please recheck the guide.
If you dont find the problem please [contact](/info/CONTACT.md) me.

You can now start with the features. (check also the sidebar)
 * [How to enable debugger?](/general-setup/DEBUGGER.md)
 * [access to admin-panel](/general-setup/ADMIN-PANEL-ACCESS.md)
 * [donation-setup](/general-setup/DONATE.md)
 * [cron-setup](/general-setup/CRONTAB.md)
 * [mail setup](/general-setup/MAIL.md)
 * [Customize Guides](/general-setup/CUSTOMIZE.md)
 * [Unique](/modules/PServerSROUnique/README.md)
 * [ItemPoints](/modules/SROItemPoints/README.md)
 * [How to show icons in ranking](/general-setup/RANKING_ICONS.md)