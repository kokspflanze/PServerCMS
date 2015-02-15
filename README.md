# PSeverCMS Module for Zend Framework 2

## SYSTEM REQUIREMENTS

requires PHP 5.4 or later; we recommend using the
latest PHP version whenever possible.

## INSTALLATION

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
php composer.phar require kokspflanze/p-server-cms
# (When asked for a version, type `dev-master`)
```

Then add `ZfcTwig`, `ZfcUser`, `ZfcBase`, `DoctrineModule`, `DoctrineORMModule`, `PDODblibModule`, `BjyAuthorize`, `GameBackend`, `ZfcTicketSystem`,
`ZfcBBCode`, `PaymentAPI`, `SmallUser`, `PServerCMS`, `PServerAdmin` and `PServerCLI`
 to your `config/application.config.php` and create directory
`data/cache`, `data/PaymentAPI` and make sure your application has write access to it.

Installation without composer is not officially supported and requires you to manually install all dependencies
that are listed in `composer.json`

## CronTab settings

To improve the performance

```php
* * * * * php /[install-path]/public/index.php player-history
```