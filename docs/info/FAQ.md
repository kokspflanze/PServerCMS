# Frequently Asked Questions

## Could not be decoded as an encoding key was not found
You have to set a `ioncube-key` in your php.ini, or its the wrong key.

example in your php.ini
````
ioncube.loader.key.pservercms = dfg3egsg34g4gdfg
````

## You get a white page with a HTTP-Code 500

Check your Webserver `error-log`
possible error, roles not added [Create the Roles](http://localhost:3000/#/general-setup/CONFIG?id=create-the-roles)


## Application error on page

Enable the debugger to see the error [How to enable debugger?](/general-setup/DEBUGGER.md)

## How to get Admin to the Admin-Panel

[How to get access to the AdminPanel?](/general-setup/ADMIN-PANEL-ACCESS.md)

## How to wipe database?

### Rankings
1. To wipe the rankings, it depends on your modules. this example has ALL tables, so check which tables you have.

Shard:
````sql
TRUNCATE TABLE [dbo].[_UniqueKillList];
TRUNCATE TABLE [dbo].[_UniqueRanking];
UPDATE dbo._Char SET ItemPoints = 0;
UPDATE dbo._Guild SET ItemPoints = 0;
````

LOG:
````sql
TRUNCATE TABLE [dbo].[_KillDeathCounter];
TRUNCATE TABLE [dbo].[_KillHistory];
````

### Users
2. clean pserverCMS DB (mySQL), please change it for mssql
````mysql
SET foreign_key_checks = 0;
TRUNCATE TABLE donate_log;
TRUNCATE TABLE ip_block;
TRUNCATE TABLE login_failed;
TRUNCATE TABLE login_history;
TRUNCATE TABLE logs;
TRUNCATE TABLE news;
TRUNCATE TABLE secret_answer;
TRUNCATE TABLE ticket_entry;
TRUNCATE TABLE ticket_subject;
TRUNCATE TABLE user;
TRUNCATE TABLE user2role;
TRUNCATE TABLE user_alias;
TRUNCATE TABLE user_block;
TRUNCATE TABLE user_codes;
TRUNCATE TABLE user_extension;
TRUNCATE TABLE vote_history;
SET foreign_key_checks = 1;
````