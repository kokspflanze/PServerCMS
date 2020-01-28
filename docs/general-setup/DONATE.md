# PServerCMS Donate setup

This guide will show you an example setup for paymentwall and superreward.

## PingBackUrls

You can find all pingback-url in the [README](/modules/PaymentAPI/README?id=pingbackurls) of the PaymentAPI

## Config

 Go to the `config/autoload` directory and create `payment.local.php` with the following content.
 
```php
<?php
return [
    'payment-api' => [
        'payment-wall' => [
            /**
             * SecretKey
             */
            'secret-key' => 'YOUR SECRETKEY, PLEASE REPLACE ME',
        ],
    ],
];
```
 
 Don´t forget to set the secret-key, if you don´t use one of them, than set just use a `''` as secret-key.
 
 You can test this secret-key with the pingback test of the payment-provider, in the adminpanel you can see the log, if you have problems.
 
## Overwrite the current Donate-Template
 
 Go to the `module/Customize/view` directory and create `p-server-core` and `donate`. (result: module/Customize/view/p-server-core/donate)
 
 In the donate directory you have to create a `index.twig` file, with following content.
 
```twig
 {% extends 'layout/layout' %}
 
 {% block title %}
    {{ translate('Donate') }}
 {% endblock title %}
 
 {% block content %}
	<h2>Paymentwall</h2>
	<hr />
    <iframe src="https://api.paymentwall.com/api/ps/?key=XXXXXX&uid={{ user.getId() }}&widget=XXXXXX&email={{ user.getEmail() }}&history[registration_date]={{ user.getCreated.getTimestamp }}" width="100%" height="800" frameborder="0"></iframe>
 {% endblock content %}
```

these is just an example how the widget looks, you have to replace the `XXXXXX` parts.

If this is done you can see the Donate widget.

## PingBack reward problem

If your pingback failed and you dont know why. Go to `Adminpanel` -> `Donate` -> `OverView` and check the first entry and in the description the `errorMessage` will help you.

If you found no entry in the table, than the pingback url is wrong.


## PayOP Setup

### Packages



## PayPal IPN Setup


### Install dependencies

````ssh
php composer.phar require wadeshuler/php-paypal-ipn
````

### ACL

You have to enable the PayPal workflow in the ACL. Otherwise, you will receive the error code 403 (Forbidden).

To enable it go to `config/autoload/bjyauthorize.global.php` and add following line into the `guards` section

````php
['controller' => APIController\PayPalController::class, 'roles' => []],
````

### Button

Create a button in paypal with a select-box for the `Coin options` which have different options like

- 2995
- 3999

Than we need a input-field, which will be for the `UserId`.

at the end the HTML code of the button should looks like 

````html
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="1337">
    <table>
    <tr><td><input type="hidden" name="on0" value="Coin">Coin</td></tr><tr><td><select name="os0">
	    <option value="2995">2995 - $5,00 USD</option>
	    <option value="3999">3999 - $10,00 USD</option>

    </select> </td></tr>
    <tr><td><input type="hidden" name="on1" value="UserID"></td></tr>
    <tr><td><input type="hidden" name="os1" value="{{ user.getId() }}" maxlength="200"></td></tr>
    </table>
    <br>
    <input type="hidden" name="currency_code" value="USD">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
    </form>
````

you have to change it a bit (the above example already has the changes)

- change the UserID input to hidden
- set the UserID value to `{{ user.getId() }}`
- you can also change the option text of the select-box but not the value

put these html-form in to the content section of the `Donate-Template`.

### IPN

You have to set the PingBack URL of Paypal in your `PayPal-Account (IPN section)`, which you can find [here](/modules/PaymentAPI#pingbackurls).

### Config

Go to `config/autoload/payment.local.php` and add the following.
 
```php
<?php
return [
    'payment-api' => [
        'pay-pal' => [
            /**
             * your paypal email
             */
            'receiver_email' => '<-- YOUR PAYPAL-ACCOUNT-MAIL -->',
            /**
             * receiver currency
             */
            'payment_currency' => '<-- YOUR CURRENCY OF THE BUTTON LIKE USD OR EU -->',
            /**
             * map a packet name to a amount of coins
             */
            'packet_mapping' => [],
            'sandbox' => false,
        ],
    ],
];
```

The `packet_mapping` part map the value of the of the section option to the reward coins, if there is no mapping (realy-empty), the value will be used as reward.
If there is a mapping but no match, the value will be zero.

## Payssion Setup

### Dependencies

create a account [here](https://payssion.com/register) for live, [this](http://sandbox.payssion.com/register) is for testing.

create a new direct-api app [here](http://sandbox.payssion.com/account/app/add/directapi).

in the notify url input box you have to add following ``http://www.example.com/payment-api/payssion.html`` (`http://www.example.com`, this you have to replace with yours). 

this should look like this
![ScreenShot](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/payssion.png)

### ACL

You have to enable the Payssion workflow in the ACL. Otherwise, you will receive the error code 403 (Forbidden).

To enable it go to `config/autoload/bjyauthorize.global.php` and add following line into the `guards` section

````php
['controller' => APIController\PayssionController::class, 'roles' => []],
````

### IFrame integration

````html
 <iframe src="https://www.payssion.com/checkout/<-- YOUR API KEY -->?api_sig={{ paymentAPIPayssionSecret('<-- PRICE -->', '<-- CURRENCY -->', user.getId()) }}&order_id={{ user.getId() }}&payer_email={{ user.getEmail() }}&description=<-- DESCRIPTION -->&amount=<-- PRICE -->&currency=<-- CURRENCY -->"  frameborder="0" width="728" height="700" scrolling="yes"></iframe>
````

PS: if you use the test system please use following url `https://sandbox.payssion.com/checkout`.

you have to replace it with your values

- `<-- YOUR API KEY -->` as example `live_FOOBAR`
- `<-- PRICE -->` as example `10.00`
- `<-- CURRENCY -->` as example `USD`
- `<-- DESCRIPTION -->` as example `1000 COINS`

put these html-form in to the content section of the `Donate-Template`.

### Config

Go to `config/autoload/payment.local.php` and add the following.
 
```php
<?php
return [
    'payment-api' => [
        'payssion' => [
            'api_key' => '<-- YOUR API KEY -->',
            'secret_key' => '<-- YOUR API SECRET -->',
            /**
             * map the payment-amount to game-amount
             *
            'packet_mapping' => [
                '10.00' => 1000,
                '0.01' => 1,
                '4.00' => 400,
             ],
             * so if you pay 10USD you will get 1000 coins
             */
            'packet_mapping' => [],
        ],
    ],
];
```

The `packet_mapping` part map the price to the amount of coins, if there is an invalid mapping the user get zero coins.
Note payssion deliver every time with cents, so if the donation is 10USD the api deliver `10.00`, so you have to map `10.00` and not just `10`.