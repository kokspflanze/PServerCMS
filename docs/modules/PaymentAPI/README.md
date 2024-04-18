# PaymentAPI

## Config

Please check the `config/module.config.php` for the config entries.

## Supported PingBackApi´s

- Paymentwall
- PayPal IPN
- Payssion
- Payop
- Paywant

You can easy add more with a new controller and a new provider, and create a pull-request to share the ping-back-provider with other 
people.

## PingBackUrls

- Paymentwall
	- Route `PaymentApi/payment-wall-server`
	- URL `/payment-api/payment-wall-response.html`

- PayPal
    - Route `PaymentApi/pay-pal`
    - URL `/payment-api/pay-pal.html`

- Payssion
    - Route `PaymentApi/payssion`
    - URL `/payment-api/payssion.html`

- Payop
    - Route `PaymentApi/payop`
    - URL `/payment-api/payop.html`

- Paywant
    - Route `PaymentApi/paywant`
    - URL `/payment-api/paywant.html`

- CoinPayment
    - Route `PaymentApi/coin-payments`
    - URL `/payment-api/coin-payments.html`

- HipopoTamya
    - Route `PaymentApi/hipopotamya-payments`
    - URL `/payment-api/hipopotamya-payments.html`

## How to give different reward´s for request 

```php
	return [
		'service_manager' => [
			'aliases' => [
				/**
				 * must be instance of \PaymentAPI\Service\LogInterface
				 */
				'payment_api_log_service' => PaymentAPI\Service\Log::class,
			],
		],
	];
```

change the `payment_api_log_service` service to your custom service-manager.
Please check that it implements `\PaymentAPI\Service\LogInterface`.
