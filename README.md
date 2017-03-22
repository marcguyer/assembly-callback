# Assembly Payments Callback Objects

A structured set of objects designed to enable some abstraction handling of [Assembly Payments Callback](https://docs.assemblypayments.com/feature-guides/guides/callbacks/) payloads.

## Install

```sh
composer require assembly-callback
```

## Usage Example

### Basic Usage

Basic usage simply instantiates a new Callback object of the type provided by your listener.

```php
use Assembly\Callback;

// get the request body in your preferred way
$requestBody = file_get_contents("php://input");

// use the factory to create an object of the proper type
$callback = Callback\CallbackFactory::factory($requestBody);
```

### With Payload Validation

You may optionally use the validation feature which requires the availability of the [stock SDK](https://github.com/PromisePay/promisepay-php) by default. This uses the `id` from the callback payload to request the same object from the Assembly API according the the object type.

```php
use Assembly\Callback;
use PromisePay\PromisePay;

// get the request body in your preferred way
$requestBody = file_get_contents("php://input");

// use the factory to create an object of the proper type
$callback = Callback\CallbackFactory::factory($requestBody);

// config the PromisePay client
PromisePay::Configuration()->environment('prelive');
PromisePay::Configuration()->login('<username>');
PromisePay::Configuration()->password('<api key>');

// validate the callback
$callback->validate();
```

### Extend a Callback Type

You may want to add some functionality to an object. To do that, you can define your own type handler.

#### Example extension

```php
use Assembly\Callback\Transaction;

class MyTransaction extends Transaction
{
    public function someSpecialHandling() {
        // do something extra special
    }
}
```

#### Use the extension

```php
use Assembly\Callback;

// get the request body in your preferred way
$requestBody = file_get_contents("php://input");

// when the type is "transactions", use this extention
Callback\CallbackFactory::registerType(
    'transactions',
    'My_Assembly_Callback_Transaction'
);

// use the factory to create an object of the proper type
$callback = Callback\CallbackFactory::factory($requestBody);
```

## Contribute

Pull Requests are encouraged. [Learn how](https://guides.github.com/activities/contributing-to-open-source/#contributing)
