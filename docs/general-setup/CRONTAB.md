# Crontab-Setup

You have to add following crons.

```php
* * * * * php /[install-path]/public/index.php player-history
*/5 * * * * php /[install-path]/public/index.php user-codes-cleanup
```

if you run the page on centos, it is automatic added in the install-script, if you work on windows, you have to work with the [`Task Sheduler`](/install/windows-setup/TASK_SHEDULER.md).


## Recommend

```php
2 * * * * php /[install-path]/public/index.php generate-sitemap https://example.io/ #to create the sitemap
```

Change `https://example.io/` to your own Domain