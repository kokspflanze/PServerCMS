# PServerCMS Donate setup

This guide will show you an example setup for paymentwall, payop, maxigame, paypal and payssion.

## PingBackUrls

You can find all pingback-url in the [README](/modules/PaymentAPI/README?id=pingbackurls) of the PaymentAPI

## PaymentWall

_ONLY Support for Virtual Currency!_

### Config

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
            /**
             * PublicKey
             */
            'public-key' => 'YOUR PUBLICKEY, PLEASE REPLACE ME',
            /**
             * ApiVersion, supported version atm 1,2,3
             */
            'version' => 'SET THE VERSION; WHICH YOU SET IN PAYMENTWALL',
        ],
    ],
];
```
Please set your `Secret-Key`, `Public-Key` and the `Version` that you define in the Paymentwall settings.
 
### Overwrite the current Donate-Template
 
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
    <iframe src="https://api.paymentwall.com/api/ps/?{{ paymentAPIPaymentwallWidgetUrl(user, 'WIDGET_CODE') }}&ps=p1_1" width="100%" height="800" frameborder="0"></iframe>
 {% endblock content %}
```

these is just an example how the widget looks, you have to replace the `WIDGET_CODE` part, from your created widget.

If this is done you can see the Donate widget.

### PingBack reward problem

If your pingback failed and you dont know why. Go to `Adminpanel` -> `Donate` -> `OverView` and check the first entry and in the description the `errorMessage` will help you.

If you found no entry in the table, than the pingback url is wrong.


## PayOP Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the payop parts)
 
```php
<?php
return [
    'pserver' => [
        'donate' => [
            'payop' => [
                'package' => [
                    [
                        'name' => 'foobar', // name of the package
                        'price' => 1, // price in USD
                        'value' => 100, // reward in game-amount
                    ],
                    [
                        'name' => 'foobar2', // name of the package
                        'price' => 14.2, // price in USD
                        'value' => 1420, // reward in game-amount
                    ],
                    // there is no limit of packages.
                ],
            ],
        ],
    ],
    'payment-api' => [
        'payop' => [
            'token' => '<<< YOUR TOKEN FROM PAYOP >>>',
            'public' => '<<< YOUR PUBLIC-KEY FROM PAYOP >>>',
            'secret' => '<<< YOUR SECRET-KEY FROM PAYOP >>>',
            'currency' => 'USD',
        ],
    ],
];
```

### Template

Your template must contains following

````
{% if paygoPackage %}
    <h1>Payop</h1>
    <form action="{{ url('PServerCore/panel_donate', {'action':'payop'}) }}" method="post">
        <label>Package selection</label>
        <select class="form-control" name="payop">
            {% for key, package in paygoPackage %}
                <option value="{{ key }}">{{ package['name'] }}</option>
            {% endfor %}
        </select>

        <input type="submit" value="Submit"/>
    </form>
{% endif %}
````

This is default added, only if you overwrite the template you have to add it your self.

### Testing

PayOP, dont support a testing api, so you have to test with min 1 USD on the production-system.

If you have problems, check the donate-log in the admin-panel.


## Paywant Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the paywant parts)

```php
<?php
return [
    'payment-api' => [
        'paywant' => [
            'public-key' => '<<< YOUR API-KEY FROM PAYWANT >>>',
            'secret-key' => '<<< YOUR SECRET-KEY FROM PAYWANT >>>',
        ],
    ],
];
```

### Template

Your template must contains following

````
<a href="{{ url('PServerCore/panel_donate', {'action':'paywant'}) }}">Paywant</a>
````

This is default added, only if you overwrite the template you have to add it your self.

### Testing

If you have problems, check the donate-log in the admin-panel.

## CentApp Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the paywant parts)

```php
<?php
return [
    'payment-api' => [
        'cent-app' => [
            'api-token' => '',
            'currency' => 'USD',
            'shop_id' => '',
            'payer_pays_commission' => 1,
            'packet_mapping' => [
                [
                    'name' => 'Package 1', // name of the package
                    'price' => 7.5, // price in USD
                    'value' => 1050, // reward in game-amount
                ],
                [
                    'name' => 'Package 2', // name of the package
                    'price' => 15, // price in USD
                    'value' => 2200, // reward in game-amount
                ],
            ],
        ],
    ],
];
```

### Template

Your template must contains following

````
	{% if centAppPackage %}
		<h1>CentApp</h1>
		<form action="{{ url('PServerCore/panel_donate', {'action':'centapp'}) }}" method="post">
			<label>{{ translate('Package selection') }}</label>
			<select class="form-control" name="centapp">
				{% for key, package in centAppPackage %}
					<option value="{{ key }}">{{ package['name'] }}</option>
				{% endfor %}
			</select>

			<input class="btn btn-md btn-warning" type="submit" value="Submit"/>
		</form>
	{% endif %}
````

This is default added, only if you overwrite the template you have to add it your self.

### Testing

If you have problems, check the donate-log or the general log in the admin-panel.

## Stripe Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the paywant parts)

```php
<?php
return [
    'pserver' => [
        'donate' => [
            'stripe' => [
                'package' => [
                    [
                        'hash' => 'API-ID of product',
                        'name' => 'NAME',
                        'value' => 9999, // coins reward
                    ]
                ],
            ],
        ],
    ],
    'payment-api' => [
        'stripe' => [
            'api-key' => '<< private api key >>',
            'endpoint-secret' => '<< endpoint secret >>',
            'currency' => 'USD',
        ],
    ],
];
```

### Stripe Configuration

You have to create products on the stripe page, foreach package and use the api-id of the product.
Also its important to create a webhook, to `/payment-api/stripe.html` for the event `checkout.session.completed` and `charge.refunded`.

### Template

Your template must contains following

````
	{% if stripePackage %}
		<h1>Stripe</h1>
		<form action="{{ url('PServerCore/panel_donate', {'action':'stripe'}) }}" method="post">
			<label>{{ translate('Package selection') }}</label>
			<select class="form-control" name="stripe">
				{% for key, package in stripePackage %}
					<option value="{{ key }}">{{ package['name'] }}</option>
				{% endfor %}
			</select>

			<input class="btn btn-md btn-warning" type="submit" value="Submit"/>
		</form>
	{% endif %}
````

This is default added, only if you overwrite the template you have to add it your self.

### Testing

If you have problems, check the donate-log or the general log in the admin-panel.


## Maxigame Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the maxigame parts)

```php
<?php
return [
    'pserver' => [
        'donate' => [
            'maxigame' => [
                'url' => 'https://www.maxigame.org/epin/yukle.php',
                'key' => '<<< YOUR KEY >>>',
                'secret' => '<<< YOUR SECRET >>>',
                // mapping for the amount of maxigame, if the amount is not mention in this config, it will use the amount from the api
                'package' => [
                    1 => 2,
                    5 => 6,
                    10 => 11,
                    25 => 26,
                    50 => 51,
                    75 => 76,
                    100 => 101,
                    250 => 251,
                ],
            ],
        ],
    ],
    //navigation here (optional)
];
```

### Template

Your template must contains following.
This will add a link to the maxigame form. (It would also be possible to add the link directly in the navigation)

````
<a href="{{ url('PServerPanel/maxigame') }}" class="btn btn-md btn-primary">Maxigame</a>
````

navigation config, that you could add in the `config/autoload/payment.local.php` to get a link in the account navigation
````
'navigation' => [
    'default' => [
        'account' => [
            'pages' => [
                'maxigame' => [
                    'label' => 'Maxigame',
                    'route' => 'PServerPanel/maxigame',
                    'resource' => 'PServerPanel/maxigame',
                    'icon' => 'fas fa-gamepad',
                    'order' => -10,
                ],
            ],
        ],
    ],
],
````


### Testing

Ask the Maxigame team to get test key, to test the integration.

If you have problems, check the donate-log in the admin-panel.

## HipopoTamya Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the HipopoTamya parts)

```php
<?php
return [
    'pserver' => [
        'donate' => [
            'hipopotamya' => [
                'url' => 'https://www.hipopotamya.com/api/hipocard/epins',
                'key' => '<<< YOUR KEY >>>',
                'secret' => '<<< YOUR SECRET >>>',
                // mapping for the amount of HipopoTamya, if the amount is not mention in this config, it will use the amount from the api
                'package' => [
                    1.00 => 2,
                    5.00 => 6,
                    10.00 => 11,
                    25.00 => 26,
                    50.00 => 51,
                    75.00 => 76,
                    100.00 => 101,
                    250.00 => 251,
                ],
            ],
        ],
    ],
    //navigation here (optional)
];
```

### Template

Your template must contains following.
This will add a link to the HipopoTamya form. (It would also be possible to add the link directly in the navigation)

````
<a href="{{ url('PServerPanel/hipopotamya') }}" class="btn btn-md btn-primary">HipopoTamya</a>
````

navigation config, that you could add in the `config/autoload/payment.local.php` to get a link in the account navigation
````
'navigation' => [
    'default' => [
        'account' => [
            'pages' => [
                'hipopotamya' => [
                    'label' => 'HipopoTamya',
                    'route' => 'PServerPanel/hipopotamya',
                    'resource' => 'PServerPanel/hipopotamya',
                    'icon' => 'fas fa-gamepad',
                    'order' => -10,
                ],
            ],
        ],
    ],
],
````


### Testing

Change the url in the config to `https://dev.hipopotamya.com/view/11907402/UV5RkfWH#6e25ef1f-96b9-4a3a-b20f-760ac0d75d0f` and use the codes from [here](https://dev.hipopotamya.com/view/11907402/UV5RkfWH#c4c77bc8-96a5-406c-b6f9-4e9a28a16280)

If you have problems, check the donate-log in the admin-panel.


## HipopoTamya-Payment Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the hipopotamya parts)

```php
<?php
return [
    'pserver' => [
        'donate' => [
            'hipopotamya_payments' => [
                'package' => [
                    [
                        'name' => 'foobar', // name of the package
                        'price' => 1, // price in USD
                        'value' => 100, // reward in game-amount
                    ],
                    [
                        'name' => 'foobar2', // name of the package
                        'price' => 14.2, // price in USD
                        'value' => 1420, // reward in game-amount
                    ],
                    // there is no limit of packages.
                ],
            ],
        ],
    ],
    'payment-api' => [
        'hipopotamya_payments' => [
            'url' => 'https://www.hipopotamya.com/api/v1/merchants/payment/token',
            'api-key' => '<<< YOUR API-KEY >>',
            'secret-key' => '<<< YOUR SECRET-KEY >>',
            'commission_type' => 1,
        ],
    ],
];
```

### Template

Your template must contains following

````
{% if hipopotamyaPackage %}
    <h1>Hipopotamya</h1>
    <form action="{{ url('PServerCore/panel_donate', {'action':'hipopotamya'}) }}" method="post">
        <label>{{ translate('Package selection') }}</label>
        <select class="form-control" name="hipopotamya">
            {% for key, package in hipopotamyaPackage %}
                <option value="{{ key }}">{{ package['name'] }}</option>
            {% endfor %}
        </select>

        <input class="btn btn-md btn-warning" type="submit" value="Submit"/>
    </form>
{% endif %}
````

This is default added, only if you overwrite the template you have to add it your self.

### Testing

If you have problems, check the donate-log in the admin-panel.



## Tiklaode Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the HipopoTamya parts)

```php
<?php
return [
    'pserver' => [
        'donate' => [
            'tiklaode' => [
                'url' => 'https://tiklaode.com/private/api',
                'key' => '<<< YOUR KEY >>>',
                // mapping for the amount of Tiklaode, if the amount is not mention in this config, it will use the amount from the api
                'package' => [
                    1 => 2,
                    5 => 6,
                    10 => 11,
                    25 => 26,
                    50 => 51,
                    75 => 76,
                    100 => 101,
                    250 => 251,
                ],
            ],
        ],
    ],
    //navigation here (optional)
];
```

### Template

Your template must contains following.
This will add a link to the Tiklaode form. (It would also be possible to add the link directly in the navigation)

````
<a href="{{ url('PServerPanel/tiklaode') }}" class="btn btn-md btn-primary">Tiklaode</a>
````

navigation config, that you could add in the `config/autoload/payment.local.php` to get a link in the account navigation
````
'navigation' => [
    'default' => [
        'account' => [
            'pages' => [
                'tiklaode' => [
                    'label' => 'Tiklaode',
                    'route' => 'PServerPanel/tiklaode',
                    'resource' => 'PServerPanel/tiklaode',
                    'icon' => 'fas fa-gamepad',
                    'order' => -10,
                ],
            ],
        ],
    ],
],
````


### Testing

Ask the Tiklaode team to get test key, to test the integration.

If you have problems, check the donate-log in the admin-panel.


## PayPal IPN Setup

_DON'T RECOMMENDED, PayPal allow chargebacks for virtual currencies!_

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

You have to set the PingBack URL of Paypal in your `PayPal-Account (IPN section)`.

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

### Testing

If you have problems, check the donate-log in the admin-panel.

The `packet_mapping` part map the price to the amount of coins, if there is an invalid mapping the user get zero coins.
Note payssion deliver every time with cents, so if the donation is 10USD the api deliver `10.00`, so you have to map `10.00` and not just `10`.


## CoinPayments Setup

### Config

Go to `config/autoload/payment.local.php` and add the following. (be careful, it could be possible that you have to merge your existing payment config with the paywant parts)

```php
<?php
return [
    'pserver' => [
        'donate' => [
            'coin-payments' => [
                'currency_list' => [
                    [
                        'currency' => '',
                        'address' => '',
                    ]            
                ],
                'package' => [
                    [
                        'name' => 'NAME',
                        'price' => 1,
                        'value' => 9999, // coins reward
                    ]
                ],
            ],
        ],
    ],
    'payment-api' => [
        'coin-payments' => [
            'merchant_id' => '<<< YOUR merchant_id >>>',
            'secret' => '<<< YOUR secret >>>',
            'ipn_secret' => '<<< YOUR IPN-secret >>>',
            'public-key' => '<<< YOUR public-key >>>',
            'currency' => '<<< YOUR currency >>>',
        ],
    ],
];
```

### Template

Your template must contains following

````
	{% if coinPaymentsPackage['package'] %}
		<h1>CoinPayments</h1>
		<form action="{{ url('PServerCore/panel_donate', {'action':'coin-payments'}) }}" method="post">
			<label>{{ translate('Package selection') }}</label>
			<select class="form-control" name="coins_payments">
				{% for key, package in coinPaymentsPackage['package'] %}
					<option value="{{ key }}">{{ package['name'] }}</option>
				{% endfor %}
			</select>
			<label>{{ translate('Currency') }}</label>
			<select class="form-control" name="coins_payments_currency">
				{% for key, package in coinPaymentsPackage['currency_list'] %}
					<option value="{{ key }}">{{ package['currency'] }}</option>
				{% endfor %}
			</select>

			<input class="btn btn-md btn-warning" type="submit" value="Submit"/>
		</form>
	{% endif %}
````

This is default added, only if you overwrite the template you have to add it your self.

Please contact me, for more informations.


### Testing

If you have problems, check the donate-log in the admin-panel.
