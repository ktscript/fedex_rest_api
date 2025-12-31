# FedEx REST API

PHP package for integrating with FedEx REST API. This package provides a simple and intuitive interface for working with FedEx services including tracking, shipping, and address validation.

## Features

- 🚀 **Easy Integration** - Simple, fluent API for interacting with FedEx services
- 🔐 **OAuth 2.0 Support** - Built-in authorization handling
- 📦 **Shipping Labels** - Create shipping labels and track packages
- 📍 **Address Validation** - Validate addresses using FedEx API
- 🔄 **Environment Switching** - Switch between sandbox and production environments easily
- 🎯 **Laravel Compatible** - Works seamlessly with Laravel 7-12+ using Conditionable trait
- 🔧 **Fluent Interface** - Chainable methods for building requests

## Requirements

- PHP >= 7.2.5
- Laravel 7-12+ (or illuminate/support package)
- Guzzle HTTP Client ^6|^7
- JSON extension

## Installation

Install the package via Composer:

```bash
composer require ktscript/fedex-rest
```

## Configuration

### Getting FedEx API Credentials

1. Register for a FedEx Developer account at [FedEx Developer Portal](https://developer.fedex.com/)
2. Create a new application to get your `client_id` and `client_secret`
3. Choose between sandbox (testing) or production environment

## Usage

### Authorization

First, you need to obtain an access token using your FedEx credentials:

```php
use FedexRest\Authorization\Authorize;

$authorize = new Authorize();
$authorize->setClientId('your_client_id')
    ->setClientSecret('your_client_secret')
    ->useProduction() // Use production environment (optional, defaults to sandbox)
    ->authorize();

$token = $authorize->access_token;
```

### Tracking Packages

Track one or multiple packages by tracking number:

```php
use FedexRest\Services\Track\TrackByTrackingNumberRequest;

$tracking = new TrackByTrackingNumberRequest();
$tracking->setAccessToken($token)
    ->setTrackingNumber('1234567890') // Single tracking number
    ->includeDetailedScans() // Optional: include detailed scan information
    ->useProduction() // Optional: use production environment
    ->request();

// Or track multiple packages
$tracking->setTrackingNumber(['1234567890', '0987654321'])
    ->request();
```

### Creating Shipping Labels

Create shipping labels for packages:

```php
use FedexRest\Services\Ship\CreateTagRequest;
use FedexRest\Entity\Person;
use FedexRest\Entity\Address;
use FedexRest\Entity\Item;
use FedexRest\Entity\Weight;
use FedexRest\Services\Ship\Type\ServiceType;
use FedexRest\Services\Ship\Type\PackagingType;
use FedexRest\Services\Ship\Type\PickupType;

// Create shipper address
$shipperAddress = new Address();
$shipperAddress->setStreetLines('123 Main St')
    ->setCity('Memphis')
    ->setStateOrProvince('TN')
    ->setPostalCode('38116')
    ->setCountryCode('US');

// Create shipper
$shipper = new Person();
$shipper->setPersonName('John Doe')
    ->setPhoneNumber(1234567890)
    ->withAddress($shipperAddress);

// Create recipient address
$recipientAddress = new Address();
$recipientAddress->setStreetLines('456 Oak Ave')
    ->setCity('Los Angeles')
    ->setStateOrProvince('CA')
    ->setPostalCode('90001')
    ->setCountryCode('US');

// Create recipient
$recipient = new Person();
$recipient->setPersonName('Jane Smith')
    ->setPhoneNumber(9876543210)
    ->withAddress($recipientAddress);

// Create item weight
$weight = new Weight();
$weight->setUnit('LB')
    ->setValue(5);

// Create item
$item = new Item();
$item->setItemDescription('Sample Product')
    ->setWeight($weight);

// Create shipping label
$shipment = new CreateTagRequest();
$shipment->setAccessToken($token)
    ->setAccountNumber(123456789)
    ->setShipper($shipper)
    ->setRecipients($recipient)
    ->setLineItems($item)
    ->setServiceType(ServiceType::_FEDEX_GROUND)
    ->setPackagingType(PackagingType::_FEDEX_BOX)
    ->setPickupType(PickupType::_USE_SCHEDULED_PICKUP)
    ->setShipDatestamp('2024-01-15')
    ->useProduction() // Optional: use production environment
    ->request();
```

### Address Validation

Validate addresses using FedEx address validation service:

```php
use FedexRest\Services\AddressValidation\AddressValidation;
use FedexRest\Entity\Address;

$address = new Address();
$address->setStreetLines('123 Main St')
    ->setCity('Memphis')
    ->setStateOrProvince('TN')
    ->setPostalCode('38116')
    ->setCountryCode('US');

$validation = new AddressValidation();
$validation->setAccessToken($token)
    ->setAddress($address)
    ->useProduction() // Optional: use production environment
    ->request();
```

### Environment Switching

The package supports easy switching between sandbox (testing) and production environments:

```php
// Use sandbox (default)
$request->request();

// Use production
$request->useProduction()->request();

// Using Laravel's Conditionable trait (when available)
$request->when($isProduction, fn($req) => $req->useProduction())
    ->request();
```

### Raw Response

Get raw HTTP response instead of decoded JSON:

```php
$response = $request->asRaw()->request();
// Returns GuzzleHttp\Psr7\Response object
```

## Available Service Types

Use constants from `FedexRest\Services\Ship\Type\ServiceType`:

- `ServiceType::_FEDEX_GROUND`
- `ServiceType::_FEDEX_2_DAY`
- `ServiceType::_STANDARD_OVERNIGHT`
- `ServiceType::_PRIORITY_OVERNIGHT`
- `ServiceType::_INTERNATIONAL_PRIORITY`
- And many more...

## Available Packaging Types

Use constants from `FedexRest\Services\Ship\Type\PackagingType`:

- `PackagingType::_YOUR_PACKAGING`
- `PackagingType::_FEDEX_BOX`
- `PackagingType::_FEDEX_ENVELOPE`
- `PackagingType::_FEDEX_PAK`
- And more...

## Available Pickup Types

Use constants from `FedexRest\Services\Ship\Type\PickupType`:

- `PickupType::_USE_SCHEDULED_PICKUP`
- `PickupType::_DROPOFF_AT_FEDEX_LOCATION`
- `PickupType::_CONTACT_FEDEX_TO_SCHEDULE`

## Exception Handling

The package throws specific exceptions for missing required data:

- `MissingAccessTokenException` - When access token is not provided
- `MissingAuthCredentialsException` - When client credentials are missing
- `MissingTrackingNumberException` - When tracking number is not provided
- `MissingAccountNumberException` - When account number is missing
- `MissingLineItemException` - When line items are not provided

```php
use FedexRest\Exceptions\MissingAccessTokenException;

try {
    $response = $request->request();
} catch (MissingAccessTokenException $e) {
    // Handle missing access token
}
```

## Advanced Usage

### Custom Request Parameters

For shipping labels, you can customize request parameters:

```php
$shipment = new CreateTagRequest();
$params = $shipment->getRequestParams();
// Modify $params array as needed
$shipment->setRequestParams($params)
    ->setAccessToken($token)
    ->request();
```

## Laravel Integration

This package works seamlessly with Laravel 7-12+. The `switchableEnv` trait uses Laravel's `Conditionable` trait, allowing you to use the `when()` method:

```php
use FedexRest\Services\Track\TrackByTrackingNumberRequest;

$tracking = new TrackByTrackingNumberRequest();
$tracking->setAccessToken($token)
    ->setTrackingNumber('1234567890')
    ->when(config('app.env') === 'production', fn($req) => $req->useProduction())
    ->request();
```

## Support

For issues, questions, or contributions, please visit:
- [GitHub Issues](https://github.com/WhatArmy/FedexRest/issues)

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

Special thanks to [Sinnbeck](http://github.com/Sinnbeck) for the help and contributions.

## Changelog

### 1.0.0
- Initial stable release
- Support for Laravel 7-12+
- OAuth 2.0 authorization
- Package tracking
- Shipping label creation
- Address validation
- Environment switching (sandbox/production)
- Fluent interface with method chaining
