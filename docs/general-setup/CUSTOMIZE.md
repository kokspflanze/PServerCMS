# Customize

## Important

Your edits should only be in `module/Customize` or in `config`.
Its also possible to change stuff in `public`.

Never change smth on `vendor` or `module/pserver*`. If you do that, no updates are possible anymore. 

## How to change the projectname?

Go to `config/autoload/global.php` and check the configuration `server_name`. Just change `PSercerCMS` to your projectname.
To change the max-player you have to change the `max_player` value. 

## How to change the layout?

Go to `module/Customize/view`, create a `layout` directory and in this directory you have to create a file like `layout.twig` with the content of default-design @ `/module/PServerCore//view/layout/layout.twig`.
These file that you create will be your custom design, so there you can everything you need=).

example with git-bash or terminal
````bash
mkdir -p module/Customize/view/layout
cp module/PServerCore/view/layout/layout.twig module/Customize/view/layout/layout.twig
````

Now you have to register your custom layout in the config, for that you have to go to `module/Customize/config/module.config.php`, there you have to add `'layout/layout' => __DIR__ . '/../view/layout/layout.twig',`.
So the file will look like 
 
 ```php
<?php
return [
    'view_manager' => [
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.twig',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
 ```
 
These workflow will also work with other layout parts, check the PServerCMS config `module/PServerCore/config/module.config.php` at the part `template_map`.

Hint: it works also with the `module/controller/action` name if there is no alias set for a layout page.

## how to get the template alias?

In all modules, listed in `/modules/*` you can find a `config` directory with a `module.config.php` file.
In that file is also a `template_map` section where you can see the current templates, which you can overwrite. all templates have a qualified name, so you should easy understand for what if that template.

If you are note sure about the name you can also go to the view-helper, which is located in `src/MODULE/view/helper` there is a list of view-helpers, where you can see the code, that include the template_alias name again, like sidebar @  `/module/PServerCore/src/PServerCore/View/Helper/ServerInfoWidget.php`
 
## how to call a view-helper

In all modules, listed in `/modules/*` you can find a `config` directory with a `module.config.php` file.
In that file is also a `view_helpers` section with a `aliases` part, these view-helpers you can call in all templates, in `*.twig` files is the syntax like `{{ viewHelper }}` and in `*.phtml` is it like `<?= $this->viewHelper() ?>`.

please check also [laminas-guide](https://docs.laminas.dev/laminas-view/helpers/intro/)

see also [How to show icons in ranking](/general-setup/RANKING_ICONS.md)

## How to change the sliders, news&update page?

Go with the terminal or git-bash to the pserver directory.
type following.

````bash
mkdir -p module/Customize/view/p-server-core/index
cp module/PServerCore/view/p-server-core/index/index.twig module/Customize/view/p-server-core/index/index.twig
````

than you can edit the file `module/Customize/view/p-server-core/index/index.twig` to change the sliders, or other stuff.

it works with other pages too, just change the module part, controller-name and action-name.

````bash
mkdir -p module/Customize/view/[module-name]/[controller-name]
cp module/[module-name-uppercase]/view/[module-name]/[controller-name]/[action-name].twig module/Customize/view/[module-name]/[controller-name]/[action-name].twig
````
