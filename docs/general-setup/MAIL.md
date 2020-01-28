# How to send mails

This guide will show you how to send mails with a external SMTP-Server.

## Config

Go to the `config/autoload` directory and create `mail.local.php` with the following content.

````php
<?php
return [
    'pserver' => [
        'mail' => [
            'from' => '<-- YOUR mail address -->',
            'from_name' => 'Project',
            'basic' => [
                'name' => 'localhost',
                'host' => '<-- YOUR SMTP-Host -->',
                'port' => 587,
                'connection_class' => 'login',
                'connection_config' => [
                    'username' => '<-- YOUR username -->',
                    'password' => '<-- YOUR password -->',
                    'ssl'=> 'tls',
                ],
            ],
        ],
    ],
];
````

You have to replace `<-- YOUR mail address -->`, `<-- YOUR SMTP-Host -->`, `<-- YOUR username -->` and `<-- YOUR password -->`, with your data.

Its also possible that you have to change the `port` and the `ssl` property, this depends on your provider.

## SMTP Server provider

just an example, all provider works, where you can send mails with thunderbird/outlook

- [GMX](https://www.gmx.com/)
- [namecheap](https://www.namecheap.com/hosting/email.aspx)
- [HostGator](http://www.hostgator.com/)
- ....

## Example Config with namecheap

````php
<?php
return [
    'pserver' => [
        'mail' => [
            'from' => 'noreply@namecheap.com',
            'from_name' => 'Project',
            'basic' => [
                'name' => 'localhost',
                'host' => 'mail.privateemail.com',
                'port' => 587,
                'connection_class' => 'login',
                'connection_config' => [
                    'username' => 'noreply@namecheap.com',
                    'password' => 'secret',
                    'ssl'=> 'tls',
                ],
            ],
        ],
    ],
];
````

## Problems?

If you receive no mail, you can go to the `AdminPanel / Logs / Web` there you see all errors.

if you get `Could not read from XXX`, following parts are possible
- network problem (check your firewall)
- tls/ssl problem? switch `'port' => 587,` to `'port' => 465,` and `'ssl'=> 'tls',` to `'ssl'=> 'ssl',`
- try to ping the mail host from your webserver