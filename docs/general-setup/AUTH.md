# Disable pages

This guide will show you how to disable pages, with few examples

## Why disable pages?

There are different reasons to disable pages like donation or register:
- take a backup
- restore a backup
- server inspection
- database updates
- ....

## How it works?

Its simple, you have to work with the auth-system. Like you add new modules and rights for these modules.

### examples

All examples show the changes in the `config/autoload/bjyauthorize.global.php` file.
The examples based on the original file, if you already work in the auth-system, it could be bit different.

#### login/register

search for `['guest', 'small-user-auth', 'index'],`, `['controller' => CoreController\AuthController::class, 'roles' => ['guest', 'user']],` and `['controller' => 'SmallUser\Controller\Auth', 'roles' => ['guest', 'user']],`

now change

`['guest', 'small-user-auth', 'index'],` 
to
`['admin', 'small-user-auth', 'index'],` 

now remove
`['controller' => CoreController\AuthController::class, 'roles' => ['guest', 'user']],`, `['controller' => 'SmallUser\Controller\Auth', 'roles' => ['guest', 'user']],`

#### donate 

search for `[['user'], 'PServerCore/panel_donate'],` and `['controller' => CoreController\DonateController::class, 'roles' => ['user']],`

now change

`[['user'], 'PServerCore/panel_donate'],` 
to
`[['admin'], 'PServerCore/panel_donate'],` 

and

`['controller' => CoreController\DonateController::class, 'roles' => ['user']],` 
to
`['controller' => CoreController\DonateController::class, 'roles' => ['admin']],`

now you can see donation only as admin