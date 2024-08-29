# Laravel Orlen Paczka Integration

This package provides integration with the Orlen Paczka API, allowing you to manage receivers, senders, returns, and business packs. Below are examples of how to use the models and requests provided by the package.

# Installation

To install the package, use Composer:

```bash
composer  require  mindgoner/laravel-orlen-paczka
```

# Usage
## Sending Parcels

Sending parcels requires configuring OPSender, OPReceiver, OPReturn, OPBusinessPack objects.

### OPReceiver

You can create a new pracel receiver using the `OPReceiver` model:
```php
use Mindgoner\LaravelOrlenPaczka\Models\OPReceiver;

$OPReceiver = new OPReceiver();
$OPReceiver->EMail = 'email@example.com';
$OPReceiver->FirstName = 'Mind';
$OPReceiver->LastName = 'Goner';
$OPReceiver->CompanyName = 'CompanyName';
$OPReceiver->StreetName = 'Example st.';
$OPReceiver->BuildingNumber = '1';
$OPReceiver->FlatNumber = '';
$OPReceiver->City = 'New York';
$OPReceiver->PostCode = '10069';
$OPReceiver->PhoneNumber = '123123123';
```
Alternatively, you can set the properties by passing dictionary (works with each model):
```php
use Mindgoner\LaravelOrlenPaczka\Models\OPReceiver;

$OPReceiver = new  OPReceiver(
	'EMail' => 'email@example.com',
	'FirstName' => 'Mind',
	'LastName' => 'Goner',
	'CompanyName' => 'CompanyName',
	'StreetName' => 'Example st.',
	'BuildingNumber' => '1',
	'FlatNumber' => '',
	'City' => 'New York',
	'PostCode' => '10069',
	'PhoneNumber' => '123123123'
);
```

### OPSender
To create a new sender, use the `OPSender` model:

```php
use Mindgoner\LaravelOrlenPaczka\Models\OPSender;

$OPSender = new OPSender();
$OPSender->SenderEMail = 'email@example.com';
$OPSender->SenderFirstName = 'Mind';
$OPSender->SenderLastName = 'Goner';
$OPSender->SenderCompanyName = 'CompanyName';
$OPSender->SenderStreetName = 'Another Example st.';
$OPSender->SenderBuildingNumber= '1';
$OPSender->SenderFlatNumber = '';
$OPSender->SenderCity = 'New York';
$OPSender->SenderPostCode = '10000';
$OPSender->SenderPhoneNumber = '321321321';
$OPSender->SenderOrders = 'order-number'; // Optionally
```

### OPReturn
`OPReturn` model is required to configure where to forward package, if parcel coudn't be delivered to receiver.
```php
use Mindgoner\LaravelOrlenPaczka\Models\OPReturn;

$OPReturn = new OPReturn();
$OPReturn->ReturnEMail = 'return@example.com';
$OPReturn->ReturnFirstName = 'John';
$OPReturn->ReturnLastName = 'Doe';
$OPReturn->ReturnCompanyName = 'ExampleCorp';
$OPReturn->ReturnStreetName = '123 Example Rd';
$OPReturn->ReturnBuildingNumber= '1A';
$OPReturn->ReturnFlatNumber = '5B';
$OPReturn->ReturnCity = 'ExampleCity';
$OPReturn->ReturnPostCode = '12345';
$OPReturn->ReturnPhoneNumber = '555-1234';
$OPReturn->ReturnPack = 'PACK-1234';
```
### OPBusinessPack
To create a new business pack, use the `OPBusinessPack` model:
```php
use Mindgoner\LaravelOrlenPaczka\Models\OPBusinessPack;

$OPBusinessPack = new OPBusinessPack([
	'DestinationCode' => 'DEST123',
	'AlternativeDestinationCode' => 'ALT456',
	'ReturnDestinationCode' => 'RET789',
	'BoxSize' => 'Medium',
	'PackValue' => 100.50,
	'CashOnDelivery' => true,
	'AmountCashOnDelivery' => 50.00,
	'Insurance' => true,
	'PrintAddress' => '123 Business St.',
	'PrintType' => 'Label',
	'TransferDescription' => 'Business pack for delivery'
]);
```

### Creating package in OrlenPaczka servers:
```php
use Mindgoner\LaravelOrlenPaczka\Requests\GenerateBusinessPack;

$GenerateBusinessPack = new GenerateBusinessPack(
	$OPSender,
	$OPBusinessPack,
	$OPReturn,
	$OPReceiver,
);
$response = $GenerateBusinessPack->send(); // Send method returns OP server's Response
```
