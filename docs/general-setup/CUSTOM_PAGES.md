# How to add custom-pages (refund, privacy ...)

Sometimes you have to add custom pages for refund, privacy or example or smth else.

You just have to create following file in `config/autoloag/pages.local.php`.

````text
<?php
return [
    'pserver' => [
        'pageinfotype' => [
            'TYPE',
        ],
    ],
    'navigation' => [
        'pserveradmin' => [
            'admin_settings' => [
                'pages' => [
                    'refund' => [
                        'label' => 'TYPE',
                        'route' => 'PServerAdmin/settings',
                        'params' => [
                            'action' => 'pageInfo',
                            'type' => 'TYPE',
                        ],
                        'resource' => 'PServerAdmin/settings',
                    ],
                ],
            ],
        ],
    ],
];
````
PS: This is an example for one static link on the page, you can add it n times.

Now you have to edit the page in the Adminpanel. If you dont add some text on these pages, they redirect the user to the index-page.

Now you have to add the link from the Page to the site.

You can add it like `{{ url('PServerCore/site-detail', {'type':'TYPE'}) }}`.

If you want it on the navigation, like the other pages you have to add following in the navigation section of `config/autoloag/pages.local.php` .

````text
'default' => [
    'server-info' => [
        'pages' => [
            'TYPE' => [
                'label' => 'TYPE',
                'route' => 'PServerCore/site-detail',
                'params' => [
                    'type' => 'TYPE',
                ],
                'resource' => 'PServerCore/site-detail',
            ],
        ],
    ],
],
````

PS: this is an example with `TYPE`, its recommended to write it lowercase for the URL´s `type`. Only in the `label` it can be written with upper characters.