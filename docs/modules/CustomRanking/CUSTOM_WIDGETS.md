# Custom Widgets

This guide will show you how to add own widgets with custom MSSQL-Queries

## Config

Go to the `config/autoload` directory and create `widgets.local.php` with the following content.

````php
<?php
return [
    'p-server-sro' => [
        'custom-widget' => [
            '<-- WIDGET-KEY -->' => [
                'template' => '<-- TEMPLATE -->',
                'query' => '<-- MSSQL-QUERY -->',
            ],
        ],
    ],
];
````

You have to replace `<-- WIDGET-KEY -->`, `<-- TEMPLATE -->` and `<-- MSSQL-QUERY -->`, with your data.

You can set the template to empty to use the default theme `p-server-sro/custom-widget`.

Its also possible to define more than 1 custom widget, without any limit.

## Template

````twig
{{ customWidget('<-- WIDGET-KEY -->', {'param1' : 1, 'param2': 2}, {'template' : 1, 'viewTemplate': 2})|raw }}
````

You have to use the same widget-key, that you define in the configuration.
The first params list is for your query, so you can set special filters, the other list is for your template to forward the params.