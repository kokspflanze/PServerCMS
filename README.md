# PSeverCMS Module for Zend Framework 2

[![Join the chat at https://gitter.im/kokspflanze/PServerCMS](https://badges.gitter.im/kokspflanze/PServerCMS.svg)](https://gitter.im/kokspflanze/PServerCMS?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## SYSTEM REQUIREMENTS

requires PHP 5.5 or later; we recommend using the latest PHP version whenever possible.

## INSTALLATION

### Composer

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
php composer.phar require kokspflanze/p-server-cms
# (When asked for a version, type `dev-master`)
```

Then add `ZfcTwig`, `ZfcBase`, `ZfcDatagrid`, `DoctrineModule`, `DoctrineORMModule`, `PDODblibModule`, `BjyAuthorize`, `GameBackend`, `ZfcTicketSystem`,
`ZfcBBCode`, `SanCaptcha`, `PaymentAPI`, `SmallUser`, `PServerCore`, `PServerAdmin`, `PServerAdminStatistic`, `PServerRanking`, `PServerPanel` and `PServerCLI`
 to your `config/application.config.php` and create directory
`data/cache`, `data/PaymentAPI`, `data/DoctrineORMModule`, `data/ZfcDatagrid` and make sure your application has write access to it.

Installation without composer is not officially supported and requires you to manually install all dependencies
that are listed in `composer.json`

### Generate the Database

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

```sql
INSERT INTO user_role (role_id, is_default, parent_id) VALUES
    ('guest', NULL, NULL),
    ('user', NULL, NULL),
    ('admin', NULL, NULL);
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
- Register (with mail confirmation, 2 pw system [different pws for ingame and web])
- SecretQuestionSystem (possible to enable it in the config, and set the question in the admin panel)
- SecretLogin (you can define different roles, which has to confirm there mail before they can login)
- lost Password
- Donate ([PaymentWall](https://www.paymentwall.com), [Superrewards](http://superrewards.com/) and [xsolla](http://xsolla.com/), in default added)
- TicketSystem (with bb-code) change TicketCategories in the Adminpanel
- AccountPanel (to change the web/ingame password)
- CharacterPanel (to show current status of a character, set main character[alias for ticket-system])
- AdminPanel with UserPanel, DonateStatistic, view Logs, edit different parts in page
- BlockHistory in AdminPanel + little widget in UserDetail
- Vote4Coins (modification in admin-panel)
- RoleSystem, its possible to add more roles with different permissions
- show current online player as an image for threads `/info/online-player.png`
- easy to change the web, admin and email layout

## PHP Extensions

- php5-curl
- php5-intl
- php5-gd

## CronTab settings

To improve the performance

```php
* * * * * php /[install-path]/public/index.php player-history
*/5 * * * * php /[install-path]/public/index.php user-codes-cleanup
```

## Donation

- Paymentwall default link => `/payment-api/payment-wall-response.html`
- Superreward default link => `/payment-api/super-reward-response.html`
- xsolla default link => `/payment-api/xsolla.html`

Please check the config with the key `payment-api` to setup the secret-keys, ban-time and more.

Also check the PaymentAPI extension for more information https://github.com/kokspflanze/PaymentAPI

## Problems or improvements

Please write an issue or create a pull-request @ GitHub