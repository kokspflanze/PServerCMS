# DonateAction
DonateAction to support more rewards

## FEATURES

- DonateStats, donate level, to get more coins each donate
- DailyCashCounter, if a day limit reached, each new donate get more coins, until 0:00
- MonthlyCashCounter, if a monthly limit reached, each new donate get more coins, from 1 of month 00:00 to the next

## INSTALLATION

### Config

Go to `config/application.config.php`and add `PServerCMS\DonateAction` in the `modules` section.

### DonateAction ACL

In order to make the donate-state page accessible we have to edit the ACL file, to do so open ```config/autoload/bjyauthorize.global.php```

at the beginning of the file you will have to add the namespace right after your last one.

```php
use PServerCMS\DonateAction\Controller as DonateAction;
```
Now we have to add resources so under the resource_providers add:

```php
'PServerCMSDonateAction/stats' => [],
``` 
Then let’s add some rule providers in order to setup permissions. Let’s head to rule_providers and add these lines

```php
[['user'], 'PServerCMSDonateAction/stats'],
```

The last thing you have to do is to setup the usage of the controllers, and to do this let’s head to guards and add these lines:

```php
['controller' => DonateAction\StatsController::class, 'roles' => []],
```

## Config 

### DonateStats

check config key `donate-level`

Important at this config is the order, you have to add the levels from lowest to highest like

````php
[
    'name' => 'Level 1',
    'amount' => 1000,
    'percent' => 5,
],
[
    'name' => 'Level 2',
    'amount' => 2000,
    'percent' => 10,
],
````


### DailyCashCounter

check config key `daily-cash-counter`

You have to enable the config with `'enable' => true`, also you have to set the limit with `'amount' => 9999`.
If the limit is reached, the player get a more coins, this value you have to configure with `'percent' => 1.54`.

There is also a way to show the current amount of coins and the limit with following view-helper.

````php
<?= $this->dailyCashCounterWidget() ?>
````

### MonthlyCashCounter

check config key `monthly-cash-counter`

You have to enable the config with `'enable' => true`, also you have to set the limit with `'amount' => 9999`.
If the limit is reached, the player get a more coins, this value you have to configure with `'percent' => 1.54`.

There is also a way to show the current amount of coins and the limit with following view-helper.

````php
<?= $this->monthlyCashCounterWidget() ?>
````

