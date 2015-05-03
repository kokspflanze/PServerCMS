# PSeverCMS Module for Zend Framework 2

Master
[![Build Status](https://travis-ci.org/kokspflanze/PServerCMS.svg?branch=master)](https://travis-ci.org/kokspflanze/PServerCMS?branch=master)
[![Coverage Status](https://coveralls.io/repos/kokspflanze/PServerCMS/badge.svg?branch=master)](https://coveralls.io/r/kokspflanze/PServerCMS?branch=master)

## SYSTEM REQUIREMENTS

requires PHP 5.4 or later; we recommend using the latest PHP version whenever possible.

## INSTALLATION

### Composer

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
php composer.phar require kokspflanze/p-server-cms
# (When asked for a version, type `dev-master`)
```

Then add `ZfcTwig`, `ZfcBase`, `ZfcDatagrid`, `DoctrineModule`, `DoctrineORMModule`, `PDODblibModule`, `BjyAuthorize`, `GameBackend`, `ZfcTicketSystem`,
`ZfcBBCode`, `SanCaptcha`, `PaymentAPI`, `SmallUser`, `PServerCMS`, `PServerAdmin`, `PServerRanking`, `PServerPanel` and `PServerCLI`
 to your `config/application.config.php` and create directory
`data/cache`, `data/PaymentAPI`, `data/DoctrineORMModule`, `data/ZfcDatagrid` and make sure your application has write access to it.

Installation without composer is not officially supported and requires you to manually install all dependencies
that are listed in `composer.json`

### Generate the Database

```sh
php ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:schema-tool:create
```

### Create the Roles

```sql
INSERT INTO `user_role` (`id`, `role_id`, `is_default`, `parent_id`) VALUES
	(1, 'guest', NULL, NULL),
	(2, 'user', NULL, NULL),
	(3, 'admin', NULL, NULL);
```

## Example Application

You can find an example application with some default styles and full configuration @ [kokspflanze/pserverCMSFull](https://github.com/kokspflanze/pserverCMSFull)

![ScreenShot](https://raw.github.com/kokspflanze/PServerCMS/master/docs/screenshots/news.png)

You can find some screenshots @ [screenshot-directory](https://github.com/kokspflanze/PServerCMS/blob/master/docs/screenshots)

## Features

- News (modification in admin-panel)
- ServerInfo (modification in admin-panel) include PlayerOnline
- ServerTimes (modification in config)
- Download (modification in admin-panel)
- Ranking (TopGuild|TopPlayer) with detail pages
- ServerInfoPages (modification in admin-panel, possible to add more dynamic)
- Register (with mail confirmation, 2 pw system, secret question [optional, you can change that option in config])
- lost Password
- Donate (PaymentWall and Superreward, in default added)
- TicketSystem (with bb-code)
- AccountPanel (to change the web/ingame password)
- CharacterPanel (to show current status of a character)
- AdminPanel with UserPanel, DonateStatistic, view Logs, edit different parts in page
- easy to change the web, admin and email layout

## PHP Extensions

- php5-curl
- php5-intl

## CronTab settings

To improve the performance

```php
* * * * * php /[install-path]/public/index.php player-history
*/5 * * * * php /[install-path]/public/index.php user-codes-cleanup
```

## Problems or improvements

Please write an issue or create a pull-request @ GitHub